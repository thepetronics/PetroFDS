<?php
require_once('../app/themes/lib/system.lib.php');

$conn = PetroFDS::ConnectDB();

$status = $_REQUEST['status'];
$id = $_REQUEST['id'];

if(isset($status) && $status=='1'){
	$time = $_REQUEST['time'];
	$sql  = 'UPDATE `order_details` SET status="'.$status.'", order_time="'.$time.'" WHERE id="'.$id.'"';
}else if(isset($status) && $status=='2'){
	$sql  = 'UPDATE `order_details` SET status="'.$status.'" WHERE id="'.$id.'"';
}else if(isset($status) && $status=='3'){
	$reason = $_REQUEST['reason'];
	$sql  = 'UPDATE `order_details` SET status="'.$status.'", decline_reason="'.$reason.'" WHERE id="'.$id.'"';
}
	
$stmt = $conn->prepare($sql);
				  
$stmt->execute();