<?php

include('../auth_admin.php'); 
require_once('../../app/themes/lib/system.lib.php');
$conn = PetroFDS::ConnectDB();

$username = $_POST['username'];
$pass = $_POST['password'];
$firstname = $_POST['first_name'];
$lastname = $_POST['last_name'];
$email = $_POST['email'];
$role_id = $_POST['role_id'];
$status = $_POST['status'];

// Save Information
$stmt = $conn->prepare('INSERT INTO admin (firstname, lastname, username, password, email, role_id, status)
		VALUES(:firstname,:lastname,:username,:password,:email,:role_id,:status)');
			
$stmt->execute(array(
	':firstname' => $firstname,
	':lastname' => $lastname,
	':username' => $username,
	':password' => md5($pass),
	':email' => $email,
	':role_id' => $role_id,
	':status' => $status
));


header("location: view_user");
?> 

