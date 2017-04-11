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

    <title>Shopping Cart</title>



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

				<div class="box_style_2" id="main_menu">

					<h2 class="inner">Shopping Cart</h2>

					<table width="100%" class="table table-striped cart-list">

					<thead>

					<tr>

						<th>

							 Item

						</th>

						<th>

							 Price

						</th>

						<th>

							 Quantity

						</th>

                        <th>

							 Sub-Total

						</th>

					</tr>

					</thead>

					<tbody>

                    <?php

					if(isset($_SESSION['CART_USER_ID'])){



						  $item_total = 0;



						  



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

					  $CART_TEXT .= '<h4><strong class="pr_name">';

					  if(isset($row_get_id['title_custom']) && $row_get_id['title_custom']!=''){

						$sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row_get_id['title_custom'].'';

						$stmt_customs = $conn->prepare($sql_customs);

						$stmt_customs->execute();

						$rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);

						if($rows_customs){

							foreach($rows_customs as $row_customs){
								if($rows_opt){
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <p><br/>';
								}else if($rows_opt_1){
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <p><br/>';
								}else if($rows_opt_notype){
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <p><br/>';
								}else{
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <p>';
								}
							}

						}  

					  }else{
						if($rows_opt){
					  		$CART_TEXT .= $row_s_cart['name'].' <p><br/>'; 
						}else if($rows_opt_1){
							$CART_TEXT .= $row_s_cart['name'].' <p><br/>';
						}else if($rows_opt_notype){
							$CART_TEXT .= $row_s_cart['name'].' <p><br/>';
						}else{
							$CART_TEXT .= $row_s_cart['name'].' <p>';
						}
					  }

					  foreach($rows_opt as $row_opt){

						$CART_TEXT .= '- '.$row_opt['title'].'<br/>'; 

					  }

					  if(isset($rows_opt_notype)){

						foreach($rows_opt_notype as $row_opt_notype){

							if(isset($row_get_id['cart_type']) && $row_get_id['cart_type']=="options"){

								if(isset($row_get_id['option_notype_title']) && $row_get_id['option_notype_title']!=''){

						  			$CART_TEXT .= '- '.$row_opt_notype['option_menu_title'].'<br/>';

								}

							}

						}

					  }

					  foreach($rows_opt_1 as $row_opt_1){

						$CART_TEXT .= '- '.$row_opt_1['title'].'<br/>';  

					  }

					  $CART_TEXT .= '</p>';

				  }else if(isset($rows_opt_1)){ 
				  
				  	  $CART_TEXT .= '<h4><strong class="pr_name">';

					  if(isset($row_get_id['title_custom']) && $row_get_id['title_custom']!=''){

						$sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row_get_id['title_custom'].'';

						$stmt_customs = $conn->prepare($sql_customs);

						$stmt_customs->execute();

						$rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);

						if($rows_customs){

							foreach($rows_customs as $row_customs){
								if($rows_opt){
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <p><br/>';
								}else if($rows_opt_1){
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <p><br/>';
								}else{
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <p>';
								}
							}

						}  

					  }else{
						if($rows_opt){						
					  		$CART_TEXT .= $row_s_cart['name'].' <p><br/>'; 
						}else if($rows_opt_1){
							$CART_TEXT .= $row_s_cart['name'].' <p><br/>';
						}else{
							$CART_TEXT .= $row_s_cart['name'].' <p>';
						}
					  }

					  foreach($rows_opt as $row_opt){

						$CART_TEXT .= '- '.$row_opt['title'].'<br/>'; 

					  }

					  foreach($rows_opt_1 as $row_opt_1){

						$CART_TEXT .= '- '.$row_opt_1['title'].'<br/>';  

					  }

					  $CART_TEXT .= '</p>';

				  }else if(isset($rows_opt_notype)){
					  
					  $CART_TEXT .= '<h4><strong class="pr_name">';

					  if(isset($row_get_id['title_custom']) && $row_get_id['title_custom']!=''){

						$sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row_get_id['title_custom'].'';

						$stmt_customs = $conn->prepare($sql_customs);

						$stmt_customs->execute();

						$rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);


						if($rows_customs){

							foreach($rows_customs as $row_customs){
								if($rows_opt){
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <p><br/>';
								}else if($rows_opt_notype){
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <p><br/>';
								}else{
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <p>';
								}
							}

						}  

					  }else{
						if($rows_opt){
					  		$CART_TEXT .= $row_s_cart['name'].' <p><br/>'; 
						}else if($rows_opt_notype){
							$CART_TEXT .= $row_s_cart['name'].' <p><br/>';
						}else{
							$CART_TEXT .= $row_s_cart['name'].' <p>';
						}
					  }

					  foreach($rows_opt as $row_opt){

						$CART_TEXT .= '- '.$row_opt['title'].'<br/>'; 

					  }

					  if(isset($rows_opt_notype)){

						foreach($rows_opt_notype as $row_opt_notype){

							if(isset($row_get_id['cart_type']) && $row_get_id['cart_type']=="options"){

								if(isset($row_get_id['option_notype_title']) && $row_get_id['option_notype_title']!=''){

						  			$CART_TEXT .= '- '.$row_opt_notype['option_menu_title'].'<br/>';

								}

							}

						}

					  }

					  $CART_TEXT .= '</p>';

				  }else{

					  $CART_TEXT = '';
					  
					  $CART_TEXT .= '<h4><strong class="pr_name">';

					  if(isset($row_get_id['title_custom']) && $row_get_id['title_custom']!=''){

						$sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row_get_id['title_custom'].'';

						$stmt_customs = $conn->prepare($sql_customs);

						$stmt_customs->execute();

						$rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);

						if($rows_customs){

							foreach($rows_customs as $row_customs){
								if(isset($rows_opt)){
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <p><br/>';
								}else{
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <p>';
								}
							}

						}  

					  }else{
						if($rows_opt){
					  		$CART_TEXT .= $row_s_cart['name'].' <p><br/>'; 
						}else{
							$CART_TEXT .= $row_s_cart['name'].' <p>';
						}
					  }

					  foreach($rows_opt as $row_opt){

						$CART_TEXT .= '- '.$row_opt['title'].'<br/>'; 

					  }

					  $CART_TEXT .= '</p></h4>';

				  }

											

						?>

                    	<td>

                        <div class="row">

                            <div class="col-sm-10">

                                <?php echo $CART_TEXT; ?>

                            </div>

                        </div>

						</td>

                        <td>

                        <?php echo PetroFDS::get_currency().PetroFDS::Float_To_Decimal($price) ?>

						</td>

                        <td>

                        <?php echo $qty ?>

						</td>

                        <td>

                        <?php echo PetroFDS::get_currency().PetroFDS::Float_To_Decimal($total_with_qty) ?>

						</td>

                        <?php

									}

							  }else if(isset($row_get_id['option_yesno']) && $row_get_id['option_yesno']==''){

							  	  $CART_TEXT = '<h4><strong class="pr_name">';

								  if(isset($row_get_id['title_custom']) && $row_get_id['title_custom']!=''){
				  
								  $sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row_get_id['title_custom'].'';
				  
								  $stmt_customs = $conn->prepare($sql_customs);
				  
								  $stmt_customs->execute();
				  
								  $rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);
				  
								  if($rows_customs){
				  
									  foreach($rows_customs as $row_customs){
				  
										  if(isset($row_get_id['option_yesno']) && $row_get_id['option_yesno']!=''){
				  
											  $CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'</strong> <p><br/>';
				  
										  }else if(isset($row_get_id['option_notype']) && $row_get_id['option_notype']!=''){
				  
											  $CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'</strong> <p><br/>';
				  
										  }else{
				  
											  $CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'</strong> <p>';
										  }
				  
									  }
				  
								  }  
				  
								}else{
				  
								  if(isset($row_get_id['option_yesno']) && $row_get_id['option_yesno']!=''){
				  
									  $CART_TEXT .= $row_s_cart['name'].'</strong> <p><br/>';
				  
								  }else if(isset($row_get_id['option_notype']) && $row_get_id['option_notype']!=''){
				  
									  $CART_TEXT .= $row_s_cart['name'].'</strong> <p><br/>';
				  
								  }else{
				  
									  $CART_TEXT .= $row_s_cart['name'].'</strong> <p>';
								  } 
				  
								}
				  
								if(isset($rows_opt_notype)){
				  
									foreach($rows_opt_notype as $row_opt_notype){
				  
									  if(isset($row_opt_notype['option_menu_title']) && $row_opt_notype['option_menu_title']!=''){ 
				  
										  if(isset($row_get_id['cart_type']) && $row_get_id['cart_type']=="options"){ 
				  
											  if(isset($row_get_id['option_notype_title']) && $row_get_id['option_notype_title']!=''){
				  
												  $CART_TEXT .= '- '.$row_opt_notype['option_menu_title'].'<br/>';
				  
											  }
				  
										  }
				  
									  }
				  
									}
				  
								}

								  $CART_TEXT .= '</p></h4>';

							?>

                         <td>

                         <div class="row">

                            <div class="col-sm-10">

                                <?php echo $CART_TEXT; ?>

                            </div>

                        </div>

                         </td>

                         <td>

                         <?php echo PetroFDS::get_currency().PetroFDS::Float_To_Decimal($price) ?>

                         </td>

                         <td>

                         <?php echo $qty ?>

                         </td>

                         <td>

                         <?php echo PetroFDS::get_currency().PetroFDS::Float_To_Decimal($total_with_qty) ?>

                         </td>  

                         <?php

							  }else{

								  $CART_TEXT = '<h4><strong class="pr_name">';

									

								  if(isset($row_get_id['title_custom']) && $row_get_id['title_custom']!=''){
				  
								  $sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row_get_id['title_custom'].'';
				  
								  $stmt_customs = $conn->prepare($sql_customs);
				  
								  $stmt_customs->execute();
				  
								  $rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);
				  
								  if($rows_customs){
				  
									  foreach($rows_customs as $row_customs){
										  if($rows_opt_notype){
											  $CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'</strong> <p><br/>';
										  }else if($rows_opt_1){
											  $CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'</strong> <p><br/>';							
										  }else{
											  $CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].'</strong> <p>';
										  }
									  }
				  
								  }  
				  
								}else{
								  if($rows_opt_notype){
									  $CART_TEXT .= $row_s_cart['name'].'</strong> <p><br/>';
								  }else if($rows_opt_1){
									  $CART_TEXT .= $row_s_cart['name'].'</strong> <p><br/>';
								  }else{
									  $CART_TEXT .= $row_s_cart['name'].'</strong> <p>';
								  }
								}
				  
								if(isset($rows_opt_notype)){
				  
									foreach($rows_opt_notype as $row_opt_notype){
				  
										if(isset($row_get_id['cart_type']) && $row_get_id['cart_type']=="options"){
				  
											if(isset($row_get_id['option_notype_title']) && $row_get_id['option_notype_title']!=''){
				  
											  $CART_TEXT .= '- '.$row_opt_notype['option_menu_title'].'<br/>';
				  
											}
				  
										}
				  
									}
				  
								}
				  
								if(isset($rows_opt_1)){
				  
								foreach($rows_opt_1 as $row_opt_1){
				  
								  $CART_TEXT .= '- '.$row_opt_1['title'].'<br/>';
				  
								}
				  
								}

								  $CART_TEXT .= '</p></h4>';

							?>

                         <td>

                         <div class="row">

                            <div class="col-sm-10">

                                <?php echo $CART_TEXT; ?>

                            </div>

                        </div>

                         </td>

                         <td>

                         <?php echo PetroFDS::get_currency().PetroFDS::Float_To_Decimal($price) ?>

                         </td>

                         <td>

                         <?php echo $qty ?>

                         </td>

                         <td>

                         <?php echo PetroFDS::get_currency().PetroFDS::Float_To_Decimal($total_with_qty) ?>

                         </td> 

                         <?php

							  }

							  }

							  $item_total += ($row_get_id["price"]*$row_get_id["quantity"]);

						  }

						  }

						  }

						?>

					</tr>

					</tbody>

                    <tfoot>

						<tr>

                            <?php

							if(isset($all_total)){

								if(PetroFDS::get_system_config('price_discount')!='0'){

							?>

                            	<td>

                                </td>

                                <td>

                                </td>

                            	<td><strong>Discount <?php echo PetroFDS::get_system_config('price_discount').'%'; ?></strong></td>

                            	<td><strong>Total <?php echo PetroFDS::get_currency().PetroFDS::Float_To_Decimal(PetroFDS::Get_Discount_Price($item_total,PetroFDS::get_system_config('price_discount'))); ?></strong></td>

                            <?php

								}else{

							?>

                            	<td>

                                </td>

                                <td>

                                </td>

                                <td>

                                </td>

                            	<td><strong>Total <?php echo PetroFDS::get_currency().PetroFDS::Float_To_Decimal($item_total); ?></strong></td>

                            <?php

								}

							?>

                            <a href="menu" class="btn btn-warning"><i class="icon-angle-left"></i> Continue</a>

							<a href="checkout" class="btn btn-success pull-right">Checkout <i class="icon-angle-right"></i></a>

                            <?php

							}else{

							?>

                            <a href="menu" class="btn btn-warning"><i class="icon-angle-left"></i> Continue</a>

                            <td>

							There is no Product in the cart.

                            </td>

                            <?php

							}

							?>

						</tr>

					</tfoot>

                    <?php

					}else{

					?>

                    <tfoot>

                    	<tr>

                        	<a href="menu" class="btn btn-warning"><i class="icon-angle-left"></i> Continue</a>

                            <td>

							There is no Product in the cart.

                            </td>

                        </tr>

                    </tfoot>

                    <?php

					}

					?>

                    </table>

				</div><!-- End box_style_1 -->

			</div><!-- End col-md-6 -->

		</div><!-- End row -->

	</div><!-- End container pin -->

</div><!-- End container -->

<!-- End Content =============================================== -->

<?php include_once 'main_content/footer.php'; ?>

    

    

<!-- COMMON SCRIPTS -->

<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/jquery-1.js"></script>

<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/common_scripts_min.js"></script>

<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/functions.js"></script>

<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/validate.js"></script>

<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js_new/custom.js"></script>

<!-- SPECIFIC SCRIPTS -->

<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/cat_nav_mobile.js"></script>

<script>$('#cat_nav').mobileMenu();</script>

<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/custom.js"></script>

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

<script type="text/javascript" src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js/bootstrap-select.js"></script>

<script type="text/javascript" src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js/petrojs-1.0.0.min.js"></script>

<script type="text/javascript" src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js/menu.js"></script>

<script type="text/javascript" src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js/save_order.js"></script>

</body></html>