<?php 
	include('../auth_admin.php');
	require_once('../../app/themes/lib/system.lib.php');
	$conn = PetroFDS::ConnectDB();
		$option_id_custom = '';
		$ins_option_id_custom = '';
		$option_id = '';
		$ins_option_id = '';
		$find_option_id = '';
		if(isset($_POST['option']) && $_POST['option']!=''){
		foreach($_POST['option'] as $row=>$vsr) {
			$option_id .= $vsr.',';
			$ins_option_id = substr($option_id,0,strlen($option_id)-1);
		}
		}
		if(isset($_POST['option_no_type']) && $_POST['option_no_type']!=''){
		foreach($_POST['option_no_type'] as $row_autoid=>$vsr_autoid) {
			$find_option_id .= $vsr_autoid.',';
		}
		}
		$stmt = $conn->prepare('INSERT INTO menus (name, description, category_id, price, featured_product, required_options, image, options_with_type, created_by, date_created, status)
		VALUES(:name,:description,:category_id,:price,:featured_product,:required_options,:image,:options_with_type,:created_by,:date_created,:status)');
			
		$stmt->execute(array(
			':name' => $_POST['name_menu'],
			':description' => $_POST['description'],
			':category_id' => $_POST['cate_menu'],
			':price' => $_POST['price_menu'],
			':featured_product' => $_POST['featured_menu'],
			':required_options' => $_POST['required_options'],
			':image' => $_FILES['image']['name'],
			':options_with_type' => $ins_option_id,
			':created_by' => $_SESSION['SESS_USER_ID'],
			':date_created' => date('Y-m-d H:i:s a'),
			':status' => $_POST['status_menu']
		));
					
		$rows = $stmt->fetchAll();
		
		$stmt_2 = $conn->prepare("SELECT * FROM `menus` WHERE status=1 ORDER BY id DESC LIMIT 1");

		$stmt_2->execute();
	
		$rows_2 = $stmt_2->fetchAll(PDO::FETCH_ASSOC);
		
		if($rows_2){
		foreach($rows_2 as $row_2){
			if(isset($_POST['name']) && $_POST['name'] != ''){
			$stmt_1 = $conn->prepare('INSERT INTO menu_option_type_no (name, option_id,menu_id)
			VALUES(:name,:option_id,:menu_id)');
			foreach($_POST['name'] as $row_1=>$vsr_1) {
				if(!empty($vsr_1)){
					$stmt_1->execute(array(
						':name' => $vsr_1,
						':option_id' => $_POST['option_no_type'][$row_1],
						':menu_id' => $row_2['id']
					));
				}
			}
			}
			if(isset($_POST['title']) && $_POST['title'] != ''){
			$stmt_custom = $conn->prepare('INSERT INTO menu_custom_option (title, price, option_with_type, menu_id)
			VALUES(:title,:price,:option_with_type,:menu_id)');
			foreach($_POST['title'] as $row_custom=>$vsr_custom) {
				if(!empty($vsr_custom)){
					$stmt_custom->execute(array(
						':title' => $vsr_custom,
						':price' => $_POST['price'][$row_custom],
						':option_with_type' => $_POST['option_cust'][$row_custom],
						':menu_id' => $row_2['id']
					));
				}
			}
			}
			$target_path_new = "../../var/";
			$target_path = "../../var/".$row_2['id']."/";
			
			if ( ! is_dir($target_path_new)) {
				mkdir($target_path_new);
			}
			if ( ! is_dir($target_path)) {
				mkdir($target_path);
			}
			
			$target_path = $target_path . basename( $_FILES['image']['name']); 
			
			move_uploaded_file($_FILES['image']['tmp_name'], $target_path);
		}
		}
		header('Location: list_products');
?>