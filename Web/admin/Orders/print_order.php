<?php
include('../auth_admin.php'); 
	
if($_SESSION['ROLE_ID']!=0){
	if($permission['orders']==0){
		die("You don't have permission to access please contact administrator.");
	}
}

require_once('../../app/themes/lib/system.lib.php');

$conn = PetroFDS::ConnectDB();

if(isset($_GET['user_id']) && $_GET['user_id']!=''){

	$sql1 = 'SELECT * FROM `orders` WHERE user_id='.$_GET['user_id'].' AND order_detail_id='.$_GET['order_id'].' ORDER BY order_detail_id DESC LIMIT 1';

	$sql2 = 'SELECT * FROM `order_details` WHERE user_id='.$_GET['user_id'].' AND id='.$_GET['order_id'].'';

	$sql3 = 'SELECT * FROM `orders` WHERE user_id='.$_GET['user_id'].' AND order_detail_id='.$_GET['order_id'].'';

}else{

	$sql1 = 'SELECT * FROM `orders` WHERE order_detail_id='.$_GET['order_id'].' ORDER BY order_detail_id DESC LIMIT 1';

	$sql2 = 'SELECT * FROM `order_details` WHERE id='.$_GET['order_id'].'';

	$sql3 = 'SELECT * FROM `orders` WHERE order_detail_id='.$_GET['order_id'].'';

}

$stmt_orders = $conn->prepare($sql1);



$stmt_orders->execute();



$rows_orders = $stmt_orders->fetchAll(PDO::FETCH_ASSOC);



$stmt_order_details = $conn->prepare($sql2);



$stmt_order_details->execute();



$rows_order_details = $stmt_order_details->fetchAll(PDO::FETCH_ASSOC);



$stmt_order_name = $conn->prepare($sql3);



$stmt_order_name->execute();



$rows_order_name = $stmt_order_name->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<HTML>



<head>

  <meta content="text/html; charset=UTF-8" http-equiv="content-type">

  <link rel="stylesheet" type="text/css" href="../css/details.css" media="all">

  <link rel="stylesheet" type="text/css" href="../css/widgets.css" media="all">

  <link rel="stylesheet" type="text/css" href="../css/print.css" media="print">

  

  <title>View/Print Order # <?php echo $_GET['order_id'] ?></title>

</head>

<body class="page-print sales-order-print">

<div>

    <div class="print-head">

        <img src="../../media/themes/local/images/red/logo.png" class="logo" alt="">

            </div>
	<div class="col2-set">
    <div class="col-1">
    <h1>Order # <?php echo $_GET['order_id'] ?></h1>

<?php

if($rows_orders){

	foreach($rows_orders as $row_order){

		foreach($rows_order_details as $row_details){

		$date = $row_details['date_created'];

		$yearvalue = date("Y", strtotime($date) );

		$monthname = date("F", strtotime($date) );

		$dayvalue = date("d", strtotime($date) );

?>    

	<p class="order-date">Order Date: <?php echo $monthname.' '.$dayvalue.', '.$yearvalue ?></p>
    </div>
    <div class="col-2">
    <h1>Discount</h1>
    <?php
	if($row_details['discount']!='0'){
	?>
    	<p><?php echo $row_details['discount'].'%' ?></p>
    <?php
	}else{
	?>
    	<p>0%</p>
    <?php
	}
	?>
    </div>
	</div>
<?php

$stmt_user = $conn->prepare('SELECT * FROM `users` WHERE id='.$row_order['user_id'].'');



$stmt_user->execute();



$rows_user = $stmt_user->fetchAll(PDO::FETCH_ASSOC);

if($rows_user){

foreach($rows_user as $row_user){

?>

    <div class="col2-set">

            <div class="col-1">

            <h2>Shipping Address</h2>

            <address><?php echo $row_user['firstname'].''.$row_user['lastname'] ?><br>

    Address 1: <?php echo $row_user['add_1'] ?><br>

    Address 2: <?php echo $row_user['add_2'] ?><br>

    

    

    Post Code: <?php echo $row_user['post_code'] ?><br>

    Contact No: <?php echo $row_user['contact_no'] ?>

    </address>

        </div>

        <div class="col-2">

                <h2>Billing Address</h2>

            <address><?php echo $row_user['firstname'].''.$row_user['lastname'] ?><br>

    Address 1: <?php echo $row_user['add_1'] ?><br>

    Address 2: <?php echo $row_user['add_2'] ?><br>

    

    

    Post Code: <?php echo $row_user['post_code'] ?><br>

    Contact No: <?php echo $row_user['contact_no'] ?>

    </address>

        </div>

    </div>

<?php

}

}

?>

<div class="col2-set">

    <div class="col-1">

        <h2>Delivery Charges</h2>

        <p><?php echo PetroFDS::get_currency().$row_details['delivery_charges'] ?></p>    

    </div>

    <div class="col-2">

        <h2>Payment Method</h2>

        <p><?php echo $row_details['payment_method'] ?></p>

    </div>

</div>

<h2>Items Ordered</h2>

<table class="data-table" id="my-orders-table">

    <colgroup><col>

    <col width="1">

    <col width="1">

    <col width="1">

    <col width="1">

    </colgroup><thead>

        <tr class="first last">

            <th>Product Name</th>

            <th>Product No</th>

            <th class="a-right">Price</th>

            <th class="a-center">Qty</th>

            <th class="a-right">Subtotal</th>

        </tr>

    </thead>

    <tbody class="odd">

        <?php

		$itter = 0;

		if($rows_order_name){

		foreach($rows_order_name as $row){

		$item_total = 0;

		$itter++;

		$sql='SELECT * FROM menus WHERE id IN (';

		  

		$sql.=$row['product_id'].',';  

		  

		$sql=substr($sql, 0, -1).') ORDER BY name ASC';

		

		$stmt_s_cart = $conn->prepare($sql);

				

		$stmt_s_cart->execute();

		

		$rows_s_cart = $stmt_s_cart->fetchAll(PDO::FETCH_ASSOC);

		

		if($rows_s_cart){

			foreach($rows_s_cart as $row_s_cart){

		?>

        <tr class="border first last" id="order-item-row-38">

    <td><h3 class="product-name">

    		<?php

					if(isset($row['option_yesno']) && $row['option_yesno']!=''){

						$opt_yesno = $row['option_yesno'];

						$opt_yesno = rtrim($opt_yesno,',');

						$sql_opt_1 = 'SELECT * FROM `option` WHERE id IN ('.$opt_yesno.')';

						

						$stmt_opt_1 = $conn->prepare($sql_opt_1);

								

						$stmt_opt_1->execute();

						

						$rows_opt_1 = $stmt_opt_1->fetchAll(PDO::FETCH_ASSOC);

					}

					if(isset($row['option_notype']) && $row['option_notype']!=''){

						$opt_notype = $row['option_notype'];

						$opt_notype_id = rtrim($opt_notype,',');

						$opt_notype_title = $row['option_notype_title'];

						$opt_notype_id_title = rtrim($opt_notype_title,',');

						$sql_opt_notype = 'SELECT o.title as option_title, om.title as option_menu_title 

										  FROM `option_menu` om 

										  LEFT JOIN `option` o ON o.option_id=om.option_id

										  WHERE om.id IN ('.$opt_notype_id.')';

						$stmt_opt_notype = $conn->prepare($sql_opt_notype);

					  

						$stmt_opt_notype->execute();

						

						$rows_opt_notype = $stmt_opt_notype->fetchAll(PDO::FETCH_ASSOC);

					}

					if($row['options'] != ''){

						$option_title_id = $row['options'];

						$option_title_id = rtrim($option_title_id,',');

						$sql_opt = 'SELECT * FROM `option_menu` WHERE id IN ('.$option_title_id.')';

						$stmt_opt = $conn->prepare($sql_opt);

								

						$stmt_opt->execute();

						

						$rows_opt = $stmt_opt->fetchAll(PDO::FETCH_ASSOC);

						if(isset($rows_opt)){

							$CART_TEXT = '';

							if(isset($rows_opt_1, $rows_opt_notype)){

								$CART_TEXT = '';

								if(isset($row['title_custom']) && $row['title_custom']!=''){

								  $sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row['title_custom'].'';

								  $stmt_customs = $conn->prepare($sql_customs);

								  $stmt_customs->execute();

								  $rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);

								  if($rows_customs){

									  foreach($rows_customs as $row_customs){

										  $CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <small>With <br/>';

									  }

								  }  

								}else{

								  $CART_TEXT .= $row_s_cart['name'].' <small>With <br/>'; 

								}

								foreach($rows_opt as $row_opt){

								  $CART_TEXT .= $row_opt['title'].'<br/>'; 

								}

								if(isset($rows_opt_notype)){

								  foreach($rows_opt_notype as $row_opt_notype){

									$CART_TEXT .= '/'.$row_opt_notype['option_menu_title'].'<br/>';

								  }

								}

								foreach($rows_opt_1 as $row_opt_1){

								  $CART_TEXT .= '+'.$row_opt_1['title'].'<br/>';  

								}

								$CART_TEXT .= '</small>';

							}else if(isset($rows_opt_1)){ 

								if(isset($row['title_custom']) && $row['title_custom']!=''){

								  $sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row['title_custom'].'';

								  $stmt_customs = $conn->prepare($sql_customs);

								  $stmt_customs->execute();

								  $rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);

								  if($rows_customs){

									  foreach($rows_customs as $row_customs){

										  $CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <small>With <br/>';

									  }

								  }  

								}else{

								  $CART_TEXT .= $row_s_cart['name'].' <small>With <br/>'; 

								}

								foreach($rows_opt as $row_opt){

								  $CART_TEXT .= $row_opt['title'].'<br/>'; 

								}

								foreach($rows_opt_1 as $row_opt_1){

								  $CART_TEXT .= '+'.$row_opt_1['title'].'<br/>';  

								}

								$CART_TEXT .= '</small>';

							}else if(isset($rows_opt_notype)){

								if(isset($row['title_custom']) && $row['title_custom']!=''){

								  $sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row['title_custom'].'';

								  $stmt_customs = $conn->prepare($sql_customs);

								  $stmt_customs->execute();

								  $rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);

								  if($rows_customs){

									  foreach($rows_customs as $row_customs){

										  $CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <small>With <br/>';

									  }

								  }  

								}else{

								  $CART_TEXT .= $row_s_cart['name'].' <small>With <br/>'; 

								}

								foreach($rows_opt as $row_opt){

								  $CART_TEXT .= $row_opt['title'].'<br/>'; 

								}

								if(isset($rows_opt_notype)){

								  foreach($rows_opt_notype as $row_opt_notype){

									$CART_TEXT .= '/'.$row_opt_notype['option_menu_title'].'<br/>';

								  }

								}

								$CART_TEXT .= '</small>';

							}else{

								$CART_TEXT = '';

								if(isset($row['title_custom']) && $row['title_custom']!=''){

								  $sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row['title_custom'].'';

								  $stmt_customs = $conn->prepare($sql_customs);

								  $stmt_customs->execute();

								  $rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);

								  if($rows_customs){

									  foreach($rows_customs as $row_customs){

										  $CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <small>With <br/>';

									  }

								  }  

								}else{

								  $CART_TEXT .= $row_s_cart['name'].' <small>With <br/>'; 

								}

								foreach($rows_opt as $row_opt){

								  $CART_TEXT .= $row_opt['title'].'<br/>'; 

								}

								$CART_TEXT .= '</small>';

							}

							echo $CART_TEXT;

						}

					}else if(isset($row['option_yesno']) && $row['option_yesno']==''){

						$CART_TEXT = '';

						if(isset($row['title_custom']) && $row['title_custom']!=''){

						  $sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row['title_custom'].'';

						  $stmt_customs = $conn->prepare($sql_customs);

						  $stmt_customs->execute();

						  $rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);

						  if($rows_customs){

							  foreach($rows_customs as $row_customs){

								  if(isset($row['option_yesno']) && $row['option_yesno']!=''){

									  $CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <small>With <br/>';

								  }else if(isset($row['option_notype']) && $row['option_notype']!=''){

									  $CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <small>With <br/>';

								  }else{

									  $CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <small>';

								  }

							  }

						  }  

						}else{

						  if(isset($row['option_yesno']) && $row['option_yesno']!=''){

							  $CART_TEXT .= $row_s_cart['name'].' <small>With <br/>';

						  }else if(isset($row['option_notype']) && $row['option_notype']!=''){

							  $CART_TEXT .= $row_s_cart['name'].' <small>With <br/>';

						  }else{

							  $CART_TEXT .= $row_s_cart['name'].' <small>';

						  } 

						}

						if(isset($rows_opt_notype)){

							foreach($rows_opt_notype as $row_opt_notype){

							  if(isset($row_opt_notype['option_menu_title']) && $row_opt_notype['option_menu_title']!=''){  

							  $CART_TEXT .= '/'.$row_opt_notype['option_menu_title'].'<br/>';

							  }

							}

						}

						$CART_TEXT .= '</small>';

						echo $CART_TEXT;

					}else{

						$CART_TEXT = '';

						if(isset($row['title_custom']) && $row['title_custom']!=''){

						  $sql_customs = 'SELECT * FROM `menu_custom_option` WHERE id = '.$row['title_custom'].'';

						  $stmt_customs = $conn->prepare($sql_customs);

						  $stmt_customs->execute();

						  $rows_customs = $stmt_customs->fetchAll(PDO::FETCH_ASSOC);

						  if($rows_customs){

							  foreach($rows_customs as $row_customs){

								  $CART_TEXT .= $row_customs['title'].' '.$row_s_cart['name'].' <small>With <br/>';

							  }

						  }  

						}else{

						  $CART_TEXT .= $row_s_cart['name'].' <small>With <br/>'; 

						}

						if(isset($rows_opt_notype)){

							foreach($rows_opt_notype as $row_opt_notype){

							  $CART_TEXT .= '/'.$row_opt_notype['option_menu_title'].'<br/>';

							}

						}

						if(isset($rows_opt_1)){

						foreach($rows_opt_1 as $row_opt_1){

						  $CART_TEXT .= '+'.$row_opt_1['title'].'<br/>';  

						}

						}

						$CART_TEXT .= '</small>';

						echo $CART_TEXT;  

					}

					$item_total += ($row_s_cart["price"]*$row["quantity"]);

			?>

    </h3>

                                                                </td>

    <td><?php echo $row['product_id'] ?></td>

    <td class="a-right">

                    <span class="price-excl-tax">

                     <span class="cart-price">

                

                                            <span class="price"><?php echo PetroFDS::get_currency().PetroFDS::Float_To_Decimal($row['price']/$row['quantity']) ?></span>                    

                </span>





                            </span>

            <br>

                    </td>

    <td class="a-right">

        <span class="nobr">

                            Ordered: <strong><?php echo $row['quantity'] ?></strong><br>

                                        </span>

    </td>

    <td class="a-right last">

                    <span class="price-excl-tax">

                                                    <span class="cart-price">

                

                                            <span class="price"><?php echo PetroFDS::get_currency().PetroFDS::Float_To_Decimal($row['price']); ?></span>               

                </span>





                            </span>

            <br>

                    </td>

    		<!--

        <th class="a-right"><span class="price">$800.00</span></th>



            -->

</tr>

<?php

			}

		}

		}

		}

$sub_grand_total = (PetroFDS::Float_To_Decimal($item_total)*$itter);

?>

<tfoot>

<tr class="subtotal first">

<td colspan="4" class="a-right">

        Subtotal                    </td>

<td class="last a-right">

        <span class="price"><?php echo PetroFDS::get_currency().PetroFDS::Float_To_Decimal($row_order['price_all']); ?></span>                    </td>

</tr>

<!--<tr class="shipping">

<td colspan="4" class="a-right">

        Shipping &amp; Handling                    </td>

<td class="last a-right">

        <span class="price">$5.00</span>                    </td>

</tr>-->

<tr class="grand_total last">

<td colspan="4" class="a-right">

        <strong>Grand Total</strong>

    </td>

<td class="last a-right">

        <strong><span class="price"><?php echo PetroFDS::get_currency().PetroFDS::Float_To_Decimal($row_order['price_all']); ?></span></strong>

    </td>

</tr>

</tfoot>

    </tbody>

        </table>

<?php

		}

	}

}

?>

    <div class="buttons-set">

        <button type="button" title="Close Window" class="button" onClick="window.close();"><span><span>Close Window</span></span></button>

    </div>
	
    </div>
<label>This is a Computer generated slip does not required any signature Printed on <?php echo date('d-m-Y').' at '.date('h:i:s a') ?></label>
<script type="text/javascript">//window.print();</script>

</body>

</html>