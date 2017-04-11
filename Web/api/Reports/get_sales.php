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

$sql = 'SELECT od.date_created,
(SELECT COUNT(id) FROM `order_details` WHERE date_created BETWEEN "'.$thismonthfrom.'" AND "'.$thismonthto.'") as total_thismonth,
(SELECT COUNT(id) FROM `order_details` WHERE date_created BETWEEN "'.$lastmonthfrom.'" AND "'.$lastmonthto.'") as total_lastmonth,
(SELECT COUNT(id) FROM `order_details` WHERE date_created BETWEEN "'.$thisyearfrom.'" AND "'.$thisyearto.'") as total_thisyear,
(SELECT COUNT(id) FROM `order_details` WHERE date_created BETWEEN "'.$lastyearfrom.'" AND "'.$lastyearto.'") as total_lastyear
FROM `order_details` od
';

$stmt = $conn->prepare($sql);			  

$stmt->execute();

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if($rows){

	foreach($rows as $row){
		$post['this_month'] = $row['total_thismonth'];
		$post['last_month'] = $row['total_lastmonth'];
		$post['this_year'] = $row['total_thisyear'];
		$post['last_year'] = $row['total_lastyear'];
	}
	array_push($response["posts"], $post);
}

echo json_encode($response);