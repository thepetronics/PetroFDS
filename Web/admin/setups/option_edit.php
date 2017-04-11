<?php
	error_reporting(0);
	include('../auth_admin.php');
	require_once('../../app/themes/lib/system.lib.php');
	$conn = PetroFDS::ConnectDB();
	
	$option_id = $_POST['option_id'];
	$id = $_POST['id'];
	$opt_id = $_POST['opt_id'];
	
	if($_POST['is_yes_no']=='1'){
		$stmt = $conn->prepare('UPDATE `option` SET title=:title,type_id=:opt_type,is_yes_no=:is_yes_no,input_type=:input_type,price_option=:price_option,
		date_modified=:date_modified,status=:status WHERE option_id=:option_id');
			
		$stmt->execute(array(
			':option_id' => $option_id,
			':title' => $_POST['title_first'],
			':opt_type' => $_POST['opt_type_edit'],
			':is_yes_no' => $_POST['is_yes_no'],
			':input_type' => $_POST['input_type'],
			':price_option' => $_POST['price_option'],
			':date_modified' => date('Y-m-d H:i:s a'),
			':status' => $_POST['status']
		));
					
		$rows = $stmt->fetchAll();
	}else{
		$stmt = $conn->prepare('UPDATE `option` SET title=:title,type_id=:opt_type,is_yes_no=:is_yes_no,input_type=:input_type,price_option=:price_option,
		date_modified=:date_modified,status=:status WHERE option_id=:option_id');
			
		$stmt->execute(array(
			':option_id' => $option_id,
			':title' => $_POST['title_first'],
			':opt_type' => $_POST['opt_type_edit'],
			':is_yes_no' => $_POST['is_yes_no'],
			':input_type' => $_POST['input_type'],
			':price_option' => $_POST['price_option'],
			':date_modified' => date('Y-m-d H:i:s a'),
			':status' => $_POST['status']
		));
					
		$rows = $stmt->fetchAll();
		
		if($_POST['title'] != "")
		{
			//Start taking values in an array
			$optinfo = array('title' => $_POST["title"],
						 'price' => $_POST["price"],					 
						 'sort_order' => $_POST["sort_order"],
						 'opt_id' => $_POST["opt_id"],
						 'opt_deleted' => $_POST["opt_deleted"]);
			//End taking values in an array			 
			$optinfoCount = count($optinfo["title"]);
			
			for ($i = 0; $i < $optinfoCount; $i++)
			{
				// START Custom Options UPDATE DATA
				if($optinfo['opt_id'][$i]!="")
				{
					$stmt_2 = $conn->prepare('UPDATE `option_menu` SET title=:title,price=:price,sort_order=:sort_order,deleted=:deleted WHERE id=:opt_id AND option_id=:option_id');
	
						$stmt_2->execute(array(
							':option_id' => $option_id,
							':title' => $_POST['title'][$i],
							':price' => $_POST['price'][$i],
							':sort_order' => $_POST['sort_order'][$i],
							':opt_id' => $_POST['opt_id'][$i],
							':deleted' => $_POST['opt_deleted'][$i],
						));
					
					$rows_2 = $stmt_2->fetchAll();
				}else{
					$stmt_2 = $conn->prepare('INSERT INTO `option_menu` (option_id, title, price, sort_order, deleted)
					VALUES(:option_id,:title,:price,:children,:sort_order,:deleted)');
					
						$stmt_2->execute(array(
							':option_id' => $option_id,
							':title' => $optinfo['title'][$i],
							':price' => $optinfo['price'][$i],
							':sort_order' => $optinfo['sort_order'][$i],
							':deleted' => $_POST['opt_deleted'][$i],
						));
								
					$rows_2 = $stmt_2->fetchAll();
				}
			}
		}
	}
	header('Location: edit_option?id='.$id.'&option_id='.$option_id.'');
?>