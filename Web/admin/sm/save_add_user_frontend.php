<?php

include('../auth_admin.php'); 
require_once('../../app/themes/lib/system.lib.php');
$conn = PetroFDS::ConnectDB();

$email = $_POST['email'];
$pass = $_POST['password'];
$firstname = $_POST['first_name'];
$lastname = $_POST['last_name'];
$contact_no = $_POST['contact_no'];
$post_code = $_POST['post_code'];
$add_1 = $_POST['add_1'];
$add_2 = $_POST['add_2'];
$city = $_POST['city'];
$status = $_POST['status'];

// Save Information
$stmt = $conn->prepare('INSERT INTO users (firstname, lastname, email, password, contact_no, add_1, add_2, city, post_code, status)
		VALUES(:firstname,:lastname,:email,:password,:contact_no,:add_1,:add_2,:city,:post_code,:status)');
			
$stmt->execute(array(
	':firstname' => $firstname,
	':lastname' => $lastname,
	':email' => $email,
	':password' => md5($pass),
	':contact_no' => $contact_no,
	':add_1' => $add_1,
	':add_2' => $add_2,
	':city' => $city,
	':post_code' => $post_code,
	':status' => $status
));


header("location: view_user_frontend");
?> 

