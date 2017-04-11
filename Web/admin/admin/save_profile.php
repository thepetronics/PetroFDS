<?php

include('../auth_admin.php'); 
require_once('../../app/themes/lib/system.lib.php');
$conn = PetroFDS::ConnectDB();

//User Information
$u_id = $_SESSION['SESS_USER_ID'];
$pass = $_POST['password'];
$save_ip = $_SESSION['USER_IP'];

//Personal Information
$title = $_POST['title'];
$firstname = $_POST['first_name'];
$lastname = $_POST['last_name'];
$email = $_POST['email'];

// Save Information
if($pass == "")
{
  $stmt = $conn->prepare('UPDATE `admin` SET firstname=:firstname,lastname=:lastname,email=:email WHERE id=:user_id');
		  
  $stmt->execute(array(
	  ':firstname' => $firstname,
	  ':lastname' => $lastname,
	  ':email' => $email,
	  ':user_id' => $u_id
  ));
			
$rows = $stmt->fetchAll();
}else{
  $stmt = $conn->prepare('UPDATE `admin` SET firstname=:firstname,lastname=:lastname,password=:password,email=:email WHERE id=:user_id');
		  
  $stmt->execute(array(
	  ':firstname' => $firstname,
	  ':lastname' => $lastname,
	  ':password' => md5($pass),
	  ':email' => $email,
	  ':user_id' => $u_id
  ));
			  
  $rows = $stmt->fetchAll();
}

header("location: ../admin/member");
?> 


