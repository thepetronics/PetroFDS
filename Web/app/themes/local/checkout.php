<?php

session_start();

include_once 'app/themes/lib/system.lib.php';

$conn = PetroFDS::ConnectDB();
?>

<!DOCTYPE html>

<!--[if IE 9]><html class="ie ie9"> <![endif]-->

<html><head>

<meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="keywords" content="">

    <meta name="description" content="">

    <meta name="author" content="">

    <title>Checkout</title>



    <!-- Favicons-->

    <link rel="shortcut icon" href="" type="image/x-icon">

    <link rel="apple-touch-icon" type="image/x-icon" href="">

    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="">

    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="">

    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="">

    

    <!-- GOOGLE WEB FONT -->

    <link href="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/css.css" rel="stylesheet" type="text/css">



    <!-- BASE CSS -->

    <link href="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/base.css" rel="stylesheet">

    

    <!-- Radio and check inputs -->

    <link href="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/grey.css" rel="stylesheet">

    

    <!-- Main Style -->

	<link rel="stylesheet" href="<?php echo PetroFDS::get_system_config('website_path_media') ?>/css_new/style.css">

	

	<!-- Skins -->

	<link rel="stylesheet" href="<?php echo PetroFDS::get_system_config('website_path_media') ?>/css_new/skins/green.css">

	

	<!-- Responsive Style -->

	<link rel="stylesheet" href="<?php echo PetroFDS::get_system_config('website_path_media') ?>/css_new/responsive.css">

    

    <link rel="stylesheet" type="text/css" href="<?php echo PetroFDS::get_system_config('website_path_media') ?>/css1/bootstrap-select.css">



    <!--[if lt IE 9]>

      <script src="js/html5shiv.min.js"></script>

      <script src="js/respond.min.js"></script>

    <![endif]-->



</head>



<body style="overflow: visible;">

<?php include_once 'main_content/header.php'; ?>

<!--[if lte IE 8]>

    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a>.</p>

<![endif]-->



<!-- Content ================================================== -->

<div class="container margin_60_35">

	<div id="container_pin">

    	<div class="row">    

        <div class="col-md-12">

            <div class="pin-wrapper"><div style="width:100%;" id="cart_box">
				
                <h3>Your order <i class="icon-shopping-cart pull-right" style="margin-top:10px;"></i></h3>

                <form action="setups/files/user_checkout.php" method="post" enctype="multipart/form-data" id="form" name="form" onSubmit="return validateForm();">

                <table class="table table-striped cart-list" id="pr_table">



                      <thead>



                          <tr>



                              <td>Product Name</td>



                              <td></td>



                              <td>Quantity</td>



                              <td>Price</td>



                              <td>Total</td>



                          </tr>



                      </thead>



                      <tbody>



                      <?php

					  $WORLDPAY_TEXT = '';

					  if(isset($_SESSION['CART_USER_ID'])){



						  $item_total = 0;
						  $total_product = 0;



						  



						  $sql_get_id = 'SELECT * FROM cart WHERE ip="'.$_SESSION['CART_USER_ID'].'"';

						  



						  $stmt_get_id = $conn->prepare($sql_get_id);



								  



						  $stmt_get_id->execute();



						  



						  $rows_get_id = $stmt_get_id->fetchAll(PDO::FETCH_ASSOC);

						  

						  

						  $sql_get_price_sum = 'SELECT SUM(price) as total FROM cart WHERE ip="'.$_SESSION['CART_USER_ID'].'"';

						  

						  $stmt_get_price_sum = $conn->prepare($sql_get_price_sum);



						  $stmt_get_price_sum->execute();



						  $rows_get_price_sum = $stmt_get_price_sum->fetchAll(PDO::FETCH_ASSOC);

						  



						  if($rows_get_id){



						  foreach($rows_get_id as $row_get_id){



						  $sql='SELECT * FROM menus WHERE id IN ('.$row_get_id['product_id'].') ORDER BY name ASC';



						  



						  $stmt_s_cart = $conn->prepare($sql);



								  



						  $stmt_s_cart->execute();



						  



						  $rows_s_cart = $stmt_s_cart->fetchAll(PDO::FETCH_ASSOC);



						  



						  if($rows_s_cart){



							  foreach($rows_s_cart as $row_s_cart){



								$qty = $row_get_id['quantity'];



								$price = PetroFDS::Float_To_Decimal($row_get_id['price']);



								$total_with_qty = PetroFDS::Float_To_Decimal($row_get_id['price'])*$qty;

								

								if($rows_get_price_sum){

						  			foreach($rows_get_price_sum as $row_get_price_sum){

										$all_total = PetroFDS::Float_To_Decimal($row_get_price_sum['total']);

						  			}

								}



						  ?>



							  <tr>



                              	<?php

								if(isset($row_get_id['option_yesno']) && $row_get_id['option_yesno']!=''){

		  	  $opt_yesno = $row_get_id['option_yesno'];

			  $opt_yesno = rtrim($opt_yesno,',');

			  $sql_opt_1 = 'SELECT * FROM `option` WHERE id IN ('.$opt_yesno.')';

			  

			  $stmt_opt_1 = $conn->prepare($sql_opt_1);

					  

			  $stmt_opt_1->execute();

			  

			  $rows_opt_1 = $stmt_opt_1->fetchAll(PDO::FETCH_ASSOC);

		  }

		  if(isset($row_get_id['option_notype']) && $row_get_id['option_notype']!=''){

			  $opt_notype = $row_get_id['option_notype'];

			  $opt_notype_id = rtrim($opt_notype,',');

			  $opt_notype_title = $row_get_id['option_notype_title'];

			  $opt_notype_id_title = rtrim($opt_notype_title,',');

		  	  $sql_opt_notype = 'SELECT o.title as option_title, om.title as option_menu_title 

			  					FROM `option_menu` om 

								LEFT JOIN `option` o ON o.option_id=om.option_id

								WHERE om.id IN ('.$opt_notype_id.')';

			  $stmt_opt_notype = $conn->prepare($sql_opt_notype);

			

			  $stmt_opt_notype->execute();

			  

			  $rows_opt_notype = $stmt_opt_notype->fetchAll(PDO::FETCH_ASSOC);

		  }

		  if($row_get_id['options'] != ''){

			  $option_title_id = $row_get_id['options'];

			  $option_title_id = rtrim($option_title_id,',');

			  $sql_opt = 'SELECT * FROM `option_menu` WHERE id IN ('.$option_title_id.')';

			  $stmt_opt = $conn->prepare($sql_opt);

					  

			  $stmt_opt->execute();

			  

			  $rows_opt = $stmt_opt->fetchAll(PDO::FETCH_ASSOC);

			  if(isset($rows_opt)){

				  $CART_TEXT = '';

				  if(isset($rows_opt_1, $rows_opt_notype)){
					  
					  $CART_TEXT .= '<td class="name"><strong class="pr_name">';

					  if(isset($row_get_id['title_custom']) && $row_get_id['title_custom']!=''){

						$sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row_get_id['title_custom'].'';

						$stmt_customs = $conn->prepare($sql_customs);

						$stmt_customs->execute();

						$rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);

						if($rows_customs){

							foreach($rows_customs as $row_customs){
								if($rows_opt){
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'</strong> <small><br/>';
									$WORLDPAY_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <br/>';
								}else if($rows_opt_1){
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'</strong> <small><br/>';
									$WORLDPAY_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <br/>';
								}else if($rows_opt_notype){
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'</strong> <small><br/>';
									$WORLDPAY_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <br/>';
								}else{
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'</strong> <small>';
									$WORLDPAY_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'';
								}
							}

						}  

					  }else{
						if($rows_opt){
					  		$CART_TEXT .= $row_s_cart['name'].'</strong> <small><br/>';
							$WORLDPAY_TEXT .= $row_s_cart['name'].' <br/>'; 
						}else if($rows_opt_1){
							$CART_TEXT .= $row_s_cart['name'].'</strong> <small><br/>';
							$WORLDPAY_TEXT .= $row_s_cart['name'].' <br/>';
						}else if($rows_opt_notype){
							$CART_TEXT .= $row_s_cart['name'].'</strong> <small><br/>';
							$WORLDPAY_TEXT .= $row_s_cart['name'].' <br/>';
						}else{
							$CART_TEXT .= $row_s_cart['name'].'</strong> <small>';
							$WORLDPAY_TEXT .= $row_s_cart['name'].'';
						}
					  }

					  foreach($rows_opt as $row_opt){

						$CART_TEXT .= '- '.$row_opt['title'].'<br/>';
						$WORLDPAY_TEXT .= '- '.$row_opt['title'].'<br/>'; 

					  }

					  if(isset($rows_opt_notype)){

						foreach($rows_opt_notype as $row_opt_notype){

							if(isset($row_get_id['cart_type']) && $row_get_id['cart_type']=="options"){

								if(isset($row_get_id['option_notype_title']) && $row_get_id['option_notype_title']!=''){

						  			$CART_TEXT .= '- '.$row_opt_notype['option_menu_title'].'<br/>';
									$WORLDPAY_TEXT .= '- '.$row_opt_notype['option_menu_title'].'<br/>';

								}

							}

						}

					  }

					  foreach($rows_opt_1 as $row_opt_1){

						$CART_TEXT .= '- '.$row_opt_1['title'].'<br/>';
						$WORLDPAY_TEXT .= '- '.$row_opt_1['title'].'<br/>';  

					  }

					  $CART_TEXT .= '</small></td>';

				  }else if(isset($rows_opt_1)){ 
				  
				  	  $CART_TEXT .= '<td class="name"><strong class="pr_name">';

					  if(isset($row_get_id['title_custom']) && $row_get_id['title_custom']!=''){

						$sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row_get_id['title_custom'].'';

						$stmt_customs = $conn->prepare($sql_customs);

						$stmt_customs->execute();

						$rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);

						if($rows_customs){

							foreach($rows_customs as $row_customs){
								if($rows_opt){
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'</strong> <small><br/>';
									$WORLDPAY_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <br/>';
								}else if($rows_opt_1){
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'</strong> <small><br/>';
									$WORLDPAY_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <br/>';
								}else{
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'</strong> <small>';
									$WORLDPAY_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'';
								}
							}

						}  

					  }else{
						if($rows_opt){						
					  		$CART_TEXT .= $row_s_cart['name'].'</strong> <small><br/>';
							$WORLDPAY_TEXT .= $row_s_cart['name'].' <br/>'; 
						}else if($rows_opt_1){
							$CART_TEXT .= $row_s_cart['name'].'</strong> <small><br/>';
							$WORLDPAY_TEXT .= $row_s_cart['name'].' <br/>';
						}else{
							$CART_TEXT .= $row_s_cart['name'].'</strong> <small>';
							$WORLDPAY_TEXT .= $row_s_cart['name'].'';
						}
					  }

					  foreach($rows_opt as $row_opt){

						$CART_TEXT .= '- '.$row_opt['title'].'<br/>';
						$WORLDPAY_TEXT .= '- '.$row_opt['title'].'<br/>'; 

					  }

					  foreach($rows_opt_1 as $row_opt_1){

						$CART_TEXT .= '- '.$row_opt_1['title'].'<br/>';
						$WORLDPAY_TEXT .= '- '.$row_opt_1['title'].'<br/>';  

					  }

					  $CART_TEXT .= '</small></td>';

				  }else if(isset($rows_opt_notype)){
					  
					  $CART_TEXT .= '<td class="name"><strong class="pr_name">';

					  if(isset($row_get_id['title_custom']) && $row_get_id['title_custom']!=''){

						$sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row_get_id['title_custom'].'';

						$stmt_customs = $conn->prepare($sql_customs);

						$stmt_customs->execute();

						$rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);


						if($rows_customs){

							foreach($rows_customs as $row_customs){
								if($rows_opt){
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'</strong> <small><br/>';
									$WORLDPAY_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <br/>';
								}else if($rows_opt_notype){
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'</strong> <small><br/>';
									$WORLDPAY_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <br/>';
								}else{
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'</strong> <small>';
									$WORLDPAY_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'';
								}
							}

						}  

					  }else{
						if($rows_opt){
					  		$CART_TEXT .= $row_s_cart['name'].'</strong> <small><br/>';
							$WORLDPAY_TEXT .= $row_s_cart['name'].' <br/>'; 
						}else if($rows_opt_notype){
							$CART_TEXT .= $row_s_cart['name'].'</strong> <small><br/>';
							$WORLDPAY_TEXT .= $row_s_cart['name'].' <br/>';
						}else{
							$CART_TEXT .= $row_s_cart['name'].'</strong> <small>';
							$WORLDPAY_TEXT .= $row_s_cart['name'].'';
						}
					  }

					  foreach($rows_opt as $row_opt){

						$CART_TEXT .= '- '.$row_opt['title'].'<br/>';
						$WORLDPAY_TEXT .= '- '.$row_opt['title'].'<br/>'; 

					  }

					  if(isset($rows_opt_notype)){

						foreach($rows_opt_notype as $row_opt_notype){

							if(isset($row_get_id['cart_type']) && $row_get_id['cart_type']=="options"){

								if(isset($row_get_id['option_notype_title']) && $row_get_id['option_notype_title']!=''){

						  			$CART_TEXT .= '- '.$row_opt_notype['option_menu_title'].'<br/>';
									$WORLDPAY_TEXT .= '- '.$row_opt_notype['option_menu_title'].'<br/>';

								}

							}

						}

					  }

					  $CART_TEXT .= '</small></td>';

				  }else{
					  
					  $CART_TEXT = '';
					  
					  $CART_TEXT .= '<td class="name"><strong class="pr_name">';

					  if(isset($row_get_id['title_custom']) && $row_get_id['title_custom']!=''){

						$sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row_get_id['title_custom'].'';

						$stmt_customs = $conn->prepare($sql_customs);

						$stmt_customs->execute();

						$rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);

						if($rows_customs){

							foreach($rows_customs as $row_customs){
								if(isset($rows_opt)){
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'</strong> <small><br/>';
									$WORLDPAY_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <br/>';
								}else{
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'</strong> <small>';
									$WORLDPAY_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'';
								}
							}

						}  

					  }else{
						if($rows_opt){
					  		$CART_TEXT .= $row_s_cart['name'].'</strong> <small><br/>';
							$WORLDPAY_TEXT .= $row_s_cart['name'].' <br/>'; 
						}else{
							$CART_TEXT .= $row_s_cart['name'].'</strong> <small>';
							$WORLDPAY_TEXT .= $row_s_cart['name'].'';
						}
					  }

					  foreach($rows_opt as $row_opt){

						$CART_TEXT .= '- '.$row_opt['title'].'<br/>';
						$WORLDPAY_TEXT .= '- '.$row_opt['title'].'<br/>'; 

					  }

					  $CART_TEXT .= '</small></td>';

				  }

				  echo $CART_TEXT;

			  }

		  }else if(isset($row_get_id['option_yesno']) && $row_get_id['option_yesno']==''){

			  $CART_TEXT = '';
			  
			  $CART_TEXT = '<td class="name"><strong class="pr_name">';

			  if(isset($row_get_id['title_custom']) && $row_get_id['title_custom']!=''){

				$sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row_get_id['title_custom'].'';

				$stmt_customs = $conn->prepare($sql_customs);

				$stmt_customs->execute();

				$rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);

				if($rows_customs){

					foreach($rows_customs as $row_customs){

						if(isset($row_get_id['option_yesno']) && $row_get_id['option_yesno']!=''){

							$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'</strong> <small><br/>';
							$WORLDPAY_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <br/>';

						}else if(isset($row_get_id['option_notype']) && $row_get_id['option_notype']!=''){

							$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'</strong> <small><br/>';
							$WORLDPAY_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <br/>';

						}else{

							$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'</strong> <small>';
							$WORLDPAY_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'';
						}

					}

				}  

			  }else{

				if(isset($row_get_id['option_yesno']) && $row_get_id['option_yesno']!=''){

					$CART_TEXT .= $row_s_cart['name'].'</strong> <small><br/>';
					$WORLDPAY_TEXT .= $row_s_cart['name'].' <br/>';

				}else if(isset($row_get_id['option_notype']) && $row_get_id['option_notype']!=''){

					$CART_TEXT .= $row_s_cart['name'].'</strong> <small><br/>';
					$WORLDPAY_TEXT .= $row_s_cart['name'].' <br/>';

				}else{

					$CART_TEXT .= $row_s_cart['name'].'</strong> <small>';
					$WORLDPAY_TEXT .= $row_s_cart['name'].'';
				} 

			  }

			  if(isset($rows_opt_notype)){

				  foreach($rows_opt_notype as $row_opt_notype){

					if(isset($row_opt_notype['option_menu_title']) && $row_opt_notype['option_menu_title']!=''){ 

						if(isset($row_get_id['cart_type']) && $row_get_id['cart_type']=="options"){ 

							if(isset($row_get_id['option_notype_title']) && $row_get_id['option_notype_title']!=''){

								$CART_TEXT .= '- '.$row_opt_notype['option_menu_title'].'<br/>';
								$WORLDPAY_TEXT .= '- '.$row_opt_notype['option_menu_title'].'<br/>';

							}

						}

					}

				  }

			  }

			  $CART_TEXT .= '</small></td>';

			  echo $CART_TEXT;


		  }else{

			  $CART_TEXT = '';
			  
			  $CART_TEXT = '<td class="name"><strong class="pr_name">';

			  if(isset($row_get_id['title_custom']) && $row_get_id['title_custom']!=''){

				$sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row_get_id['title_custom'].'';

				$stmt_customs = $conn->prepare($sql_customs);

				$stmt_customs->execute();

				$rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);

				if($rows_customs){

					foreach($rows_customs as $row_customs){
						if($rows_opt_notype){
							$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'</strong> <small><br/>';
							$WORLDPAY_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <br/>';
						}else if($rows_opt_1){
							$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'</strong> <small><br/>';
							$WORLDPAY_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <br/>';							
						}else{
							$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'</strong> <small>';
							$WORLDPAY_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'';
						}
					}

				}  

			  }else{
				if($rows_opt_notype){
					$CART_TEXT .= $row_s_cart['name'].'</strong> <small><br/>';
					$WORLDPAY_TEXT .= $row_s_cart['name'].' <br/>'; 
				}else if($rows_opt_1){
					$CART_TEXT .= $row_s_cart['name'].'</strong> <small><br/>';
					$WORLDPAY_TEXT .= $row_s_cart['name'].' <br/>';
				}else{
					$CART_TEXT .= $row_s_cart['name'].'</strong> <small>';
					$WORLDPAY_TEXT .= $row_s_cart['name'].'';
				}
			  }

			  if(isset($rows_opt_notype)){

				  foreach($rows_opt_notype as $row_opt_notype){

					  if(isset($row_get_id['cart_type']) && $row_get_id['cart_type']=="options"){

						  if(isset($row_get_id['option_notype_title']) && $row_get_id['option_notype_title']!=''){

							$CART_TEXT .= '- '.$row_opt_notype['option_menu_title'].'<br/>';
							$WORLDPAY_TEXT .= '- '.$row_opt_notype['option_menu_title'].'<br/>';

						  }

					  }

				  }

			  }

			  if(isset($rows_opt_1)){

			  foreach($rows_opt_1 as $row_opt_1){

				$CART_TEXT .= '- '.$row_opt_1['title'].'<br/>';
				$WORLDPAY_TEXT .= '- '.$row_opt_1['title'].'<br/>';  

			  }

			  }

			  $CART_TEXT .= '</small></td>';

			  echo $CART_TEXT;  

		  }



								?>



								  <td class="model"></td>



								  <td class="quantity"><?php echo $qty ?></td>



								  <td class="price"><?php echo PetroFDS::get_currency().PetroFDS::Float_To_Decimal($price) ?></td>

                                  

								  <td class="total"><input type="hidden" name="price_pr<?php echo $total_product; ?>" value="<?php echo PetroFDS::Float_To_Decimal($total_with_qty) ?>"><?php echo PetroFDS::get_currency().PetroFDS::Float_To_Decimal($total_with_qty) ?></td>



							  </tr>



						  <?php


								$total_product++;
						  		$item_total += ($row_get_id["price"]*$row_get_id["quantity"]);



							  }



						  }



						  }



						  }


						
						?>
						<input type="hidden" name="total_product" id="total_product" value="<?php echo $total_product; ?>">


                      </tbody>



                      <tfoot>



                          <tr>



                              <td class="price" colspan="4"><b>Sub-Total:</b></td>



                              <td class="total"><?php echo PetroFDS::get_currency().PetroFDS::Float_To_Decimal($item_total); ?></td>



                          </tr>	

                          <?php

						  if(isset($_SESSION['POST_CODE']) && $_SESSION['POST_CODE']!='' && PetroFDS::get_system_config('price_discount')!='0'){

							  $getdeliverarea = PetroFDS::getDeliveryAreas('AND postcode="'.$_SESSION['POST_CODE'].'"');

							  if(isset($getdeliverarea)){

								  foreach($getdeliverarea as $getdeliverarea_data){

						  ?>

                                  <tr id="dev_chrg">

                        				<input type="hidden" name="delivery_charges" id="delivery_charges" value="<?php echo PetroFDS::Float_To_Decimal($getdeliverarea_data['price']) ?>">

                                      <td class="price" colspan="4"><b>Delivery Charges:</b></td>

        

                                      <td class="total"><?php echo PetroFDS::get_currency().PetroFDS::Float_To_Decimal($getdeliverarea_data['price']) ?></td>

        

                                  </tr>

                                  <tr id="discount">

        

                                      <td class="price" colspan="4"><b>Discount:</b></td>

        

                                      <td class="total"><?php echo PetroFDS::get_system_config('price_discount').'%' ?></td>

        

                                  </tr>

                          <?php

								  }

								  $add_val = PetroFDS::Get_Discount_Price($item_total,PetroFDS::get_system_config('price_discount'));
								  $all_total = $add_val + $getdeliverarea_data['price'];

							  }else{

						  ?>

                          	<tr id="discount">



                              <td class="price" colspan="4"><b>Discount:</b></td>



                              <td class="total"><?php echo PetroFDS::get_system_config('price_discount').'%' ?></td>



                            </tr>

                          <?php

						  		$all_total = PetroFDS::Get_Discount_Price($item_total,PetroFDS::get_system_config('price_discount'));

							  }

						  }else if(isset($_SESSION['POST_CODE']) && $_SESSION['POST_CODE']!=''){

							  $getdeliverarea = PetroFDS::getDeliveryAreas('AND postcode="'.$_SESSION['POST_CODE'].'"');

							  if(isset($getdeliverarea)){

								  foreach($getdeliverarea as $getdeliverarea_data){

						  ?>

                          <tr id="dev_chrg">

                          		<input type="hidden" name="delivery_charges" id="delivery_charges" value="<?php echo PetroFDS::Float_To_Decimal($getdeliverarea_data['price']) ?>">

                              <td class="price" colspan="4"><b>Delivery Charges:</b></td>



                              <td class="total"><?php echo PetroFDS::get_currency().PetroFDS::Float_To_Decimal($getdeliverarea_data['price']) ?></td>



                          </tr>
						  <?php

						  			$all_total = $item_total + $getdeliverarea_data['price'];
								  }

							  }

						  }else if(PetroFDS::get_system_config('price_discount')!='0'){

						  ?>

                          <tr id="discount">



                              <td class="price" colspan="4"><b>Discount:</b></td>



                              <td class="total"><?php echo PetroFDS::get_system_config('price_discount').'%' ?></td>



                          </tr>

                          <?php

						  		$all_total = PetroFDS::Get_Discount_Price($item_total,PetroFDS::get_system_config('price_discount'));

						  }

						  ?>

                          <tr id="coupon" style="display:none;">



                              <td class="price" colspan="4"><b>Coupon Code Discount:</b></td>



                              <td class="total" id="coupon_price"></td>



                          </tr>



                          <tr id="loyalty" style="display:none;">



                              <td class="price" colspan="4"><b>Loyalty Point Discount:</b></td>



                              <td class="total" id="loyalty_percent"></td>



                          </tr>

						  <?php
						  if(isset($_SESSION['LOGIN_USER_ID'])){
						  $sql_loyalty='SELECT * FROM `users` WHERE id=:user_id';

						  $stmt_loyalty = $conn->prepare($sql_loyalty);
	  
						  $stmt_loyalty->execute(array(
	  
							  ':user_id' => $_SESSION['LOGIN_USER_ID']
	  
						  ));
	  
						  $rows_loyalty = $stmt_loyalty->fetchAll(PDO::FETCH_ASSOC);
	
						  if($rows_loyalty){
	  
							foreach($rows_loyalty as $row_loyalty){
								
						  		if(isset($row_loyalty['loyalty_point']) && $row_loyalty['loyalty_point']!=''){

						  ?>

                                    <div class="modal fade" id="loyalty_modal" role="dialog">
        
                                    <div class="modal-dialog">
        
                                    
        
                                      <!-- Modal content-->
        
                                      <div class="modal-content">
        
                                        <div class="modal-header">
        
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
        
                                          <h4 class="modal-title" style="color:#000">Loyalty Point Deduction</h4>
        
                                        </div>
        
                                        <div class="modal-body" style="color:#000">
        
                                          <p><?php echo '<label>Your Loyalty Point is: '.$row_loyalty['loyalty_point'].'</label>' ?></p>
        
                                          <label>Please Enter Number of Ammount:</label><br/>
        
                                          <input type="text" name="loyalty_ammount" id="loyalty_ammount" class="form-text required fluid" >
        
                                        </div>
        
                                        <div class="modal-footer">
        
                                          <button type="button" class="btn btn-success" onClick="Remove_loyalty(document.getElementById('loyalty_ammount').value,<?php echo $row_loyalty['loyalty_point'] ?>,'<?php echo PetroFDS::get_currency() ?>')" data-dismiss="modal">Done</button>
        
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
                                        </div>
        
                                      </div>
        
                                      
        
                                    </div>
        
                                    </div>

                          <?php

						  		}
							}
						  }
						  }
						  ?>

                          <tr>



                              <td class="price" colspan="4"><b>Total:</b></td>



                              <td class="total" id="total"><?php

							  echo PetroFDS::get_currency().PetroFDS::Float_To_Decimal($all_total); 



							  ?></td><input type="hidden" id="total_all" name="total_all" value="<?php echo PetroFDS::Float_To_Decimal($all_total) ?>">



                          </tr>



                      </tfoot>



                      <?php



					  }else{



						  



					  }



					  ?>



                  </table>

            </div></div><!-- End cart_box -->


        </div><!-- End col-md-3 -->

		</div><!-- End row1 -->

		<div class="row">

        <?php

		if(isset($_SESSION['LOGIN_USER_ID'])){

		?>

			<div class="col-md-12">


                <div class="page-content">

                    <h2 class="page-content-title"><i class="icon-arrow-right"></i>RETURNING CUSTOMER</h2>

                    <?php

					$sql='SELECT * FROM `users` WHERE id=:user_id';

	

	

	

					$stmt = $conn->prepare($sql);

	

							

	

					$stmt->execute(array(

	

						':user_id' => $_SESSION['LOGIN_USER_ID']

	

					));

	

					

	

					$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	

					

	

					if($rows){

	

					  foreach($rows as $row){

	

					?>

                    <div class="form-style form-js">

                        <div class="row">

                            <div class="col-md-6">

                                <p>

                                    <label>Firstname: <?php echo $row['firstname'] ?></label>

                                </p>

                                <p>

                                    <label>Email: <?php echo $row['email'] ?></label>

                                </p>

                            </div>

                            <div class="col-md-6">

                                <p>

                                    <label>Lastname: <?php echo $row['lastname'] ?></label>

                                </p>

                                <p>

                                    <label>Telephone No: <?php echo $row['contact_no'] ?></label>

                                </p>

                            </div>

                            <div class="col-md-6">    

                                <p>

                                    <label>Address 1: <?php echo $row['add_1'] ?></label>

                                </p>

                                <p>

                                    <label>City: <?php echo $row['city'] ?></label>

                                </p>

                            </div>

                            <div class="col-md-6">

                                <p>

                                    <label>Address 2: <?php echo $row['add_2'] ?></label>

                                </p>

                                <p>

                                    <label>Post Code: <?php echo $row['post_code'] ?></label>

                                </p>

                            </div>

                            <div class="col-md-6">

                                <p>

                                <?php

                                if(isset($row['loyalty_point']) && $row['loyalty_point']!=''){

								?>

                                	<label>Loyalty Points: <span id="point_loyalty"><?php echo $row['loyalty_point'].PetroFDS::get_currency(); ?></span></label>

                                    <input type="hidden" id="remain_loyalty" name="remain_loyalty" value="<?php echo $row['loyalty_point'] ?>">

                                <?php

								}else{

								?>

                                	<label>Loyalty Points: 0<?php echo PetroFDS::get_currency(); ?></label>

                                <?php

								}

								?>

                                </p>

                            </div>

                            <div class="col-md-6">

                                <p>

                                <?php

								if(isset($row['loyalty_id']) && $row['loyalty_id']!=''){

								?>

                                	<label>Loyalty ID: <span id="loyal_id"><?php echo $row['loyalty_id'] ?></span></label>

                                    <input type="hidden" id="remain_loyalty_id" name="remain_loyalty_id" value="<?php echo $row['loyalty_id'] ?>">

                                <?php

								}

								?>

                                </p>

                            </div>

                            <div class="col-md-6">

                                <p>

                                	<a href="setups/files/logout"><input name="submit" class="submit button small color" id="submit" value="Logout" type="button">&nbsp;</a>

                                </p>

                            </div>

                        </div>

                    </div>

                    <?php

					  }

					}

					?>

                </div>

            </div>

            <?php

		}else{			

			?>

            <div class="col-md-4">

                <div class="page-content">

                    <h2 class="page-content-title"><i class="icon-arrow-right"></i>RETURNING CUSTOMER</h2>

                    <?php

					if($_GET['login']=='error'){

					?>

                    	<label style="color:red;">Email or Password is invalid</label>

                    <?php

					}

					?>

                      <p>

                          <input type="text" class="required-item" value="" name="login_email" id="login_email" aria-required="true" placeholder="Email">

                      </p>

                      <p>

                          <input type="password" class="required-item" id="login_password" name="login_password" value="" aria-required="true" placeholder="Password">

                      </p>

                      <p>

                          <input type="button" onClick="validateCheckoutLogin();" id="login" name="login" class="submit button small color" value="Login">

                      </p>
					  <p>

                          <a href="javascript:void(0)" onClick="ForgotModal()">FORGOT PASSWORD?</a>
                          
                          <div class="modal fade" id="forgot_password" role="dialog">
        
                          <div class="modal-dialog">

                          

                            <!-- Modal content-->

                            <div class="modal-content">

                              <div class="modal-header">

                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                                <h4 class="modal-title" style="color:#000">Enter Email Address</h4>

                              </div>

                              <div class="modal-body" style="color:#000">

                                <input type="email" name="forgot_email" id="forgot_email" class="form-text required fluid" >

                              </div>

                              <div class="modal-footer">

                                <button type="button" class="btn btn-success" onClick="resetpass(document.getElementById('forgot_email').value)">Done</button>


                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                              </div>

                            </div>

                            

                          </div>

                          </div>

                      </p>
                </div>

            </div>

            <div class="col-md-8">

                <div class="page-content">

                    <h2 class="page-content-title"><i class="icon-group"></i>REGISTRATION</h2>

                    <label id="valid_user" style="color:#f00;"></label>

                    <label id="valid_postcode" style="color:#f00;"></label>

                    <div class="form-style form-js">

                        <div class="row">

                            <div class="col-md-6">

                                <p>

                                    <input type="text" class="required-item" value="" name="firstname" id="firstname" aria-required="true" placeholder="Firstname">

                                </p>

                            </div>

                            <div class="col-md-6">

                                <p>

                                    <input type="text" class="required-item" id="lastname" name="lastname" value="" aria-required="true" placeholder="Lastname">

                                </p>

                            </div>

                            <div class="col-md-6">

                                <p>

                                    

                                    <input type="email" autocomplete="off" class="required-item" id="email" name="email" value="" onChange="Checkemail(this.value)" onkeyup="Checkemail(this.value)" aria-required="true" placeholder="Email">			

                                </p>

                            </div>

                            <div class="col-md-6">

                                <p>

                                    <input type="text" id="contact_no" name="contact_no" class="required-item" aria-required="true" value="" placeholder="Contact No">

                                </p>

                            </div>

                            <div class="col-md-6">

                                <p>

                                    <input type="password" class="required-item" value="" name="password" id="password" aria-required="true" placeholder="Password">

                                </p>

                            </div>

                            <div class="col-md-6">

                                <p>

                                    <input type="password" class="required-item" value="" name="password_con" id="password_con" aria-required="true" placeholder="Confirm Password">

                                </p>

                            </div>

                            <div class="col-md-6">

                                <p>

                                    <input type="text" class="required-item" id="add_1" name="add_1" value="" aria-required="true" placeholder="Address 1">

                                </p>

                            </div>

                            <div class="col-md-6">

                                <p>

                                    <input type="text" class="required-item" id="add_2" name="add_2" value="" aria-required="true" placeholder="Address 2">

                                </p>

                            </div>

                            <div class="col-md-6">

                                <p>

                                    <input type="text" class="required-item" value="" name="city" id="city" aria-required="true" placeholder="City">

                                </p>

                            </div>

                            <?php

							if(isset($_SESSION['POST_CODE']) && $_SESSION['POST_CODE']!=''){

							?>

                            <div class="col-md-6">

                                <p>

                                    <input type="text" class="required-item" onChange="CheckPostcode(this.value)" onkeyup="CheckPostcode(this.value)" id="post_code" name="post_code" value="<?php echo $_SESSION['POST_CODE'] ?>" aria-required="true" placeholder="Post Code">

                                </p>

                            </div>

                            <?php

							}else{

							?>

                            <div class="col-md-6">

                                <p>

                                    <input type="text" class="required-item" id="post_code" name="post_code" value="" aria-required="true" placeholder="Post Code">

                                </p>

                            </div>

                            <?php

							}

							?>

                        </div>

                    </div>

                </div>

            </div>

            <?php

		}

			?>

        </div>

        <div class="row">

        	<div class="col-md-7">

                <div class="page-content">

                <div class="form-style form-js">

                        <div class="row">

                            <div class="col-md-12">

                            	<p>Add Comments About Your Order: </p>

                                <div class="form-message">

                                    <textarea id="comment" class="required-item" name="comment" aria-required="true" cols="58" rows="7"></textarea>

                                </div>

                                </p>

                            </div>

                            <div class="col-md-12">
                            	<label style="color:#00F; font-size:11px; font-weight:bold">DELIVERY METHOD</label>
                                <input type="hidden" value="Home Delivery" name="payment_method" id="payment_method" />
								<table class="radio">
                                  <tbody>
                                    <?php
									$getdeliverarea = PetroFDS::getDeliveryAreas('AND postcode="'.$_SESSION['POST_CODE'].'"');

							  		if(isset($getdeliverarea)){

								  		foreach($getdeliverarea as $getdeliverarea_data){
									?>
                                    <tr class="highlight">
                                    <td>
                                    <label for="home.home"><input type="radio" name="shipping_method" id="home.home" onChange="validatemethod('<?php echo PetroFDS::get_currency() ?>','<?php echo PetroFDS::Float_To_Decimal($getdeliverarea_data['price']) ?>')" checked="checked">Home Delivery</label>
                                    </td>
                                  	</tr>
                                    <tr class="highlight">
                                    <td><label for="collect.collect"><input type="radio" name="shipping_method" id="collect.collect" onChange="validatemethod('<?php echo PetroFDS::get_currency() ?>','<?php echo PetroFDS::Float_To_Decimal($getdeliverarea_data['price']) ?>')">Collect From Store</label></td>
                                    </tr>
                                    <?php
										}
									}else{
									?>
                                    <tr class="highlight">
                                    <td>
                                    <label for="home.home"><input type="radio" name="shipping_method" id="home.home" onChange="validatemethod('<?php echo PetroFDS::get_currency() ?>','0')" checked="checked">Home Delivery</label>
                                    </td>
                                  	</tr>
                                    <tr class="highlight">
                                    <td><label for="collect.collect"><input type="radio" name="shipping_method" id="collect.collect" onChange="validatemethod('<?php echo PetroFDS::get_currency() ?>','0')">Collect From Store</label></td>
                                    </tr>
                                    <?php
									}
									?>
                                  </tbody>
                                </table>
                           		<table class="radio">
                                  	<tbody>
                                    <tr class="highlight">
                                    <label style="color:#00F; font-size:11px; font-weight:bold">PAYMENT METHOD</label>
                                    <td><label><input type="radio" name="pay" id="pay_cash" checked="checked">Pay By Cash</label></td>
                                    </tr>
                                    <tr class="highlight">
                                    <input type="hidden" name="pay_money_method" id="pay_money_method" value="Cash"/>
                                    </tr>
                            		</tbody>
                                </table>
                                <p>

                                	<label><input type="checkbox" id="submit_check" onchange="document.getElementById('btn_sub').disabled = !this.checked;"> I have read and agree to the <a href="#" style="color:red;">Privacy Policy</a>.</label>				

                                <div id="comp_order" class="form-message">

                                	<input name="submit" id="btn_sub" value="Complete Order" disabled class="submit button small color black" type="submit">&nbsp;

                                </div>

                                </p>

                            </div>

                        </div>

                </div>

                </div>

            </div>

            </form>

			<div class="col-md-5">

                <div class="page-content">

                    <h2 class="page-content-title"><i class="icon-envelope-alt"></i>COUPON CODE / LOYALTY ID</h2>

                    <div class="form-style form-js">

                        <div class="row">

                            <div class="col-md-12">

                            	<p style="color:#F00;">Note: Please Click on the loyalty id to select the ID</p>

                                <p>

                                    <input type="text" class="required-item" value="" name="code" id="code" aria-required="true" placeholder="Coupon code Or Loyalty ID">

                                    <input name="code_btn" id="code_btn" value="Check Code" type="button" class="submit button small color" onClick="CouponCode(document.getElementById('code').value,'<?php echo PetroFDS::get_currency() ?>')">

                                    <label id="notify_code" style="color:#8ac007;"></label>

                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
		</div><!-- End row2 -->

	</div><!-- End container pin -->

</div><!-- End container -->

<!-- End Content =============================================== -->

 <?php include_once 'main_content/footer.php'; ?>

    

    

<!-- COMMON SCRIPTS -->

<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/jquery-1.js"></script>

<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/common_scripts_min.js"></script>

<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/functions.js"></script>

<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/validate.js"></script>

<script type="text/javascript" src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js/petrojs-1.0.0.min.js"></script>

<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js_new/custom.js"></script>

<!-- SPECIFIC SCRIPTS -->

<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/cat_nav_mobile.js"></script>

<script>$('#cat_nav').mobileMenu();</script>

<script>

 $(function() {

	 'use strict';

	  $('a[href*=#]:not([href=#])').click(function() {

	    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {

	      var target = $(this.hash);

	      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');

	      if (target.length) {

	        $('html,body').animate({

	          scrollTop: target.offset().top - 70

	        }, 1000);

	        return false;

	      }

	    }

	  });
});

</script>

<script type="text/javascript" src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js/home.js"></script>

</body></html>