<?php
require_once('../app/themes/lib/system.lib.php');
$conn=PetroFDS::ConnectDB();
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

$sql  = 'SELECT * FROM `admin` WHERE username="'.$username.'" AND password="'.md5($password).'"';

$stmt = $conn->prepare($sql);
				  
$stmt->execute();

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if($rows){
	foreach($rows as $row){
		echo json_encode($row);
	}
}else{
}