<?php 
	include('../auth_admin.php');
	require_once('../../app/themes/lib/system.lib.php');
	$conn = PetroFDS::ConnectDB();
	
	if($_POST['cate_status'] == "new"){
	
		$stmt = $conn->prepare('INSERT INTO option_type (type, created_by, date_created, status)
		VALUES(:type, :created_by, :date_created, :status)');
			
		$stmt->execute(array(
			':type' => $_POST['option_type'],
			':created_by' => $_SESSION['SESS_USER_ID'],
			':date_created' => date('Y-m-d H:i:s a'),
			':status' => $_POST['status']
		));
					
		$rows = $stmt->fetchAll();
		
		//header("Location: category_set?success=1&status=".$_POST['cate_status']."");
		header('Location: option_type');
	
	}else{
		
		$stmt = $conn->prepare('UPDATE option_type SET type=:type,date_modified=:date_modified,status=:status WHERE id=:id');
			
		$stmt->execute(array(
			':type' => $_POST['option_type'],
			':date_modified' => date('Y-m-d H:i:s a'),
			':status' => $_POST['status'],
			':id' => $_POST['cate_id']			
		));
					
		$rows = $stmt->fetchAll();
		
		//header("Location: category_set?success=1&status=".$_POST['cate_status']."&id=".$_POST['cate_id']."");
		header('Location: option_type');
	}
?>