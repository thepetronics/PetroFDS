<?php

session_start();

$email = $_GET['email'];

include_once '../../app/themes/lib/system.lib.php';

PetroFDS::SetTimeZone();

$conn = PetroFDS::ConnectDB();


$sql = 'SELECT * FROM users WHERE email="'.$email.'"';
$stmt = $conn->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
if($rows){
	foreach($rows as $row){
		$sql_update = 'UPDATE `users` SET password="'.md5('1234').'" WHERE id='.$row['id'].'';
		$stmt_update = $conn->prepare($sql_update);
		$stmt_update->execute();
	}
	include_once '../../EmailServer/resetpass.php';
}else{
	echo "Incorrect Email.";
}