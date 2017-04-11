<?php
require_once('../app/themes/lib/system.lib.php');
$conn=PetroFDS::ConnectDB();

$response["success"] = 1;
$response["message"] = "Post Available!";
$response["posts"]   = array();

$id = $_REQUEST['order_detail_id'];

$sql = 'SELECT * FROM order_details WHERE id='.$id.'';

$stmt = $conn->prepare($sql);
				  
$stmt->execute();

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if($rows){
	$post['status'] = "Success";
	array_push($response["posts"], $post);
}else{
	$post['status'] = "Failed";
	array_push($response["posts"], $post);
}
echo json_encode($response);