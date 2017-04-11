<?php 
	include('../auth_admin.php');
	require_once('../../app/themes/lib/system.lib.php');
	$conn = PetroFDS::ConnectDB();
	
	if($_POST['cate_status'] == "new"){
	
		$stmt = $conn->prepare('INSERT INTO category (name, image, created_by, date_created, status)
		VALUES(:category,:image,:created_by,:date_created,:status)');
			
		$stmt->execute(array(
			':category' => $_POST['category'],
			':image' => $_FILES['image']['name'],
			':created_by' => $_SESSION['SESS_USER_ID'],
			':date_created' => date('Y-m-d H:i:s a'),
			':status' => $_POST['status']
		));
					
		$rows = $stmt->fetchAll();
		
		$stmt_2 = $conn->prepare("SELECT * FROM `category` ORDER BY id DESC LIMIT 1");

		$stmt_2->execute();
	
		$rows_2 = $stmt_2->fetchAll(PDO::FETCH_ASSOC);
		
		if($rows_2){
		foreach($rows_2 as $row_2){
			$target_path_new = "../../var/";
			$target_path_new_1 = "../../var/cat_images";
			$target_path = "../../var/cat_images/".$row_2['id']."/";
			
			if ( ! is_dir($target_path_new)) {
					mkdir($target_path_new);
			}
			if ( ! is_dir($target_path_new_1)) {
					mkdir($target_path_new_1);
			}
			if ( ! is_dir($target_path)) {
				mkdir($target_path);
			}
			
			$target_path = $target_path . basename( $_FILES['image']['name']); 
			
			move_uploaded_file($_FILES['image']['tmp_name'], $target_path);
			}
		}
		
		header('Location: categories');
	
	}else{
		$stmt_2 = $conn->prepare("SELECT * FROM `category` WHERE id='".$_POST['cate_id']."'");

		$stmt_2->execute();
	
		$rows_2 = $stmt_2->fetchAll(PDO::FETCH_ASSOC);
		
		if($rows_2){
		foreach($rows_2 as $row_2){
		if($_FILES['image']['name'] == ''){
			
			$stmt = $conn->prepare('UPDATE category SET name=:category,date_modified=:date_modified,status=:status WHERE id=:id');
			
			$stmt->execute(array(
				':category' => $_POST['category'],
				':date_modified' => date('Y-m-d H:i:s a'),
				':status' => $_POST['status'],
				':id' => $_POST['cate_id']			
			));
						
			$rows = $stmt->fetchAll();
			
		}else{
		
		  $stmt = $conn->prepare('UPDATE category SET name=:category,image=:image,date_modified=:date_modified,status=:status WHERE id=:id');
			  
		  $stmt->execute(array(
			  ':category' => $_POST['category'],
			  ':image' => $_FILES['image']['name'],
			  ':date_modified' => date('Y-m-d H:i:s a'),
			  ':status' => $_POST['status'],
			  ':id' => $_POST['cate_id']			
		  ));
					  
		  $rows = $stmt->fetchAll();
		
		  $target_path_new = "../../var/";
		  $target_path_new_1 = "../../var/cat_images";
		  $target_path = "../../var/cat_images/".$row_2['id']."/";
		  
		  if ( ! is_dir($target_path_new)) {
				  mkdir($target_path_new);
		  }
		  if ( ! is_dir($target_path_new_1)) {
				  mkdir($target_path_new_1);
		  }
		  if ( ! is_dir($target_path)) {
			  mkdir($target_path);
		  }
		  
		  $target_path = $target_path . basename( $_FILES['image']['name']); 
		  
		  move_uploaded_file($_FILES['image']['tmp_name'], $target_path);
		}
		}
		}
		header('Location: categories');
	}
?>