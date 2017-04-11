<?php
require_once('../../app/themes/lib/system.lib.php');
$conn = PetroFDS::ConnectDB();
PetroFDS::SetTimeZone();
$arr["posts"] = array();
$merge='';

for ($m=1; $m<=12; $m++) {
	$month_name = date('F', mktime(0,0,0,$m, 1, date('Y')));
	$month = date('m', mktime(0,0,0,$m, 1, date('Y')));
	$month_ini = new DateTime("first day of last month");
	$month_end = new DateTime("last day of last month");

$sql_sales = 'SELECT od.date_created, od.id as order_detail_id,
(SELECT COUNT(id) FROM `order_details` WHERE MONTH(date_created)="'.$month.'") as total
FROM `order_details` od
';

$stmt_sales = $conn->prepare($sql_sales);			  

$stmt_sales->execute();

$rows_sales = $stmt_sales->fetchAll(PDO::FETCH_ASSOC);
if($rows_sales){
	foreach($rows_sales as $row_sales){
		
	}
	$merge .= floatval($row_sales['total']).',';
	$months_merge = substr($merge,0,strlen($merge)-1);
	$post['cnt'.$m] = $row_sales['total'];
}
}
array_push($arr['posts'], $post);
echo json_encode($arr);
