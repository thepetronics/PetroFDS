<?php
require_once('../app/themes/lib/system.lib.php');
$conn=PetroFDS::ConnectDB();

$response["success"] = 1;
$response["message"] = "Post Available!";
$response["posts"]   = array();
$price_pr='';
$sql_config = 'SELECT * FROM system_config WHERE status=1';

$stmt_config = $conn->prepare($sql_config);
				  
$stmt_config->execute();

$rows_config = $stmt_config->fetchAll(PDO::FETCH_ASSOC);

$id = $_REQUEST['id'];

$sql = 'SELECT * FROM order_details WHERE id='.$id.'';

$stmt = $conn->prepare($sql);
				  
$stmt->execute();

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if($rows){
	foreach($rows as $row){
		$sql_order = 'SELECT * FROM `orders` WHERE order_detail_id='.$row['id'].'';

		$stmt_order = $conn->prepare($sql_order);
						  
		$stmt_order->execute();
		
		$rows_order = $stmt_order->fetchAll(PDO::FETCH_ASSOC);
		
		if($rows_order){
			foreach($rows_order as $row_z){
				$post['user_id'] = $row_z['user_id'];
				$sql_userinfo = 'SELECT * FROM users WHERE id='.$row_z['user_id'].'';

				$stmt_userinfo = $conn->prepare($sql_userinfo);
								  
				$stmt_userinfo->execute();
				
				$rows_userinfo = $stmt_userinfo->fetchAll(PDO::FETCH_ASSOC);
				
				foreach($rows_userinfo as $row_userinfo){
					$post['customer_name'] = $row_userinfo['firstname'].' '.$row_userinfo['lastname'];
					$post['contact_no'] = $row_userinfo['contact_no'];
					$post['post_code'] = $row_userinfo['post_code'];
					$post['address'] = $row_userinfo['add_1'];
				}
				$price_pr += ($row_z["price"]*$row_z["quantity"]);
				$post['quantity'] = $row_z['quantity'];
				$post['price'] = number_format((float)$row_z['price'], 2, '.', '');
				$post['price_all'] = number_format((float)$row_z['price_all'], 2, '.', '');
				$post['pay_money_method'] = $row['pay_money_method'];
				$post['payment_method'] = $row['payment_method'];
				$post['remarks'] = $row['about_order'];
				
				$sql='SELECT * FROM menus WHERE id="'.$row_z['product_id'].'" ORDER BY name ASC';
				
				$stmt_s_cart = $conn->prepare($sql);
						
				$stmt_s_cart->execute();
				
				$rows_s_cart = $stmt_s_cart->fetchAll(PDO::FETCH_ASSOC);
				
				if($rows_s_cart){
					foreach($rows_s_cart as $row_s_cart){
						if(isset($row_z['option_yesno']) && $row_z['option_yesno']!=''){
							$opt_yesno = $row_z['option_yesno'];
							$opt_yesno = rtrim($opt_yesno,',');
							$sql_opt_1 = 'SELECT * FROM `option` WHERE id IN ('.$opt_yesno.')';
							
							$stmt_opt_1 = $conn->prepare($sql_opt_1);
									
							$stmt_opt_1->execute();
							
							$rows_opt_1 = $stmt_opt_1->fetchAll(PDO::FETCH_ASSOC);
						}
						if(isset($row_z['option_notype']) && $row_z['option_notype']!=''){
							$opt_notype = $row_z['option_notype'];
							$opt_notype_id = rtrim($opt_notype,',');
							$opt_notype_title = $row_z['option_notype_title'];
							$opt_notype_id_title = rtrim($opt_notype_title,',');
							$sql_opt_notype = 'SELECT o.title as option_title, om.title as option_menu_title 
											  FROM `option_menu` om 
											  LEFT JOIN `option` o ON o.option_id=om.option_id
											  WHERE om.id IN ('.$opt_notype_id.')';
							$stmt_opt_notype = $conn->prepare($sql_opt_notype);
						  
							$stmt_opt_notype->execute();
							
							$rows_opt_notype = $stmt_opt_notype->fetchAll(PDO::FETCH_ASSOC);
						}
						if($row_z['options'] != ''){
							$option_title_id = $row_z['options'];
							$option_title_id = rtrim($option_title_id,',');
							$sql_opt = 'SELECT * FROM `option_menu` WHERE id IN ('.$option_title_id.')';
							$stmt_opt = $conn->prepare($sql_opt);
									
							$stmt_opt->execute();
							
							$rows_opt = $stmt_opt->fetchAll(PDO::FETCH_ASSOC);
							if(isset($rows_opt)){
								$CART_TEXT = '';
								if(isset($rows_opt_1, $rows_opt_notype)){
									$CART_TEXT = '';
									if(isset($row_z['title_custom']) && $row_z['title_custom']!=''){
									  $sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row_z['title_custom'].'';
									  $stmt_customs = $conn->prepare($sql_customs);
									  $stmt_customs->execute();
									  $rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);
									  if($rows_customs){
										  foreach($rows_customs as $row_customs){
											  $CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name']. '';
										  }
									  }  
									}else{
									  $CART_TEXT .= ''.$row_s_cart['name']; 
									}
									foreach($rows_opt as $row_opt){
									  $CART_TEXT .= '<br/> - '.$row_opt['title'].''; 
									}
									if(isset($rows_opt_notype)){
									  foreach($rows_opt_notype as $row_opt_notype){
										$CART_TEXT .= '<br/> - '.$row_opt_notype['option_menu_title'].'';
									  }
									}
									foreach($rows_opt_1 as $row_opt_1){
									  $CART_TEXT .= '<br/> - '.$row_opt_1['title'];  
									}
								}else if(isset($rows_opt_1)){ 

									if(isset($row_z['title_custom']) && $row_z['title_custom']!=''){
									  $sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row_z['title_custom'].'';
									  $stmt_customs = $conn->prepare($sql_customs);
									  $stmt_customs->execute();
									  $rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);
									  if($rows_customs){
										  foreach($rows_customs as $row_customs){
											  $CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name']. '';
										  }
									  }  
									}else{
									  $CART_TEXT .= ''.$row_s_cart['name']; 
									}
									foreach($rows_opt as $row_opt){
									  $CART_TEXT .= '<br/> - '.$row_opt['title'].''; 
									}
									foreach($rows_opt_1 as $row_opt_1){
									  $CART_TEXT .= '<br/> - '.$row_opt_1['title'].'';  
									}
								}else if(isset($rows_opt_notype)){
									if(isset($row_z['title_custom']) && $row_z['title_custom']!=''){
									  $sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row_z['title_custom'].'';
									  $stmt_customs = $conn->prepare($sql_customs);
									  $stmt_customs->execute();
									  $rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);
									  if($rows_customs){
										  foreach($rows_customs as $row_customs){
											  $CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name']. '';
										  }
									  }  
									}else{
									  $CART_TEXT .= ''.$row_s_cart['name'].''; 
									}
									foreach($rows_opt as $row_opt){
									  $CART_TEXT .= '<br/> - '.$row_opt['title'].''; 
									}
									if(isset($rows_opt_notype)){
									  foreach($rows_opt_notype as $row_opt_notype){
										$CART_TEXT .= '<br/> - '.$row_opt_notype['option_menu_title'].'';
									  }
									}
								}else{
									$CART_TEXT = '';
									if(isset($row_z['title_custom']) && $row_z['title_custom']!=''){
									  $sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row_z['title_custom'].'';
									  $stmt_customs = $conn->prepare($sql_customs);
									  $stmt_customs->execute();
									  $rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);
									  if($rows_customs){
										  foreach($rows_customs as $row_customs){
											  $CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name']. '';
										  }
									  }  
									}else{
									  $CART_TEXT .= ''.$row_s_cart['name']; 
									}
									foreach($rows_opt as $row_opt){
									  $CART_TEXT .= '<br/> - '.$row_opt['title'].''; 
									}
								}
								$post['name'] = $CART_TEXT;
							}
						}else if(isset($row_z['option_yesno']) && $row_z['option_yesno']==''){
							$CART_TEXT = '';
							if(isset($row_z['title_custom']) && $row_z['title_custom']!=''){
							  $sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row_z['title_custom'].'';
							  $stmt_customs = $conn->prepare($sql_customs);
							  $stmt_customs->execute();
							  $rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);
							  if($rows_customs){
								  foreach($rows_customs as $row_customs){
									  if(isset($row_z['option_yesno']) && $row_z['option_yesno']!=''){
										  $CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name']. '';
									  }else if(isset($row_z['option_notype']) && $row_z['option_notype']!=''){
										  $CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name']. '';
									  }else{
										  $CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name']. '';
									  }
								  }
							  }  
							}else{
							  if(isset($row_z['option_yesno']) && $row_z['option_yesno']!=''){
								  $CART_TEXT .= ''.$row_s_cart['name'].'';
							  }else if(isset($row_z['option_notype']) && $row_z['option_notype']!=''){
								  $CART_TEXT .= ''.$row_s_cart['name'].'';
							  }else{
								  $CART_TEXT .= ''.$row_s_cart['name'].'';
							  } 
							}
							if(isset($rows_opt_notype)){
								foreach($rows_opt_notype as $row_opt_notype){
								  if(isset($row_opt_notype['option_menu_title']) && $row_opt_notype['option_menu_title']!=''){  
								  $CART_TEXT .= '<br/> - '.$row_opt_notype['option_menu_title'].'';
								  }
								}
							}
							$post['name'] = $CART_TEXT;
						}else{
							$CART_TEXT = '';
							if(isset($row_z['title_custom']) && $row_z['title_custom']!=''){
							  $sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row_z['title_custom'].'';
							  $stmt_customs = $conn->prepare($sql_customs);
							  $stmt_customs->execute();
							  $rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);
							  if($rows_customs){
								  foreach($rows_customs as $row_customs){
									  $CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name']. '';
								  }
							  }  
							}else{
							  $CART_TEXT .= ''.$row_s_cart['name']; 
							}
							if(isset($rows_opt_notype)){
								foreach($rows_opt_notype as $row_opt_notype){
								  $CART_TEXT .= '<br/> - '.$row_opt_notype['option_menu_title'].'';
								}
							}
							if(isset($rows_opt_1)){
							foreach($rows_opt_1 as $row_opt_1){
							  $CART_TEXT .= ' <br/> - '.$row_opt_1['title'];  
							}
							}
							$post['name'] = $CART_TEXT;  
						}
					}
				}
				if($rows_config){
					foreach($rows_config as $config){
						$post['currency'] = $config['website_currency'];
						$post['price_discount'] = $config['price_discount'];
					}
				}
				$post['delivery_charges'] = $row['delivery_charges'];
				array_push($response["posts"], $post);
			}
		}
	}
}

echo json_encode($response);