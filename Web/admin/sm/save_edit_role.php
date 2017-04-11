<?php

include('../auth_admin.php'); 
require_once('../../app/themes/lib/system.lib.php');
$conn = PetroFDS::ConnectDB();

$stmt = $conn->prepare('UPDATE roles SET role_name=:role_name,description=:description,date_modified=:date_modified,last_modified_by=:last_modified_by,status=:status WHERE role_id=:role_id');
			
$stmt->execute(array(
	':role_name' => $_POST['role_name'],
	':description' => $_POST['description'],
	':date_modified' => date('Y-m-d G:i:s'),
	':last_modified_by' => $_SESSION['SESS_USER_ID'],
	':status' => $_POST['status'],
	':role_id' => $_POST['main_id'],
));

header("location: ../sm/view_role");
?> 


