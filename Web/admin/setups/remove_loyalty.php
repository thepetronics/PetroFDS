<?php 
	session_start();
	require_once('../../app/themes/lib/system.lib.php');
	$conn = PetroFDS::ConnectDB();
	
	$total = $_GET['total'];
	$ammount = $_GET['ammount'];
	
	$stmt_1 = $conn->prepare('UPDATE `users` SET loyalty_point=:loyalty_point WHERE id=:id');
	
	$stmt_1->execute(array(
		':id' => $_SESSION['LOGIN_USER_ID'],
		':loyalty_point' => ($total - $ammount)
	));
				
	$rows_1 = $stmt_1->fetchAll();
	
	echo 'Done';
	
?>