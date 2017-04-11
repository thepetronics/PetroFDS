<?php 

	error_reporting(0);

	session_start();
	

	include_once '../../app/themes/lib/system.lib.php';

	
	$conn = PetroFDS::ConnectDB();


	PetroFDS::SetTimeZone();


	if(isset($_SESSION['LOGIN_USER_ID'])){



		if(isset($_SESSION['CART_USER_ID'])){


			$remain_loyalty = $_POST['remain_loyalty'];

			$remain_loyalty_id = $_POST['remain_loyalty_id'];

			$total_price_all = $_POST['total_all'];



			$sql_get_id = 'SELECT * FROM cart WHERE ip="'.$_SESSION['CART_USER_ID'].'"';



			$stmt_get_id = $conn->prepare($sql_get_id);



			$stmt_get_id->execute();



			$rows_get_id = $stmt_get_id->fetchAll(PDO::FETCH_ASSOC);



			if($rows_get_id){

				

				$stmt_3 = $conn->prepare('INSERT INTO `order_details` (user_id, about_order, payment_method, pay_money_method, delivery_charges, discount, date_created)



				VALUES(:user_id,:about_order,:payment_method,:pay_money_method,:delivery_charges,:discount,:date_created)');



					



				$stmt_3->execute(array(



					':user_id' => $_SESSION['LOGIN_USER_ID'],



					':about_order' => $_POST['comment'],



					':payment_method' => $_POST['payment_method'],

					
					':pay_money_method' => $_POST['pay_money_method'],
										

					':delivery_charges' => $_POST['delivery_charges'],

					':discount' => PetroFDS::get_system_config('price_discount'),

					':date_created' => date('Y-m-d H:i:s a'),



				));

								

				$sql_orderid = 'SELECT * FROM order_details WHERE user_id="'.$_SESSION['LOGIN_USER_ID'].'" ORDER BY id DESC LIMIT 1';



				$stmt_orderid = $conn->prepare($sql_orderid);

	

				$stmt_orderid->execute();

	

				$rows_orderid = $stmt_orderid->fetchAll(PDO::FETCH_ASSOC);

	

				if($rows_orderid){

					foreach($rows_orderid as $row_orderid){

						$order_detail_id = $row_orderid['id'];

					}

				}


			$t_pr=0;
			foreach($rows_get_id as $row_get_id){



				$stmt_2 = $conn->prepare('INSERT INTO `orders` (order_detail_id, user_id, product_id, options, option_yesno, option_notype, option_notype_title, title_custom, price, price_all, quantity)



				VALUES(:order_detail_id,:user_id,:product_id,:options,:option_yesno,:option_notype,:option_notype_title,:title_custom,:price,:price_all,:quantity)');



				$sql='SELECT * FROM menus WHERE id IN ('.$row_get_id['product_id'].') ORDER BY name ASC';

				

				$stmt_s_cart = $conn->prepare($sql);



				$stmt_s_cart->execute();



				$rows_s_cart = $stmt_s_cart->fetchAll(PDO::FETCH_ASSOC);



				if($rows_s_cart){



					foreach($rows_s_cart as $vsr=>$row_s_cart){


						$stmt_2->execute(array(

						

							':order_detail_id' => $order_detail_id,



							':user_id' => $_SESSION['LOGIN_USER_ID'],



							':product_id' => $row_s_cart['id'],

							

							':options' => $row_get_id['options'],

							

							':option_yesno' => $row_get_id['option_yesno'],

							

							':option_notype' => $row_get_id['option_notype'],

							

							':option_notype_title' => $row_get_id['option_notype_title'],

							

							':title_custom' => $row_get_id['title_custom'],

							

							':price' => $_POST['price_pr'.$t_pr],

							':price_all' => $total_price_all,

							':quantity' => $row_get_id['quantity'],



						));

					}



				}

			
				$t_pr++;
			}
						
			
			/*if(isset($remain_loyalty) && $remain_loyalty!=''){
				$Loyalty_Qry_remove = "UPDATE `users` SET loyalty_point='".$remain_loyalty."', loyalty_id='".$remain_loyalty_id."' WHERE id='".$_SESSION['LOGIN_USER_ID']."'";
				PetroFDS::CustomQuery($Loyalty_Qry_remove);
			}*/
			
			
			$sql_get_loyalty = 'SELECT * FROM `loyalty_points`';

			

			$stmt_get_loyalty = $conn->prepare($sql_get_loyalty);



			$stmt_get_loyalty->execute();



			$rows_get_loyalty = $stmt_get_loyalty->fetchAll(PDO::FETCH_ASSOC);

			

			if($rows_get_loyalty){

				

				foreach($rows_get_loyalty as $row_get_loyalty){


					if($total_price_all >= $row_get_loyalty['loyalty_margin']){
						

						$sql_update_get_loyalty = "SELECT * FROM `users` WHERE id='".$_SESSION['LOGIN_USER_ID']."'";



						$stmt_update_get_loyalty = $conn->prepare($sql_update_get_loyalty);

			

						$stmt_update_get_loyalty->execute();

			

						$rows_update_get_loyalty = $stmt_update_get_loyalty->fetchAll(PDO::FETCH_ASSOC);

			

						if($rows_update_get_loyalty){
							
							foreach($rows_update_get_loyalty as $row_update_get_loyalty){

								$get_sub_val = ($row_get_loyalty['loyalty_margin'] - $total_price_all);
								
								$get_sub_val = str_replace('-', '', $get_sub_val);

								$get_sub_val = explode('.',$get_sub_val); 

								$loop_count = 0;

								$add_loyalty_p = '';

								for($i = 1; $i < $get_sub_val[0]+1; $i++){

									$loop_count = $loop_count + 1;

								}
								$add_loyalty_p .= ($row_get_loyalty['loyalty_percent']*$loop_count);
								if($row_update_get_loyalty['loyalty_point'] != ''){
									$total_loyalty_point=$remain_loyalty+$add_loyalty_p;
									$Loyalty_Qry = "UPDATE `users` SET loyalty_point='".$total_loyalty_point."', loyalty_id='".uniqid(rand())."' WHERE id='".$_SESSION['LOGIN_USER_ID']."'";
									PetroFDS::CustomQuery($Loyalty_Qry);
								}else{
									$Loyalty_Qry = "UPDATE `users` SET loyalty_point='".$add_loyalty_p."', loyalty_id='".uniqid(rand())."' WHERE id='".$_SESSION['LOGIN_USER_ID']."'";
									PetroFDS::CustomQuery($Loyalty_Qry);
								}

							}

						}

					}

				}

			}

			}else{



				header('Location: ../../checkout?error=true');



			}
			
			$sql_getMobToken = 'SELECT * FROM mobile_token';
			
			$stmt_getMobToken = $conn->prepare($sql_getMobToken);

			$stmt_getMobToken->execute();

			$rows_getMobToken = $stmt_getMobToken->fetchAll(PDO::FETCH_ASSOC);
			
			if($rows_getMobToken){

				foreach($rows_getMobToken as $row_getMobToken){
					PetroFDS::SendMobileNotification($row_getMobToken['token'],'1 New Order');		
				}
			}
			if(PetroFDS::get_email_config('admin_email')){
				include_once '../../EmailServer/sendorder.php';
			}else{
				PetroFDS::EmptySessionCart($_SERVER['REMOTE_ADDR']);
				header('Location: ../../success');
			}

		}



	}else{



		$total_price_all = $_POST['total_all'];



		$stmt = $conn->prepare('INSERT INTO `users` (firstname, lastname, email, password, contact_no, add_1, add_2, city, post_code, status, date_created)



		VALUES(:firstname,:lastname,:email,:password,:contact_no,:add_1,:add_2,:city,:post_code,:status,:date_created)');



			



		$stmt->execute(array(



			':firstname' => $_POST['firstname'],



			':lastname' => $_POST['lastname'],



			':email' => $_POST['email'],



			':password' => md5($_POST['password']),



			':contact_no' => $_POST['contact_no'],



			':add_1' => $_POST['add_1'],



			':add_2' => $_POST['add_2'],



			':city' => $_POST['city'],



			':post_code' => $_POST['post_code'],



			':status' => 1,



			':date_created' => date('Y-m-d H:i:s a'),



		));



					



		$rows = $stmt->fetchAll();



		



		if(isset($_SESSION['CART_USER_ID'])){



		



		$sql_user = 'SELECT * FROM users WHERE status=1 ORDER BY id DESC LIMIT 1';



		



		$stmt_user = $conn->prepare($sql_user);



					



		$stmt_user->execute();



		



		$rows_user = $stmt_user->fetchAll(PDO::FETCH_ASSOC);




		



			if($rows_user){



				foreach($rows_user as $row_user){			



				



					$sql_get_id = 'SELECT * FROM cart WHERE ip="'.$_SESSION['CART_USER_ID'].'"';



		   			



					$stmt_get_id = $conn->prepare($sql_get_id);



							



					$stmt_get_id->execute();



					



					$rows_get_id = $stmt_get_id->fetchAll(PDO::FETCH_ASSOC);



					



					if($rows_get_id){

						

						$stmt_3 = $conn->prepare('INSERT INTO `order_details` (user_id, about_order, payment_method, pay_money_method, delivery_charges, discount, date_created)



						VALUES(:user_id,:about_order,:payment_method,:pay_money_method,:delivery_charges,:discount,:date_created)');

	

							

	

						$stmt_3->execute(array(

	

							':user_id' => $row_user['id'],

	

							':about_order' => $_POST['comment'],

	

							':payment_method' => $_POST['payment_method'],
							
							
							':pay_money_method' => $_POST['pay_money_method'],
							

							':delivery_charges' => $_POST['delivery_charges'],

							':discount' => PetroFDS::get_system_config('price_discount'),

							':date_created' => date('Y-m-d H:i:s a'),

	

						));

						

						$sql_orderid = 'SELECT * FROM order_details WHERE user_id="'.$row_user['id'].'" ORDER BY id DESC LIMIT 1';



						$stmt_orderid = $conn->prepare($sql_orderid);

			

						$stmt_orderid->execute();

			

						$rows_orderid = $stmt_orderid->fetchAll(PDO::FETCH_ASSOC);

			

						if($rows_orderid){

							foreach($rows_orderid as $row_orderid){

								$order_detail_id = $row_orderid['id'];

							}

						}


					$t_pr=0;
					foreach($rows_get_id as $row_get_id){



				



					$stmt_2 = $conn->prepare('INSERT INTO `orders` (order_detail_id, user_id, product_id, options, option_yesno, option_notype, option_notype_title, title_custom, price, price_all, quantity)



					VALUES(:order_detail_id,:user_id,:product_id,:options,:option_yesno,:option_notype,:option_notype_title,:title_custom,:price,:price_all,:quantity)');



	



					$sql='SELECT * FROM menus WHERE id IN ('.$row_get_id['product_id'].') ORDER BY name ASC';



					



					$stmt_s_cart = $conn->prepare($sql);



							



					$stmt_s_cart->execute();



					



					$rows_s_cart = $stmt_s_cart->fetchAll(PDO::FETCH_ASSOC);



					



					if($rows_s_cart){



						foreach($rows_s_cart as $row_s_cart){


							$stmt_2->execute(array(

							

								':order_detail_id' => $order_detail_id,



								':user_id' => $row_user['id'],



								':product_id' => $row_s_cart['id'],

								

								':options' => $row_get_id['options'],

								

								':option_yesno' => $row_get_id['option_yesno'],

								

								':option_notype' => $row_get_id['option_notype'],

								

								':option_notype_title' => $row_get_id['option_notype_title'],

								

								':title_custom' => $row_get_id['title_custom'],

								
								':price' => $_POST['price_pr'.$t_pr],
								

								':price_all' => $total_price_all,

	

								':quantity' => $row_get_id['quantity'],



							));

						}



					}


						$t_pr++;
					}



					}
					

					$sql_get_loyalty = 'SELECT * FROM `loyalty_points`';

					

					$stmt_get_loyalty = $conn->prepare($sql_get_loyalty);

			

					$stmt_get_loyalty->execute();

			

					$rows_get_loyalty = $stmt_get_loyalty->fetchAll(PDO::FETCH_ASSOC);

					

					if($rows_get_loyalty){

						

						foreach($rows_get_loyalty as $row_get_loyalty){

							

							if($total_price_all >= $row_get_loyalty['loyalty_margin']){

								

								

								$sql_update_get_loyalty = 'SELECT * FROM `users` WHERE id="'.$row_user['id'].'"';

			

								$stmt_update_get_loyalty = $conn->prepare($sql_update_get_loyalty);

					

								$stmt_update_get_loyalty->execute();

					

								$rows_update_get_loyalty = $stmt_update_get_loyalty->fetchAll(PDO::FETCH_ASSOC);

					

								if($rows_update_get_loyalty){

									foreach($rows_update_get_loyalty as $row_update_get_loyalty){

										$get_sub_val = ($row_get_loyalty['loyalty_margin'] - $total_price_all);

										$get_sub_val = str_replace('-', '', $get_sub_val);

										$get_sub_val = explode('.',$get_sub_val); 

										$loop_count = 0;

										$add_loyalty_p = '';

										for($i = 1; $i < $get_sub_val[0]+1; $i++){

											$loop_count = $loop_count + 1;

										}

										$add_loyalty_p .= ($row_get_loyalty['loyalty_percent']*$loop_count);

										if($row_update_get_loyalty['loyalty_point'] != ''){
											$total_loyalty_point=$row_update_get_loyalty['loyalty_point']+$add_loyalty_p;
											$Loyalty_Qry = "UPDATE `users` SET loyalty_point='".$total_loyalty_point."', loyalty_id='".uniqid(rand())."' WHERE id='".$row_user['id']."'";
											PetroFDS::CustomQuery($Loyalty_Qry);

										}else{
											$Loyalty_Qry = "UPDATE `users` SET loyalty_point='".$add_loyalty_p."', loyalty_id='".uniqid(rand())."' WHERE id='".$row_user['id']."'";
											PetroFDS::CustomQuery($Loyalty_Qry);
										}

									}

								}

							}

						}

					}
					$sql_getMobToken = 'SELECT * FROM mobile_token';
			
					$stmt_getMobToken = $conn->prepare($sql_getMobToken);
		
					$stmt_getMobToken->execute();
		
					$rows_getMobToken = $stmt_getMobToken->fetchAll(PDO::FETCH_ASSOC);
					
					if($rows_getMobToken){
		
						foreach($rows_getMobToken as $row_getMobToken){
							PetroFDS::SendMobileNotification($row_getMobToken['token'],'1 New Order');		
						}
					}
					
					if(PetroFDS::get_email_config('admin_email')){
						include_once '../../EmailServer/sendorder.php';
					}else{
						PetroFDS::EmptySessionCart($_SERVER['REMOTE_ADDR']);
						header('Location: ../../success');
					}
					
				}



			}



		}else{



			header('Location: ../../checkout?error=true');



		}

	}