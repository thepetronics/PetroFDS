<?php

function deleteAll($directory, $empty = false) { 
    if(substr($directory,-1) == "/") { 
        $directory = substr($directory,0,-1); 
    } 

    if(!file_exists($directory) || !is_dir($directory)) { 
        return false; 
    } elseif(!is_readable($directory)) { 
        return false; 
    } else { 
        $directoryHandle = opendir($directory); 
        
        while ($contents = readdir($directoryHandle)) { 
            if($contents != '.' && $contents != '..') { 
                $path = $directory . "/" . $contents; 
                
                if(is_dir($path)) { 
                    deleteAll($path); 
                } else { 
                    unlink($path); 
                } 
            } 
        } 
        
        closedir($directoryHandle); 

        if($empty == false) { 
            if(!rmdir($directory)) { 
                return false; 
            } 
        } 
        
        return true; 
    } 
} 

	//Start session
	session_start();
	
	require_once('../app/themes/lib/system.lib.php');
	$conn = PetroFDS::ConnectDB();
		
	$stmt = $conn->prepare("SELECT * FROM admin WHERE username = :username and password = :password");

	$stmt->execute(array(
		':username' => $_POST['name'],
		':password' => md5(''.$_POST['pass'].'')
	));
	
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	if($rows){
		foreach($rows as $member){
				//Login Successful
				session_regenerate_id();
				$_SESSION['SESS_ID'] = date('ymd-gis');				
				$_SESSION['SESS_USER_ID'] = $member['id'];
				$_SESSION['SESS_USERNAME'] = $member['username'];			
				$_SESSION['SESS_FULL_NAME'] = $member['firstname']." ".$member['lastname'];
				$_SESSION['USER_IP'] = $_POST['my_ip'];
				$_SESSION['USER_EMAIL'] = $member['email'];
				$_SESSION['ROLE_ID'] = $member['role_id'];
				$_SESSION['LAST_LOGIN_TIME'] = $member['last_login'];
				$_SESSION['LAST_LOGIN_IP'] = $member['last_ip'];				
	
				deleteAll('session/'.$_SESSION['SESS_USERNAME']);
				mkdir("session/".$_SESSION['SESS_USERNAME']);
				$ourFileName = "session/".$_SESSION['SESS_USERNAME']."/".$_SESSION['SESS_ID'].".SESS";
				$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
				$stmt_role = $conn->prepare("SELECT * FROM permissions WHERE role_id=:role_id");
				$stmt_role->execute(array(
					':role_id' => $member['role_id']
				));
				$rows_role = $stmt_role->fetchAll(PDO::FETCH_ASSOC);
				if($rows_role){
					foreach($rows_role as $role){
						fwrite($ourFileHandle,json_encode($role));
					}
				}
				fclose($ourFileHandle);
				$ip = $_POST['my_ip'];
				$last_login = date('Y-m-d G:i:s');
				$u_id = $member['id'];
				$stmt = $conn->prepare('UPDATE admin SET last_ip=:ip, last_login=:last_login WHERE id=:u_id');
				$stmt->execute(array(
					':ip' => $ip,
					':last_login' => $last_login,
					':u_id' => $u_id
				));
				$rows = $stmt->fetchAll();
				header("location: admin/member");		
		}
	}else {
		//Login failed
		header("location: index?error=1");
		exit();
	}
?>