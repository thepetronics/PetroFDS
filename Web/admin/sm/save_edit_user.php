<?php

include('../auth_admin.php'); 
require_once('../../app/themes/lib/system.lib.php');
$conn = PetroFDS::ConnectDB();

$u_id = $_POST['main_id'];
$pass = $_POST['password'];
$firstname = $_POST['first_name'];
$lastname = $_POST['last_name'];
$email = $_POST['email'];
$status = $_POST['status'];
$role_id = $_POST['role_id'];

// Update Information
if($pass == "")
{
	if($role_id == ""){
		$stmt = $conn->prepare('UPDATE `admin` SET firstname=:firstname,lastname=:lastname,email=:email,status=:status WHERE id=:user_id');
		  
		$stmt->execute(array(
			':firstname' => $firstname,
			':lastname' => $lastname,
			':email' => $email,
			':status' => $status,
			':user_id' => $u_id
		));
	}else{
		$stmt = $conn->prepare('UPDATE `admin` SET firstname=:firstname,lastname=:lastname,email=:email,role_id=:role_id,status=:status WHERE id=:user_id');
		  
		$stmt->execute(array(
			':firstname' => $firstname,
			':lastname' => $lastname,
			':email' => $email,
			':role_id' => $role_id,
			':status' => $status,
			':user_id' => $u_id
		));
	}

}else{
	
	if($role_id == ""){
		$stmt = $conn->prepare('UPDATE `admin` SET firstname=:firstname,lastname=:lastname,password=:password,email=:email,status=:status WHERE id=:user_id');
				
		$stmt->execute(array(
			':firstname' => $firstname,
			':lastname' => $lastname,
			':password' => md5($pass),
			':email' => $email,
			':status' => $status,
			':user_id' => $u_id
		));
	}else{
		$stmt = $conn->prepare('UPDATE `admin` SET firstname=:firstname,lastname=:lastname,password=:password,email=:email,role_id=:role_id,status=:status WHERE id=:user_id');
		  
		$stmt->execute(array(
			':firstname' => $firstname,
			':lastname' => $lastname,
			':password' => md5($pass),
			':email' => $email,
			':role_id' => $role_id,
			':status' => $status,
			':user_id' => $u_id
		));
	}
}  

header("location: view_user");
?> 


