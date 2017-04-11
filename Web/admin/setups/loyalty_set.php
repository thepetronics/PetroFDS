<?php 
	include('../auth_admin.php');
	require_once('../../app/themes/lib/system.lib.php');
	$conn = PetroFDS::ConnectDB();
	
	if($_POST['cate_status'] == "new"){
	
		$stmt = $conn->prepare('INSERT INTO loyalty_points (loyalty_margin, loyalty_percent, status)
		VALUES(:loyalty_margin,:loyalty_percent,:status)');
			
		$stmt->execute(array(
			':loyalty_margin' => $_POST['margin'],
			':loyalty_percent' => $_POST['percent'],
			':status' => $_POST['status']
		));
					
		$rows = $stmt->fetchAll();
		
		header('Location: loyalty_points');
	
	}else{
			
		$stmt = $conn->prepare('UPDATE loyalty_points SET loyalty_margin=:loyalty_margin, loyalty_percent=:loyalty_percent,status=:status WHERE id=:id');
		
		$stmt->execute(array(
			':loyalty_margin' => $_POST['margin'],
			':loyalty_percent' => $_POST['percent'],
			':status' => $_POST['status'],
			':id' => $_POST['id']			
		));
					
		$rows = $stmt->fetchAll();
		
		header('Location: loyalty_points');
	}
?>