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

$sql_detail_id_sales = '
SELECT id FROM `order_details`
';

$stmt_detail_id_sales = $conn->prepare($sql_detail_id_sales);			  

$stmt_detail_id_sales->execute();

$rows_detail_id_sales = $stmt_detail_id_sales->fetchAll(PDO::FETCH_ASSOC);

if($rows_detail_id_sales){
	$id_detail_sales='';
	foreach($rows_detail_id_sales as $row_detail_id_sales){
		$id_detail_sales .= $row_detail_id_sales['id'].',';
		$order_detail_id_sales = substr($id_detail_sales,0,strlen($id_detail_sales)-1);
	}
}

$id_product_sales = array($order_detail_id_sales);

$result_sales = array_count_values($id_product_sales);
asort($result_sales);
end($result_sales);
$product_id_sales = key($result_sales);

$sql_total_sales = 'SELECT DISTINCT order_detail_id, price_all FROM `orders` WHERE order_detail_id IN ('.$product_id_sales.') GROUP BY order_detail_id';
	
$stmt_total_sales = $conn->prepare($sql_total_sales);			  

$stmt_total_sales->execute();

$rows_total_sales = $stmt_total_sales->fetchAll(PDO::FETCH_ASSOC);

if($rows_total_sales){
	$total_sales='';
	$cnt=0;
	foreach($rows_total_sales as $row_total_sales){
		$total_sales += $row_total_sales['price_all'];
		$cnt++;
	}
}

$stmt_order = $conn->prepare("SELECT * FROM order_details ORDER BY ID DESC LIMIT 5");

$stmt_order->execute();
	
$rows_order = $stmt_order->fetchAll(PDO::FETCH_ASSOC);

if(isset($rows_order)){
	foreach($rows_order as $order){
		$stmt_user = $conn->prepare("SELECT * FROM users WHERE id=:id");

		$stmt_user->execute(array(
			':id' => $order['user_id'] 
		));

		$rows_user = $stmt_user->fetchAll(PDO::FETCH_ASSOC);
		
		if($rows_user){
			foreach($rows_user as $row_user){
				$post['fullname'] = $row_user['firstname'].' '.$row_user['lastname'];
			}
		}
		$stmt_price = $conn->prepare("SELECT DISTINCT order_detail_id, price_all FROM `orders` WHERE order_detail_id=:id");

		$stmt_price->execute(array(

			':id' => $order['id'] 
		));

		$rows_price = $stmt_price->fetchAll(PDO::FETCH_ASSOC);
		
		if($rows_price){
			$gr_total='';
			foreach($rows_price as $row_price){
				$gr_total += $row_price['price_all'];
				$post['grand_total'] = PetroFDS::get_currency().$gr_total;
			}
		}
		$status='';
		if($order['status']==0){
			$status = 'Pending';
		}else if($order['status']==1){
			$status = 'Accepted';
		}else if($order['status']==2){
			$status = 'Delivered';
		}else if($order['status']==3){
			$status = 'Decline';
		} 
		$post['status'] = $status;
		$post['lifetime_sales'] = PetroFDS::get_currency().PetroFDS::Float_To_Decimal($total_sales);
		$post['avg_sales'] = PetroFDS::get_currency().PetroFDS::Float_To_Decimal($total_sales/$cnt);
		array_push($response["posts"], $post);
	}
}

echo json_encode($response);