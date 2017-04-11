<?php
require_once('../../app/themes/lib/system.lib.php');
$conn = PetroFDS::ConnectDB();
$arr["posts"] = array();
$sql_users_pie = '
SELECT * FROM `users` WHERE status=1
';

$stmt_users_pie = $conn->prepare($sql_users_pie);			  

$stmt_users_pie->execute();

$rows_users_pie = $stmt_users_pie->fetchAll(PDO::FETCH_ASSOC);

if($rows_users_pie){
	foreach($rows_users_pie as $row_users_pie){
		$sql_users_pie_order = 'SELECT COUNT(*) as orders_by_user FROM `order_details` WHERE user_id="'.$row_users_pie['id'].'"';
		
		$stmt_users_pie_order = $conn->prepare($sql_users_pie_order);			  
		
		$stmt_users_pie_order->execute();
		
		$rows_users_pie_order = $stmt_users_pie_order->fetchAll(PDO::FETCH_ASSOC);
		
		if($rows_users_pie_order){
			foreach($rows_users_pie_order as $row_users_pie_order){
				$post['name'] = $row_users_pie['firstname'].' '.$row_users_pie['lastname'];
				$post['total'] = $row_users_pie_order['orders_by_user'];
				array_push($arr["posts"],$post);
			}
		}
	}
}
echo json_encode($arr);