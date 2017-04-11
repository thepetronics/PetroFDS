<?php

include('../auth_admin.php'); 
require_once('../../app/themes/lib/system.lib.php');
$conn = PetroFDS::ConnectDB();

$stmt = $conn->prepare('INSERT INTO roles (role_name, description, date_created, created_by, status)
		VALUES(:role_name,:description,:date_created,:created_by,:status)');
			
$stmt->execute(array(
	':role_name' => $_POST['role_name'],
	':description' => $_POST['description'],
	':created_by' => $_SESSION['SESS_USER_ID'],
	':date_created' => date('Y-m-d H:i:s a'),
	':status' => $_POST['status']
));

$stmt_perm = $conn->prepare('SELECT role_id FROM roles ORDER BY role_id DESC LIMIT 1');
			
$stmt_perm->execute();

$rows_perm = $stmt_perm->fetchAll(PDO::FETCH_ASSOC);

if($rows_perm){
	foreach($rows_perm as $row_perm){
	$stmt_perm = $conn->prepare('INSERT INTO permissions (role_id, date_created, created_by)
			VALUES(:role_id,:date_created,:created_by)');
				
	$stmt_perm->execute(array(
		':role_id' => $row_perm['role_id'],
		':created_by' => $_SESSION['SESS_USER_ID'],
		':date_created' => date('Y-m-d H:i:s a')
	));
	}
}

header("location: ../sm/view_role");
?> 


