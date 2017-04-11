<?php 
session_start(); 
require_once('../../../../app/themes/lib/system.lib.php');
$conn = PetroFDS::ConnectDB();
error_reporting(0);
if(isset($_GET['action']) && $_GET['action']=='add'){
	$id=intval($_GET['id']);
	$_SESSION['CART_USER_ID'] = PetroFDS::get_client_ip_env();
	if(isset($_GET['option_1'], $_GET['option_yesno_1']) && $_GET['option_1']!='' && $_GET['option_yesno_1']!=''){
		if(isset($_GET['count2'], $_GET['count3']) && $_GET['count2']!='' && $_GET['count3']!=''){
			$options = '';
			$option_yesno = '';
			for($i = 1; $i < $_GET['count3']+1; $i++){
				$options .= $_GET['option_'.$i].',';
				$get_option_id = substr($options,0,strlen($options)-1);
			}
			for($j = 1; $j < $_GET['count2']+1; $j++){
				$option_yesno .= $_GET['option_yesno_'.$j].',';
				$get_option_id_yesno = substr($option_yesno,0,strlen($option_yesno)-1);
			}
		}
		$stmt_c = $conn->prepare("SELECT * FROM cart WHERE option_yesno IN ('".$get_option_id_yesno."') AND options IN ('".$get_option_id."')");
					  
		$stmt_c->execute();
		
		$rows_c = $stmt_c->fetchAll(PDO::FETCH_ASSOC);
		
		if($rows_c){
			foreach($rows_c as $row_c){
				$stmt = $conn->prepare('UPDATE cart SET quantity=:quantity WHERE option_yesno=:id_yesno AND options=:id');
						
				$stmt->execute(array(
					':quantity' => $row_c['quantity']+1,	
					':id' => $get_option_id,
					':id_yesno' => $get_option_id_yesno,		
				));
							
				$rows = $stmt->fetchAll();	
			}
			
		}else{
		
			$stmt_cart = $conn->prepare("SELECT * FROM menus WHERE id='".$id."'");
						  
			$stmt_cart->execute();
			
			$rows_cart = $stmt_cart->fetchAll(PDO::FETCH_ASSOC);
			
			if($rows_cart){
				foreach($rows_cart as $row_cart){
					$stmt = $conn->prepare('INSERT INTO `cart` (product_id, options, option_yesno, price, ip, cart_type, quantity)
					VALUES(:id,:options,:option_yesno,:price,:ip,:cart_type,:quantity)');
					if(isset($_GET['count2'], $_GET['count3']) && $_GET['count2']!='' && $_GET['count3']!=''){
						$options = '';
						$option_yesno = '';
						for($i = 1; $i < $_GET['count3']+1; $i++){
							$options .= $_GET['option_'.$i].',';
							$get_option_id = substr($options,0,strlen($options)-1);
						}
						for($j = 1; $j < $_GET['count2']+1; $j++){
							$option_yesno .= $_GET['option_yesno_'.$j].',';
							$get_option_id_yesno = substr($option_yesno,0,strlen($option_yesno)-1);
						}
					}
					$stmt->execute(array(
						':quantity' => 1,
						':id' => $row_cart['id'],
						':options' => $get_option_id,
						':option_yesno' => $get_option_id_yesno,
						':price' => $_GET['price'],
						':ip' => $_SERVER['REMOTE_ADDR'],
						':cart_type' => 'options'
					));
								
					$rows = $stmt->fetchAll();
				}
			}
		}
		
	}else if(isset($_GET['option_1']) && $_GET['option_1']!=''){
		if(isset($_GET['count3'])){
		$options = '';
		for($i = 1; $i < $_GET['count3']+1; $i++){
			$options .= $_GET['option_'.$i].',';
			$get_option_id = substr($options,0,strlen($options)-1);
		}
		}
		$stmt_c = $conn->prepare("SELECT * FROM cart WHERE options IN ('".$get_option_id."')");
					  
		$stmt_c->execute();
		
		$rows_c = $stmt_c->fetchAll(PDO::FETCH_ASSOC);
		
		if($rows_c){
			foreach($rows_c as $row_c){
				$stmt = $conn->prepare('UPDATE cart SET quantity=:quantity WHERE options=:id');
						
				$stmt->execute(array(
					':quantity' => $row_c['quantity']+1,	
					':id' => $get_option_id,		
				));
							
				$rows = $stmt->fetchAll();	
			}
			
		}else{
		
			$stmt_cart = $conn->prepare("SELECT * FROM menus WHERE id='".$id."'");
						  
			$stmt_cart->execute();
			
			$rows_cart = $stmt_cart->fetchAll(PDO::FETCH_ASSOC);
			
			if($rows_cart){
				foreach($rows_cart as $row_cart){
					$stmt = $conn->prepare('INSERT INTO `cart` (product_id, options, price, ip, cart_type, quantity)
					VALUES(:id,:options,:price,:ip,:cart_type,:quantity)');
					$options = '';
					for($i = 1; $i < $_GET['count3']+1; $i++){
						$options .= $_GET['option_'.$i].',';
						$get_option_id = substr($options,0,strlen($options)-1);
					}
					$stmt->execute(array(
						':quantity' => 1,
						':id' => $row_cart['id'],
						':options' => $get_option_id,
						':price' => $_GET['price'],
						':ip' => $_SERVER['REMOTE_ADDR'],
						':cart_type' => 'options'
					));
								
					$rows = $stmt->fetchAll();
				}
			}
		}
		
	}else if(isset($_GET['option_yesno_1'])){
		if(isset($_GET['count2'])){
		$options = '';
		for($i = 1; $i < $_GET['count2']+1; $i++){
			$options .= $_GET['option_yesno_'.$i].',';
			$get_option_id = substr($options,0,strlen($options)-1);
		}
		}
		$stmt_c = $conn->prepare("SELECT * FROM cart WHERE option_yesno IN ('".$get_option_id."')");
					  
		$stmt_c->execute();
		
		$rows_c = $stmt_c->fetchAll(PDO::FETCH_ASSOC);
		
		if($rows_c){
			foreach($rows_c as $row_c){
				$stmt = $conn->prepare('UPDATE cart SET quantity=:quantity WHERE option_yesno=:id');
						
				$stmt->execute(array(
					':quantity' => $row_c['quantity']+1,	
					':id' => $get_option_id,		
				));
							
				$rows = $stmt->fetchAll();	
			}
			
		}else{
		
			$stmt_cart = $conn->prepare("SELECT * FROM menus WHERE id='".$id."'");
						  
			$stmt_cart->execute();
			
			$rows_cart = $stmt_cart->fetchAll(PDO::FETCH_ASSOC);
			
			if($rows_cart){
				foreach($rows_cart as $row_cart){
					$stmt = $conn->prepare('INSERT INTO `cart` (product_id, option_yesno, price, ip, cart_type, quantity)
					VALUES(:id,:option_yesno,:price,:ip,:cart_type,:quantity)');
					$options = '';
					for($i = 1; $i < $_GET['count2']+1; $i++){
						$options .= $_GET['option_yesno_'.$i].',';
						$get_option_id = substr($options,0,strlen($options)-1);
					}
					$stmt->execute(array(
						':quantity' => 1,
						':id' => $row_cart['id'],
						':option_yesno' => $get_option_id,
						':price' => $_GET['price'],
						':ip' => $_SERVER['REMOTE_ADDR'],
						':cart_type' => 'options'
					));
								
					$rows = $stmt->fetchAll();
				}
			}
		}
		
	}else{
	
		$stmt_c = $conn->prepare("SELECT * FROM cart WHERE product_id='".$id."'");
					  
		$stmt_c->execute();
		
		$rows_c = $stmt_c->fetchAll(PDO::FETCH_ASSOC);
		
		if($rows_c){
			foreach($rows_c as $row_c){
				$stmt = $conn->prepare('UPDATE cart SET quantity=:quantity WHERE product_id=:id');
						
				$stmt->execute(array(
					':quantity' => $row_c['quantity']+1,	
					':id' => $id,		
				));
							
				$rows = $stmt->fetchAll();	
			}
			
		}else{
		
			$stmt_cart = $conn->prepare("SELECT * FROM menus WHERE id='".$id."'");
						  
			$stmt_cart->execute();
			
			$rows_cart = $stmt_cart->fetchAll(PDO::FETCH_ASSOC);
			
			if($rows_cart){
				foreach($rows_cart as $row_cart){
					$stmt = $conn->prepare('INSERT INTO `cart` (product_id, price, ip, cart_type, quantity)
					VALUES(:id,:price,:ip,:cart_type,:quantity)');
					$stmt->execute(array(
						':quantity' => 1,
						':id' => $row_cart['id'],
						':price' => $_GET['price'],
						':ip' => $_SERVER['REMOTE_ADDR'],
						':cart_type' => 'nooptions'
					));
					$rows = $stmt->fetchAll();
				}
			}
		}
	}
}else if(isset($_GET['action']) && $_GET['action']=='remove'){
	if(!empty($_SESSION["CART_USER_ID"])) {
		$sql_del = 'DELETE FROM cart WHERE id=:id';
		
		$stmt = $conn->prepare($sql_del);
						
		$stmt->execute(array(
			':id' => $_GET['id'],		
		));
					
		$rows = $stmt->fetchAll();	
	}
}
?>
<div id="cart">
  <div class="heading">
    <h4>Shopping Cart</h4>
    <a><span id="cart-total">0 item(s) - <?php echo PetroFDS::get_currency(); ?>0.00</span></a></div>
  <div class="content">
  <?php
  if(isset($_SESSION['CART_USER_ID'])){  
  		$item_total = 0;
  ?>
  <div id="ajax">
  	<div class="mini-cart-info">
      <table>
          <tbody id="info_product">
          <?php
		  $sql_z = 'SELECT * FROM cart WHERE ip=:ip';
		  
		  $stmt_z = $conn->prepare($sql_z);
					  
		  $stmt_z->execute(array(
		  	':ip' => $_SESSION['CART_USER_ID']
		  ));
		  
		  $rows_z = $stmt_z->fetchAll(PDO::FETCH_ASSOC);
		  
		  if($rows_z){
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
          <td class="image"></td>
          <td class="name"><strong class="pr_name"><?php
		  	  $opt_yesno = $row_z['option_yesno'];
			  $opt_yesno = rtrim($opt_yesno,',');
			  $sql_opt_1 = 'SELECT * FROM `option` WHERE id IN ('.$opt_yesno.')';
			  $stmt_opt_1 = $conn->prepare($sql_opt_1);
					  
			  $stmt_opt_1->execute();
			  
			  $rows_opt_1 = $stmt_opt_1->fetchAll(PDO::FETCH_ASSOC); 
		  if($row_z['options'] != ''){
			  $option_title_id = $row_z['options'];
			  $option_title_id = rtrim($option_title_id,',');
			  $sql_opt = 'SELECT * FROM `option_menu` WHERE id IN ('.$option_title_id.')';
			  $stmt_opt = $conn->prepare($sql_opt);
					  
			  $stmt_opt->execute();
			  
			  $rows_opt = $stmt_opt->fetchAll(PDO::FETCH_ASSOC);
			  
			  if($rows_opt){
				  $CART_TEXT = '';
				  if($rows_opt_1){ 
					  $CART_TEXT .= $row_s_cart['name'].' <small>With <br/>'; 
					  foreach($rows_opt as $row_opt){
						$CART_TEXT .= $row_opt['title'].'<br/>'; 
					  }
					  foreach($rows_opt_1 as $row_opt_1){
						$CART_TEXT .= '+'.$row_opt_1['title'].'<br/>';  
					  }
					  $CART_TEXT .= '</small>';
				  }else{
					  $CART_TEXT = '';
					  $CART_TEXT .= $row_s_cart['name'].' <small>With <br/>'; 
					  foreach($rows_opt as $row_opt){
						$CART_TEXT .= $row_opt['title'].'<br/>'; 
					  }
				  	  $CART_TEXT .= '</small>';
				  }
				  echo $CART_TEXT;
			  }
		  }else{
			  if($rows_opt_1){
				  $CART_TEXT = '';
				  $CART_TEXT .= $row_s_cart['name'].' <small><br/>';
				  foreach($rows_opt_1 as $row_opt_1){
					$CART_TEXT .= '+'.$row_opt_1['title'].'<br/>';  
				  }
				  $CART_TEXT .= '</small>';
				  echo $CART_TEXT;
			  }else{
				  echo $row_s_cart['name'];  
			  }
		  }
		  ?></strong>
                          <div>
                                         </div></td>
          <?php
			  }
		  }
		  $qty = $row_z['quantity'];
		  $total_with_qty = PetroFDS::Float_To_Decimal($row_z['price'])*$qty
		  ?>
          <td class="quantity">x&nbsp;<?php echo $qty; ?></td>
          <td class="total">
		  <?php 
		  echo '$'.$total_with_qty; 
		  ?>
          </td>
          <td class="remove"><a onClick="addtocart('remove','<?php echo $row_z['id'] ?>')" href="javascript:void(0)"><img src="images/remove-small.png" alt="Remove" title="Remove" onclick=""></a></td>
          </tr>
          <?php
			  }
		  }
		  ?>
          </tbody>
      </table>
    </div>
<?php
if($rows_z){
  $item_total += ($row_z['price']*$row_z['quantity']);			
?>
    <div class="mini-cart-total">
      <table>    
        <tbody><tr>
          <td class="right"><b>Sub-Total:</b></td>
          <td class="right">
          <?php
		  echo '$'.PetroFDS::Float_To_Decimal($item_total);
		  ?>
          </td>
        </tr>
                
        <tr>
          <td class="right"><b>Total:</b></td>
          <td class="right">
		  <?php
		  echo '$'.PetroFDS::Float_To_Decimal($total_all);
		  ?>
          </td>
        </tr>
              </tbody></table>
    </div>
    </div>
<div class="checkout"><a href="cart">View Cart</a> | <a href="checkout">Checkout</a></div>
<?php
}else{
	$stmt = $conn->prepare('DELETE FROM cart WHERE ip=:ip');
						
	$stmt->execute(array(
		':ip' => $_SERVER['REMOTE_ADDR'],		
	));
				
	$rows = $stmt->fetchAll();
	?>
    <div class="empty">Your shopping cart is empty!</div>
    <?php
}
  }else{
	  	$stmt = $conn->prepare('DELETE FROM cart WHERE ip=:ip');
						
		$stmt->execute(array(
			':ip' => $_SERVER['REMOTE_ADDR'],		
		));
					
		$rows = $stmt->fetchAll();
?>
        <div class="empty">Your shopping cart is empty!</div>
<?php
  }
?>
      </div>
</div>
<div style="display: none" class="customizable_options_widget">
</div>
<div class="freemsg">Free Home Delivery on Orders Over $10<br>
within a 3 mile radius
</div>