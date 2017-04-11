<?php

include('../auth_admin.php'); 
require_once('../../app/themes/lib/system.lib.php');
$conn = PetroFDS::ConnectDB();

$u_id = $_POST['main_id'];
$pass = $_POST['password'];
$firstname = $_POST['first_name'];
$lastname = $_POST['last_name'];
$contact_no = $_POST['contact_no'];
$post_code = $_POST['post_code'];
$add_1 = $_POST['add_1'];
$add_2 = $_POST['add_2'];
$city = $_POST['city'];
$status = $_POST['status'];

// Update Information
if($pass == "")
{
	$stmt = $conn->prepare('UPDATE `users` SET firstname=:firstname,lastname=:lastname,contact_no=:contact_no,add_1=:add_1,add_2=:add_2,city=:city,post_code=:post_code,status=:status WHERE id=:user_id');
	  
	$stmt->execute(array(
		':firstname' => $firstname,
		':lastname' => $lastname,
		':contact_no' => $contact_no,
		':add_1' => $add_1,
		':add_2' => $add_2,
		':city' => $city,
		':post_code' => $post_code,
		':status' => $status,
		':user_id' => $u_id
	));

}else{	
	$stmt = $conn->prepare('UPDATE `users` SET firstname=:firstname,lastname=:lastname,password=:password,contact_no=:contact_no,add_1=:add_1,add_2=:add_2,city=:city,post_code=:post_code,status=:status WHERE id=:user_id');
	  
	$stmt->execute(array(
		':firstname' => $firstname,
		':lastname' => $lastname,
		':password' => md5($pass),
		':contact_no' => $contact_no,
		':add_1' => $add_1,
		':add_2' => $add_2,
		':city' => $city,
		':post_code' => $post_code,
		':status' => $status,
		':user_id' => $u_id
	));
}  

header("location: view_user_frontend");
?> 


