<?php

require_once('../../app/themes/lib/system.lib.php');
$conn=PetroFDS::ConnectDB();

$response["success"] = 1;

$response["message"] = "Post Available!";

$response["posts"]   = array();

$total = $_REQUEST['total'];

$sql_config  = 'SELECT * FROM `system_config` WHERE status=1';



$stmt_config = $conn->prepare($sql_config);

				  

$stmt_config->execute();



$rows_config = $stmt_config->fetchAll(PDO::FETCH_ASSOC);



if($rows_config){

	foreach($rows_config as $row_config){

		$currency = $row_config['website_currency'];

	}

}





$sql  = 'SELECT * FROM `order_details` ORDER BY id DESC';



$stmt = $conn->prepare($sql);

				  

$stmt->execute();



$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);



if($rows){

	foreach($rows as $row){

		

	$sql_2  = 'SELECT * FROM `users` WHERE id='.$row['user_id'].'';



	$stmt_2 = $conn->prepare($sql_2);

					  

	$stmt_2->execute();

	

	$rows_2 = $stmt_2->fetchAll(PDO::FETCH_ASSOC);

	

	if($rows_2){

		foreach($rows_2 as $order){

			$sql_total  = 'SELECT * FROM `orders` WHERE order_detail_id='.$row['id'].' ORDER BY order_detail_id DESC';



			$stmt_total = $conn->prepare($sql_total);

							  

			$stmt_total->execute();

			

			$rows_total = $stmt_total->fetchAll(PDO::FETCH_ASSOC);

			

			if($rows_total){

				foreach($rows_total as $row_total){

					$total_price = $row_total['price_all'];					

				}

			}

			if(isset($total) && $stmt->rowCount() > $total){

				$total_order = ($stmt->rowCount()) - ($total);

				$post['order_detail_id'] = $row['id'];

				$post['user_id'] = $order['id'];

				$post['firstname'] = $order['firstname'];

				$post['email'] = $order['email'];

				$post['lastname'] = $order['lastname'];

				$post['add_1'] = $order['add_1'];

				$post['add_2'] = $order['add_2'];

				$post['city'] = $order['city'];

				$post['post_code'] = $order['post_code'];

				$post['loyalty_point'] = $order['loyalty_point'];

				$post['about_order'] = $row['about_order'];

				$post['payment_method'] = $row['payment_method'];

				$post['decline_reason'] = $row['decline_reason'];

				$post['order_time'] = $row['order_time'];

				$post['date_order'] = $row['date_created'];

				$post['total_price'] = $total_price;

				$post['currency'] = $currency;

				$post['status'] = $row['status'];

				$post['status_time'] = 'New';

				$post['total_order'] = $total_order;

			}else if(isset($total) && $stmt->rowCount() <= $total){

				$post['order_detail_id'] = $row['id'];

				$post['user_id'] = $order['id'];

				$post['firstname'] = $order['firstname'];

				$post['email'] = $order['email'];

				$post['lastname'] = $order['lastname'];

				$post['add_1'] = $order['add_1'];

				$post['add_2'] = $order['add_2'];

				$post['city'] = $order['city'];

				$post['post_code'] = $order['post_code'];

				$post['loyalty_point'] = $order['loyalty_point'];

				$post['about_order'] = $row['about_order'];

				$post['payment_method'] = $row['payment_method'];

				$post['decline_reason'] = $row['decline_reason'];

				$post['order_time'] = $row['order_time'];

				$post['date_order'] = $row['date_created'];

				$post['total_price'] = $total_price;

				$post['currency'] = $currency;

				$post['status'] = $row['status'];

				$post['status_time'] = 'Old';

				$post['total_order'] = '0';

			}

			array_push($response["posts"], $post);

		}

	}

	}

}

echo json_encode($response);