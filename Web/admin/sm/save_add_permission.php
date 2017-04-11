<?php
error_reporting(0);
session_start();
include('../auth_admin.php'); 
require_once('../../app/themes/lib/system.lib.php');
$conn = PetroFDS::ConnectDB();
PetroFDS::SetTimeZone();

$stmt = $conn->prepare('UPDATE permissions SET category=:category,product=:product,date_modified=:date_modified,modified_by=:modified_by,options=:options,loyaltypoint=:loyaltypoint,couponcode=:couponcode,optiontype=:optiontype,roles_management=:roles_management,postcode=:postcode,orders=:orders,user_management=:user_management,frontend_user_management=:frontend_user_management,mobile_setups=:mobile_setups,system_config=:system_config,email_setups=:email_setups WHERE role_id=:role_id AND permission_id=:permission_id');
			
$stmt->execute(array(
	':permission_id' => $_POST['permission_id'],
	':role_id' => $_POST['role_id'],
	':category' => $_POST['category'],
	':product' => $_POST['product'],
	':date_modified' => date('Y-m-d G:i:s'),
	':modified_by' => $_SESSION['SESS_USER_ID'],
	':options' => $_POST['options'],
	':loyaltypoint' => $_POST['loyaltypoint'],
	':couponcode' => $_POST['couponcode'],
	':optiontype' => $_POST['optiontype'],
	':roles_management' => $_POST['roles_management'],
	':postcode' => $_POST['postcode'],
	':orders' => $_POST['orders'],
	':user_management' => $_POST['user_management'],
	':frontend_user_management' => $_POST['frontend_user_management'],
	':mobile_setups' => $_POST['mobile_setups'],
	':system_config' => $_POST['system_config'],
	':email_setups' => $_POST['email_setups']
));

header("location: add_permission");
?> 


