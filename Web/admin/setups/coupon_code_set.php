<?php 
	include('../auth_admin.php');
	require_once('../../app/themes/lib/system.lib.php');
	$conn = PetroFDS::ConnectDB();
	
	if($_POST['cate_status'] == "new"){
	
		$stmt = $conn->prepare('INSERT INTO coupon_code (code, price, valid_from, valid_to, status)
		VALUES(:code,:price,:from,:to,:status)');
			
		$stmt->execute(array(
			':code' => $_POST['code'],
			':price' => $_POST['price'],
			':from' => $_POST['from'],
			':to' => $_POST['to'],
			':status' => $_POST['status']
		));
					
		$rows = $stmt->fetchAll();
		
		header('Location: coupon_code');
	
	}else{
			
		$stmt = $conn->prepare('UPDATE coupon_code SET code=:code,price=:price, valid_from=:from , valid_to=:to ,status=:status WHERE id=:id');
		
		$stmt->execute(array(
			':code' => $_POST['code'],
			':price' => $_POST['price'],
			':from' => date("Y-m-d",strtotime($_POST['from'])),
			':to' => date("Y-m-d",strtotime($_POST['to'])),
			':status' => $_POST['status'],
			':id' => $_POST['id']			
		));
					
		$rows = $stmt->fetchAll();
		
		header('Location: coupon_code');
	}
?>