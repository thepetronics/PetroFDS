<?php 
	include('../auth_admin.php');
	require_once('../../app/themes/lib/system.lib.php');
	$conn = PetroFDS::ConnectDB();
	
	$option_id = $_POST['option_id'];
	if($_POST['is_yes_no']=='1'){
		$stmt = $conn->prepare('INSERT INTO `option` (option_id, title, type_id, is_yes_no, input_type, price_option, created_by, date_created, status)
		VALUES(:option_id,:title,:opt_type,:is_yes_no,:input_type,:price_option,:created_by,:date_created,:status)');
			
		$stmt->execute(array(
			':option_id' => $option_id,
			':title' => $_POST['title_first'],
			':opt_type' => $_POST['opt_type'],
			':is_yes_no' => $_POST['is_yes_no'],
			':input_type' => $_POST['input_type'],
			':price_option' => $_POST['price_option'],
			':created_by' => $_SESSION['SESS_USER_ID'],
			':date_created' => date('Y-m-d H:i:s a'),
			':status' => $_POST['status']
		));
	}else{
		$stmt = $conn->prepare('INSERT INTO `option` (option_id, title, type_id, is_yes_no, input_type, price_option, created_by, date_created, status)
		VALUES(:option_id,:title,:opt_type,:is_yes_no,:input_type,:price_option,:created_by,:date_created,:status)');
			
		$stmt->execute(array(
			':option_id' => $option_id,
			':title' => $_POST['title_first'],
			':opt_type' => $_POST['opt_type'],
			':is_yes_no' => $_POST['is_yes_no'],
			':input_type' => $_POST['input_type'],
			':price_option' => $_POST['price_option'],
			':created_by' => $_SESSION['SESS_USER_ID'],
			':date_created' => date('Y-m-d H:i:s a'),
			':status' => $_POST['status']
		));
		
		if($_POST['title'] != "")
		{
			$stmt_2 = $conn->prepare('INSERT INTO `option_menu` (option_id, title, price, sort_order, deleted)
			VALUES(:option_id,:title,:price,:sort_order,:deleted)');
			
			foreach($_POST['title'] as $row=>$vsr) {
				$stmt_2->execute(array(
					':option_id' => $option_id,
					':title' => $vsr,
					':price' => $_POST['price'][$row],
					':sort_order' => $_POST['sort_order'][$row],
					':deleted' => $_POST['opt_deleted'][$row],
				));
			}
						
			$rows_2 = $stmt_2->fetchAll();
		}
	}
	header('Location: add_option');
?>