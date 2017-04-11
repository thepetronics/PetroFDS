<?php
require_once('../../app/themes/lib/system.lib.php');
$conn=PetroFDS::ConnectDB();
PetroFDS::SetTimeZone();
$response["success"] = 1;

$response["message"] = "Post Available!";

$response["posts"]   = array();

$lstyear = date('Y', strtotime("-1 year"));

$thismonthfrom = date('Y-m-01');
$thismonthto = date('Y-m-d', mktime(0, 0, 0, date('m')+1, 0, date('Y')));
$lastmonthfrom = date("Y-n-j", strtotime("first day of previous month"));
$lastmonthto = date("Y-n-j", strtotime("last day of previous month"));
$thisyearfrom = date('Y-01-01');
$thisyearto = date('Y-12-d', mktime(0, 0, 0, date('12')+1, 0, date('Y')));
$lastyearfrom = date('Y-01-01', strtotime("-1 year"));
$lastyearto = date($lstyear.'-m-d', mktime(0, 0, 0, date('12')+1, 0, date('Y')));

$sql_sales_pr = '
SELECT date_created, id FROM `order_details` 
WHERE date_created BETWEEN "'.$thismonthfrom.'" 
AND "'.$thismonthto.'" ORDER BY id DESC LIMIT 5
';

$stmt_sales_pr = $conn->prepare($sql_sales_pr);			  

$stmt_sales_pr->execute();

$rows_sales_pr = $stmt_sales_pr->fetchAll(PDO::FETCH_ASSOC);

if($rows_sales_pr){
	$id_detail='';
	foreach($rows_sales_pr as $row_sales_pr){
		$id_detail .= $row_sales_pr['id'].',';
		$order_detail_id = substr($id_detail,0,strlen($id_detail)-1);
	}
}

$id_product = array($order_detail_id);

$result = array_count_values($id_product);
asort($result);
end($result);
$product_id = key($result);

$sql_sales2 = 'SELECT * FROM `menus` WHERE id IN ('.$product_id.')';
	
$stmt_sales2 = $conn->prepare($sql_sales2);			  

$stmt_sales2->execute();

$rows_sales2 = $stmt_sales2->fetchAll(PDO::FETCH_ASSOC);

if($rows_sales2){

	foreach($rows_sales2 as $row_sales2){
		$post['name'] = $row_sales2['name'];
		array_push($response["posts"], $post);
	}
}

echo json_encode($response);