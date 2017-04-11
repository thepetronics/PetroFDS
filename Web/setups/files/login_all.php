<?php 
	session_start();
	require_once('../../app/themes/lib/system.lib.php');
	
	$conn = PetroFDS::ConnectDB();
	
	$sql='SELECT * FROM `users` WHERE email=:email AND password=:password';
	
	$stmt = $conn->prepare($sql);
			
	$stmt->execute(array(
		':email' => $_POST['email'],
		':password' => md5($_POST['password']),
	));
	
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if($rows){
	  foreach($rows as $row){
		session_regenerate_id();
		$_SESSION['LOGIN_USER_ID'] = $row['id'];
		$_SESSION['LOGIN_USER_FULLNAME'] = $row['firstname'].' '.$row['lastname'];
		$_SESSION['LOGIN_USER_FIRSTNAME'] = $row['firstname'];
		$_SESSION['LOGIN_USER_LASTNAME'] = $row['lastname'];
		$_SESSION['LOGIN_USER_EMAIL'] = $row['email'];
		header('Location: ../../account?login=success');	  
	  }
	}else{
		header('Location: ../../login?login=error');
	}
?>