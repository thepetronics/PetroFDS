<?php 
	session_start();
	require_once('../../app/themes/lib/system.lib.php');
	$conn = PetroFDS::ConnectDB();
	
	$Code = $_GET['code'];
	
	$stmt = $conn->prepare('SELECT * FROM coupon_code WHERE code=:code');
		
	$stmt->execute(array(
		':code' => $Code
	));
				
	$rows = $stmt->fetchAll();
	
	if($rows){
		foreach($rows as $row){
			$now = strtotime(date('Y-m-d'));
			$valid_from = strtotime($row['valid_from']);
			$valid_to = strtotime($row['valid_to']);
			if($valid_to<=$now){
				$stmt_exp = $conn->prepare('UPDATE coupon_code SET status=0 WHERE code=:code');
		
				$stmt_exp->execute(array(
					':code' => $Code
				));
				echo 'coupon=exp';
			}else if($now>=$valid_from){
				echo 'coupon='.$row['price'];
			}else{
				echo 'coupon=false';
			}
		}
	}else{
		$stmt_1 = $conn->prepare('SELECT * FROM `users` WHERE loyalty_id=:loyalty_id');
		
		$stmt_1->execute(array(
			':loyalty_id' => $Code
		));
					
		$rows_1 = $stmt_1->fetchAll();
		
		if($rows_1){
			foreach($rows_1 as $row_1){
				echo 'loyalty='.$row_1['loyalty_point'];
			}
		}else{
			echo 'Wrong Code';
		}
	}
	
?>