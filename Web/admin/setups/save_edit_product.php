<?php 
	include('../auth_admin.php');
	require_once('../../app/themes/lib/system.lib.php');
	$conn = PetroFDS::ConnectDB();
		$option_id_custom = '';
		$ins_option_id_custom = '';
		$option_id = '';
		$ins_option_id = '';
		if(isset($_POST['option']) && $_POST['option']!=''){
		foreach($_POST['option'] as $row=>$vsr) {
			$option_id .= $vsr.',';
			$ins_option_id = substr($option_id,0,strlen($option_id)-1);
		}
		}
		if($_FILES['image']['name'] != ''){
			$stmt = $conn->prepare('UPDATE menus SET name=:name, description=:description, category_id=:category_id, price=:price, featured_product=:featured_product, required_options=:required_options, image=:image, options_with_type=:options, status=:status WHERE id=:menu_id');
			
			$stmt->execute(array(
				':name' => $_POST['name_menu'],
				':description' => $_POST['description'],
				':category_id' => $_POST['cate_menu'],
				':price' => $_POST['price_menu'],
				':featured_product' => $_POST['featured_menu'],
				':required_options' => $_POST['required_options'],
				':image' => $_FILES['image']['name'],
				':options' => $ins_option_id,
				':status' => $_POST['status_menu'],
				':menu_id' => $_POST['id']
			));
			
			$target_path_new = "../../var/";
			$target_path = "../../var/".$_POST['id']."/";
			
			if ( ! is_dir($target_path_new)) {
					mkdir($target_path_new);
			}
			if ( ! is_dir($target_path)) {
				mkdir($target_path);
			}
			
			$target_path = $target_path . basename( $_FILES['image']['name']); 
			
			move_uploaded_file($_FILES['image']['tmp_name'], $target_path);
		}else{
			$stmt = $conn->prepare('UPDATE menus SET name=:name, description=:description, category_id=:category_id, price=:price, featured_product=:featured_product, required_options=:required_options, options_with_type=:options, status=:status WHERE id=:menu_id');
			
			$stmt->execute(array(
			':name' => $_POST['name_menu'],
			':description' => $_POST['description'],
			':category_id' => $_POST['cate_menu'],
			':price' => $_POST['price_menu'],
			':featured_product' => $_POST['featured_menu'],
			':required_options' => $_POST['required_options'],
			':options' => $ins_option_id,
			':status' => $_POST['status_menu'],
			':menu_id' => $_POST['id']
			));
		}
		
		if($_POST['title'] != "")
		{
			//Start taking values in an array
			$optinfo_custom = array('custom_id' => $_POST["custom_id"],											
						 'title' => $_POST["title"],
						 'price' => $_POST["price"],
						 'option_cust' => $_POST["option_cust"],
						 'deleted' => $_POST["opt_deleted"]);
			//End taking values in an array			 
			$optnameCount_custom = count($optinfo_custom["title"]);
			
			for ($i = 0; $i < $optnameCount_custom; $i++)
			{
				// START Custom Options UPDATE DATA
				if(isset($optinfo_custom['custom_id'][$i]) && $optinfo_custom['custom_id'][$i]!="")
				{
					$stmt_2 = $conn->prepare('UPDATE `menu_custom_option` SET title=:title,price=:price,option_with_type=:option_with_type,deleted=:deleted 
					WHERE id=:id AND menu_id=:menu_id');
					$stmt_2->execute(array(
						':title' => $_POST['title'][$i],
						':price' => $_POST['price'][$i],
						':option_with_type' => $_POST['option_cust'][$i],
						':menu_id' => $_POST['id'],
						':id' => $_POST['custom_id'][$i],
						':deleted' => $_POST['opt_deleted'][$i],
					));
					
				}else{
					$stmt_2 = $conn->prepare('INSERT INTO `menu_custom_option` (title, price, option_with_type, menu_id, deleted)
					VALUES(:title,:price,:option_with_type,:menu_id,:deleted)');
					$stmt_2->execute(array(
						':menu_id' => $_POST['id'],
						':title' => $optinfo_custom['title'][$i],
						':price' => $optinfo_custom['price'][$i],
						':option_with_type' => $optinfo_custom['option_cust'][$i],
						':deleted' => $optinfo_custom['deleted'][$i],
					));								
				}
			}
		}
		
		if(isset($_POST['name']) && $_POST['name'] != "")
		{
			//Start taking values in an array
			$optinfo = array('line_id' => $_POST["line_id"],						  
						 'name' => $_POST["name"],
						 'option_id' => $_POST["option_no_type"],
						 'opt_deleted' => $_POST["opt_menu_deleted"]);
			//End taking values in an array			 
			$optnameCount = count($optinfo["name"]);
			
			for ($i = 0; $i < $optnameCount; $i++)

			{
				// START Custom Options UPDATE DATA
				if($optinfo['line_id'][$i]!="")
				{
					$stmt_2 = $conn->prepare('UPDATE `menu_option_type_no` SET name=:name,option_id=:option_id,deleted=:deleted WHERE id=:id AND menu_id=:menu_id');
					
					$stmt_2->execute(array(
						':name' => $_POST['name'][$i],
						':option_id' => $_POST['option_no_type'][$i],
						':menu_id' => $_POST['id'],
						':id' => $_POST['line_id'][$i],
						':deleted' => $_POST['opt_menu_deleted'][$i],
					));
					
				}else{
					if($optinfo['name'][$i]!=""){
					$stmt_2 = $conn->prepare('INSERT INTO `menu_option_type_no` (name, option_id, menu_id, deleted)
					VALUES(:name,:option_id,:menu_id,:deleted)');
				
					$stmt_2->execute(array(
						':menu_id' => $_POST['id'],
						':name' => $optinfo['name'][$i],
						':option_id' => $optinfo['option_id'][$i],
						':deleted' => $optinfo['opt_deleted'][$i],
					));								
					}
				}
			}
		}
		header("Location:edit_product?status=edit&id=".$_POST['id']."")
?>