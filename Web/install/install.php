<?php
include_once 'install.lib.php';

$host = $_POST['database_host'];
$database_name = $_POST['database_name'];
$username = $_POST['database_username'];
$password = $_POST['database_password'];
$admin_firstname = $_POST['admin_firstname'];
$admin_lastname = $_POST['admin_lastname'];
$admin_username = $_POST['admin_username'];
$admin_password = $_POST['admin_password'];
$website_title = $_POST['website_title'];
$timezone = $_POST['timezone'];
$currency = $_POST['currency'];

$pdo = new PDO("mysql:host=$host", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$configfile = '../app/themes/lib/db.cfg';
PetroFDSInstall::CreateConfig($configfile,$host,$database_name,$username,$password);	
$Setup = PetroFDSInstall::InstallApp($pdo,$database_name,'files/fds.sql',$admin_firstname,$admin_lastname,$admin_username,$admin_password,$website_title,$timezone,$currency);
if($Setup==true){
	header("Location:app?status=success");
}else{
	header("Location:app?status=failed");
}
?>