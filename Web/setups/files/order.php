<?php 
session_start(); 

include_once '../../app/themes/lib/system.lib.php';

$conn = PetroFDS::ConnectDB();

PetroFDS::SetTimeZone();

error_reporting(0);

include_once 'order_condition.php';

?>

<div id="cart">

  <div class="content">

  <div class="col-md-12 dot-top-bottom">

      <div class="col-md-6">

      <strong><i class="icon-delivery" style="font-size:12px;"></i>

      <?php

      if(isset($_SESSION['POST_CODE']) && $_SESSION['POST_CODE']!=''){

      $getdeliverareaicon = PetroFDS::getDeliveryAreas('AND postcode="'.$_SESSION['POST_CODE'].'"');

      if(isset($getdeliverareaicon)){

          foreach($getdeliverareaicon as $getdeliverarea_icondata){

      ?>

      <?php echo PetroFDS::get_currency().PetroFDS::Float_To_Decimal($getdeliverarea_icondata['price']); ?></strong>

      <?php

          }

      }

      }else{

      ?>

      0.00

      <?php

      }

      ?>

      </div>

      <div class="col-md-6">

      <strong><i class="icon-time" style="font-size:12px;"></i> 30 Mins</strong>

      </div>

  </div>

  <?php

  if(isset($_SESSION['CART_USER_ID'])){  

  		$item_total = 0;

  ?>

  <div id="ajax">

  	<div class="mini-cart-info">

          <?php

		  $sql_z = 'SELECT * FROM cart WHERE ip=:ip';

		  

		  $stmt_z = $conn->prepare($sql_z);

					  

		  $stmt_z->execute(array(

		  	':ip' => $_SESSION['CART_USER_ID']

		  ));

		  

		  $rows_z = $stmt_z->fetchAll(PDO::FETCH_ASSOC);

		  

		  if($rows_z){

		  ?>

          <table class="table table_summary tbdy">

          <div id="loader" style="z-index:10; display:none;">

	          <img src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/images/load.gif" style="margin-left:95px; margin-top:20px;" />

          </div>

          <tbody id="info_product">

          <?php

			  foreach($rows_z as $row_z){

				  

		  $sql_z_get_total = 'SELECT SUM(price) as total FROM cart WHERE ip=:ip';

		  

		  $stmt_z_get_total = $conn->prepare($sql_z_get_total);

					  

		  $stmt_z_get_total->execute(array(

		  	':ip' => $_SESSION['CART_USER_ID']

		  ));

		  

		  $rows_z_get_total = $stmt_z_get_total->fetchAll(PDO::FETCH_ASSOC);

		  

		  if($rows_z_get_total){

			  foreach($rows_z_get_total as $row_z_get_total){

				  $total_all = $row_z_get_total['total'];

			  }

		  }

		  

		  $sql='SELECT * FROM menus WHERE id IN (';

		  

		  $sql.=$row_z['product_id'].',';  

			

		  $sql=substr($sql, 0, -1).') ORDER BY name ASC';

		  

		  $stmt_s_cart = $conn->prepare($sql);

				  

		  $stmt_s_cart->execute();

		  

		  $rows_s_cart = $stmt_s_cart->fetchAll(PDO::FETCH_ASSOC);

		  

		  if($rows_s_cart){

			  foreach($rows_s_cart as $row_s_cart){

		  ?>

          <tr>

          <td><a onClick="addtocart('plus','<?php echo $row_z['id'] ?>')" href="javascript:void(0)" class="plus_item"><i class="icon-plus-sign"></i></a> <a onClick="addtocart('remove','<?php echo $row_z['id'] ?>')" href="javascript:void(0)" class="remove_item"><i class="icon-minus-sign"></i></a> <strong>
          
		  <?php 

		  $qty = $row_z['quantity'];

		  $total_with_qty = PetroFDS::Float_To_Decimal($row_z['price'])*$qty;

		  echo $qty;

		  ?>x&nbsp;</strong><?php
			
			  

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
								if($rows_opt){
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <small><br/>';
								}else if($rows_opt_1){
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <small><br/>';
								}else if($rows_opt_notype){
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <small><br/>';
								}else{
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <small>';
								}
							}
		  
						}  
		  
					  }else{
						if($rows_opt){
							$CART_TEXT .= $row_s_cart['name'].' <small><br/>'; 
						}else if($rows_opt_1){
							$CART_TEXT .= $row_s_cart['name'].' <small><br/>';
						}else if($rows_opt_notype){
							$CART_TEXT .= $row_s_cart['name'].' <small><br/>';
						}else{
							$CART_TEXT .= $row_s_cart['name'].' <small>';
						}
					  }
		  
					  foreach($rows_opt as $row_opt){
		  
						$CART_TEXT .= '- '.$row_opt['title'].'<br/>'; 
		  
					  }
		  
					  if(isset($rows_opt_notype)){
		  
						foreach($rows_opt_notype as $row_opt_notype){
		  
							if(isset($row_z['cart_type']) && $row_z['cart_type']=="options"){
		  
								if(isset($row_z['option_notype_title']) && $row_z['option_notype_title']!=''){
		  
									$CART_TEXT .= '- '.$row_opt_notype['option_menu_title'].'<br/>';
		  
								}
		  
							}
		  
						}
		  
					  }
		  
					  foreach($rows_opt_1 as $row_opt_1){
		  
						$CART_TEXT .= '- '.$row_opt_1['title'].'<br/>';  
		  
					  }
		  
					  $CART_TEXT .= '</small>';
		  
				  }else if(isset($rows_opt_1)){ 
		  
					  if(isset($row_z['title_custom']) && $row_z['title_custom']!=''){
		  
						$sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row_z['title_custom'].'';
		  
						$stmt_customs = $conn->prepare($sql_customs);
		  
						$stmt_customs->execute();
		  
						$rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);
		  
						if($rows_customs){
		  
							foreach($rows_customs as $row_customs){
								if($rows_opt){
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <small><br/>';
								}else if($rows_opt_1){
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <small><br/>';
								}else{
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <small>';
								}
							}
		  
						}  
		  
					  }else{
						if($rows_opt){						
							$CART_TEXT .= $row_s_cart['name'].' <small><br/>'; 
						}else if($rows_opt_1){
							$CART_TEXT .= $row_s_cart['name'].' <small><br/>';
						}else{
							$CART_TEXT .= $row_s_cart['name'].' <small>';
						}
					  }
		  
					  foreach($rows_opt as $row_opt){
		  
						$CART_TEXT .= '- '.$row_opt['title'].'<br/>'; 
		  
					  }
		  
					  foreach($rows_opt_1 as $row_opt_1){
		  
						$CART_TEXT .= '- '.$row_opt_1['title'].'<br/>';  
		  
					  }
		  
					  $CART_TEXT .= '</small>';
		  
				  }else if(isset($rows_opt_notype)){
		  
					  if(isset($row_z['title_custom']) && $row_z['title_custom']!=''){
		  
						$sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row_z['title_custom'].'';
		  
						$stmt_customs = $conn->prepare($sql_customs);
		  
						$stmt_customs->execute();
		  
						$rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);
		  
		  
						if($rows_customs){
		  
							foreach($rows_customs as $row_customs){
								if($rows_opt){
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <small><br/>';
								}else if($rows_opt_notype){
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <small><br/>';
								}else{
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <small>';
								}
							}
		  
						}  
		  
					  }else{
						if($rows_opt){
							$CART_TEXT .= $row_s_cart['name'].' <small><br/>'; 
						}else if($rows_opt_notype){
							$CART_TEXT .= $row_s_cart['name'].' <small><br/>';
						}else{
							$CART_TEXT .= $row_s_cart['name'].' <small>';
						}
					  }
		  
					  foreach($rows_opt as $row_opt){
		  
						$CART_TEXT .= '- '.$row_opt['title'].'<br/>'; 
		  
					  }
		  
					  if(isset($rows_opt_notype)){
		  
						foreach($rows_opt_notype as $row_opt_notype){
		  
							if(isset($row_z['cart_type']) && $row_z['cart_type']=="options"){
		  
								if(isset($row_z['option_notype_title']) && $row_z['option_notype_title']!=''){
		  
									$CART_TEXT .= '- '.$row_opt_notype['option_menu_title'].'<br/>';
		  
								}
		  
							}
		  
						}
		  
					  }
		  
					  $CART_TEXT .= '</small>';
		  
				  }else{
		  
					  $CART_TEXT = '';
		  
					  if(isset($row_z['title_custom']) && $row_z['title_custom']!=''){
		  
						$sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row_z['title_custom'].'';
		  
						$stmt_customs = $conn->prepare($sql_customs);
		  
						$stmt_customs->execute();
		  
						$rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);
		  
						if($rows_customs){
		  
							foreach($rows_customs as $row_customs){
								if(isset($rows_opt)){
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <small><br/>';
								}else{
									$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <small>';
								}
							}
		  
						}  
		  
					  }else{
						if($rows_opt){
							$CART_TEXT .= $row_s_cart['name'].' <small><br/>'; 
						}else{
							$CART_TEXT .= $row_s_cart['name'].' <small>';
						}
					  }
		  
					  foreach($rows_opt as $row_opt){
		  
						$CART_TEXT .= '- '.$row_opt['title'].'<br/>'; 
		  
					  }
		  
					  $CART_TEXT .= '</small>';
		  
				  }
		  
				  echo $CART_TEXT;
		  
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
		  
							$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <small><br/>';
		  
						}else if(isset($row_z['option_notype']) && $row_z['option_notype']!=''){
		  
							$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <small><br/>';
		  
						}else{
		  
							$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <small>';
		  
						}
		  
					}
		  
				}  
		  
			  }else{
		  
				if(isset($row_z['option_yesno']) && $row_z['option_yesno']!=''){
		  
					$CART_TEXT .= $row_s_cart['name'].' <small><br/>';
		  
				}else if(isset($row_z['option_notype']) && $row_z['option_notype']!=''){
		  
					$CART_TEXT .= $row_s_cart['name'].' <small><br/>';
		  
				}else{
		  
					$CART_TEXT .= $row_s_cart['name'].' <small>';
		  
				} 
		  
			  }
		  
			  if(isset($rows_opt_notype)){
		  
				  foreach($rows_opt_notype as $row_opt_notype){
		  
					if(isset($row_opt_notype['option_menu_title']) && $row_opt_notype['option_menu_title']!=''){ 
		  
						if(isset($row_z['cart_type']) && $row_z['cart_type']=="options"){ 
		  
							if(isset($row_z['option_notype_title']) && $row_z['option_notype_title']!=''){
		  
								$CART_TEXT .= '- '.$row_opt_notype['option_menu_title'].'<br/>';
		  
							}
		  
						}
		  
					}
		  
				  }
		  
			  }
		  
			  $CART_TEXT .= '</small>';
		  
			  echo $CART_TEXT;
		  
		  
		  }else{
		  
			  $CART_TEXT = '';
		  
			  if(isset($row_z['title_custom']) && $row_z['title_custom']!=''){
		  
				$sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row_z['title_custom'].'';
		  
				$stmt_customs = $conn->prepare($sql_customs);
		  
				$stmt_customs->execute();
		  
				$rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);
		  
				if($rows_customs){
		  
					foreach($rows_customs as $row_customs){
						if($rows_opt_notype){
							$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <small><br/>';
						}else if($rows_opt_1){
							$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <small><br/>';
						}else{
							$CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <small>';
						}
					}
		  
				}  
		  
			  }else{
				if($rows_opt_notype){
					$CART_TEXT .= $row_s_cart['name'].' <small><br/>'; 
				}else if($rows_opt_1){
					$CART_TEXT .= $row_s_cart['name'].' <small><br/>';
				}else{
					$CART_TEXT .= $row_s_cart['name'].' <small>';
				}
			  }
		  
			  if(isset($rows_opt_notype)){
		  
				  foreach($rows_opt_notype as $row_opt_notype){
		  
					  if(isset($row_z['cart_type']) && $row_z['cart_type']=="options"){
		  
						  if(isset($row_z['option_notype_title']) && $row_z['option_notype_title']!=''){
		  
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
		  
			  $CART_TEXT .= '</small>';
		  
			  echo $CART_TEXT;  
		  
		  }

		  ?>

                          <div>

                                         </div></td>

          <?php

		  		$item_total += ($row_z['price']*$row_z['quantity']);

			  }

		  }

		  

		  ?>

          <td>

		  <strong class="pull-right"><?php 

		  echo PetroFDS::get_currency().$total_with_qty; 

		  ?></strong>

          </td>

          </tr>

          <?php

			  }

		  ?>

          </tbody>

      </table>

          <?php

		  }

		  ?>

    </div>

<?php

if($rows_z){ 			

?>

      <table class="table table_summary dot-top-bottom">

      <tbody>

      <tr>

          <td class="dot-top-bottom">

               Subtotal: <span class="pull-right"><?php

		  echo PetroFDS::get_currency().PetroFDS::Float_To_Decimal($item_total);

		  ?></span>

          </td>

      </tr>

      <?php

	  if(isset($_SESSION['POST_CODE']) && $_SESSION['POST_CODE']!=''){

	  ?>

      <tr>

          <td class="dot-top-bottom">

               Post Code: <span class="pull-right"><?php echo $_SESSION['POST_CODE'] ?></span>

          </td>

      </tr>

      <?php

	  $getdeliverarea = PetroFDS::getDeliveryAreas('AND postcode="'.$_SESSION['POST_CODE'].'"');

	  if(isset($getdeliverarea)){

		  foreach($getdeliverarea as $getdeliverarea_data){

	  ?>

      <tr>

          <td class="dot-top-bottom">

               Delivery fee: <span class="pull-right"><?php echo PetroFDS::get_currency().PetroFDS::Float_To_Decimal($getdeliverarea_data['price']) ?></span>

          </td>

      </tr>

      <?php

		  }

	  }

	  }

	  ?>

      <tr>

          <td class="total dot-top-bottom">

               TOTAL: <span class="pull-right" id="total_cart_price"><?php

			   if(isset($getdeliverarea)){

				  echo PetroFDS::get_currency().PetroFDS::Float_To_Decimal(($item_total)+($getdeliverarea_data['price'])); 

			   }else{

				  echo PetroFDS::get_currency().PetroFDS::Float_To_Decimal($item_total);

			   }

		  ?></span>

          </td>

      </tr>

      </tbody>

      </table>

    </div>

    <hr>

    <a class="btn_full" href="cart">ViewCart</a>

	<a class="btn_full" href="checkout">CheckOut</a>

<?php

}else{

	$stmt = $conn->prepare('DELETE FROM cart WHERE ip=:ip');

						

	$stmt->execute(array(

		':ip' => $_SERVER['REMOTE_ADDR'],		

	));

				

	$rows = $stmt->fetchAll();

	?>

    	<table class="table table_summary">

          <tbody id="info_product">

          	<tr>

            	<td>

        		<h4 style="font-size:14px;"><i class="icon-arrow-left"></i>   <strong>Your shopping cart is empty. Start by adding items to order!</strong></h4>

        		</td>

            </tr>

          </tbody>

        </table>

    <?php

}

  }else{

	  	$stmt = $conn->prepare('DELETE FROM cart WHERE ip=:ip');

						

		$stmt->execute(array(

			':ip' => $_SERVER['REMOTE_ADDR'],		

		));

					

		$rows = $stmt->fetchAll();

?>

        <table class="table table_summary">

          <tbody id="info_product">

          	<tr>

            	<td>

        		<h4 style="font-size:14px;"><i class="icon-arrow-left"></i>   <strong>Your shopping cart is empty. Start by adding items to order!</strong></h4>

        		</td>

            </tr>

          </tbody>

        </table>

<?php

  }

?>

      </div>

</div>

<div style="display: none" class="customizable_options_widget">

</div>