<?php

require_once('../app/themes/lib/system.lib.php');
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
	}
	if(isset($total) && $total==0){

		$post['status_time'] = 'Old';

		$post['total_order'] = '0';
		
	}else if(isset($total) && $stmt->rowCount() > $total){

		$total_order = ($stmt->rowCount()) - ($total);

		$post['status_time'] = 'New';

		$post['total_order'] = $total_order;

	}else if(isset($total) && $stmt->rowCount() <= $total){

		$post['status_time'] = 'Old';

		$post['total_order'] = '0';

	}

	array_push($response["posts"], $post);
}

echo json_encode($response);