<?php
require_once('../../app/themes/lib/system.lib.php');
$conn = PetroFDS::ConnectDB();
PetroFDS::SetTimeZone();
$arr["posts"] = array();
$lstyear = date('Y', strtotime("-1 year"));

$thismonthfrom = date('Y-m-01');
$thismonthto = date('Y-m-d', mktime(0, 0, 0, date('m')+1, 0, date('Y')));
$lastmonthfrom = date("Y-n-j", strtotime("first day of previous month"));
$lastmonthto = date("Y-n-j", strtotime("last day of previous month"));
$thisyearfrom = date('Y-01-01');
$thisyearto = date('Y-12-d', mktime(0, 0, 0, date('12')+1, 0, date('Y')));
$lastyearfrom = date('Y-01-01', strtotime("-1 year"));
$lastyearto = date($lstyear.'-m-d', mktime(0, 0, 0, date('12')+1, 0, date('Y')));

$sql_sales = 'SELECT od.date_created, od.id as order_detail_id,
(SELECT COUNT(id) FROM `order_details` WHERE date_created BETWEEN "'.$thismonthfrom.'" AND "'.$thismonthto.'") as total_thismonth,
(SELECT COUNT(id) FROM `order_details` WHERE date_created BETWEEN "'.$lastmonthfrom.'" AND "'.$lastmonthto.'") as total_lastmonth,
(SELECT COUNT(id) FROM `order_details` WHERE date_created BETWEEN "'.$thisyearfrom.'"  AND  "'.$thisyearto.'") as total_thisyear,
(SELECT COUNT(id) FROM `order_details` WHERE date_created BETWEEN "'.$lastyearfrom.'"  AND  "'.$lastyearto.'") as total_lastyear
FROM `order_details` od
';

$stmt_sales = $conn->prepare($sql_sales);			  

$stmt_sales->execute();

$rows_sales = $stmt_sales->fetchAll(PDO::FETCH_ASSOC);
if($rows_sales){
	foreach($rows_sales as $row_sales){
		$post['this_month'] = str_pad($row_sales['total_thismonth'], 2, 0, STR_PAD_LEFT);
		$post['last_month'] = str_pad($row_sales['total_lastmonth'], 2, 0, STR_PAD_LEFT);
		$post['this_year'] = str_pad($row_sales['total_thisyear'], 2, 0, STR_PAD_LEFT);
		$post['last_year'] = str_pad($row_sales['total_lastyear'], 2, 0, STR_PAD_LEFT);
	}
	array_push($arr['posts'], $post);
}
echo json_encode($arr);
