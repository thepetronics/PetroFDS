<?php

$sql_empty_cart = 'DELETE FROM cart WHERE date_created < (NOW() - INTERVAL 300 MINUTE)';

PetroFDS::CustomQuery($sql_empty_cart);

if(isset($_GET['action']) && $_GET['action']=='add'){

	$date_created = date('Y-m-d H:i:s a');

	$id=intval($_GET['id']);

	$_SESSION['CART_USER_ID'] = PetroFDS::get_client_ip_env();

	if(isset($_GET['option_1'], $_GET['option_yesno_1'], $_GET['option_notype_1'], $_GET['option_notype_title_1']) && $_GET['option_1']!='' && $_GET['option_yesno_1']!='' && $_GET['option_notype_1']!='' && $_GET['option_notype_title_1']!=''){

		if(isset($_GET['count2'], $_GET['count3'], $_GET['count4']) && $_GET['count2']!='' && $_GET['count3']!='' && $_GET['count4']!=''){

			$options = '';

			$option_yesno = '';

			$option_notype = '';

			$option_notype_title = '';

			for($i = 1; $i < $_GET['count3']+1; $i++){

				$options .= $_GET['option_'.$i].',';

				$get_option_id = substr($options,0,strlen($options)-1);

			}

			for($j = 1; $j < $_GET['count2']+1; $j++){

				$option_yesno .= $_GET['option_yesno_'.$j].',';

				$get_option_id_yesno = substr($option_yesno,0,strlen($option_yesno)-1);

			}

			for($k = 1; $k < $_GET['count4']+1; $k++){

				$option_notype .= $_GET['option_notype_'.$k].',';

				$option_notype_title .= $_GET['option_notype_title_'.$k].',';

				$get_option_id_notype = substr($option_notype,0,strlen($option_notype)-1);

				$get_option_id_notype_title = substr($option_notype_title,0,strlen($option_notype_title)-1);

			}

		}

		$stmt_c = $conn->prepare("SELECT * FROM cart WHERE option_yesno IN ('".$get_option_id_yesno."') AND options IN ('".$get_option_id."') AND option_notype IN ('".$get_option_id_notype."') AND option_notype_title IN ('".$get_option_id_notype_title."')");

					  

		$stmt_c->execute();

		

		$rows_c = $stmt_c->fetchAll(PDO::FETCH_ASSOC);

		

		if($rows_c){

			foreach($rows_c as $row_c){

				$stmt = $conn->prepare('UPDATE cart SET quantity=:quantity WHERE option_yesno=:id_yesno AND options=:id AND option_notype=:id_notype AND option_notype_title=:id_notype_title');

						

				$stmt->execute(array(

					':quantity' => $row_c['quantity']+1,	

					':id' => $get_option_id,

					':id_yesno' => $get_option_id_yesno,

					':id_notype' => $get_option_id_notype,

					':id_notype_title' => $get_option_id_notype_title,		

				));

			}

			

		}else{

		

			$stmt_cart = $conn->prepare("SELECT * FROM menus WHERE id='".$id."'");

						  

			$stmt_cart->execute();

			

			$rows_cart = $stmt_cart->fetchAll(PDO::FETCH_ASSOC);

			

			if($rows_cart){

				foreach($rows_cart as $row_cart){

					if(isset($_GET['title']) && $_GET['title']!=''){

						$stmt = $conn->prepare('INSERT INTO `cart` (product_id, options, option_yesno, option_notype, option_notype_title, title_custom, price, ip, cart_type, quantity,date_created)

						VALUES(:id,:options,:option_yesno,:option_notype,:option_notype_title,'.$_GET['title'].',:price,:ip,:cart_type,:quantity,:date_created)');

					}else{

						$stmt = $conn->prepare('INSERT INTO `cart` (product_id, options, option_yesno, option_notype, option_notype_title, price, ip, cart_type, quantity,date_created)

						VALUES(:id,:options,:option_yesno,:option_notype,:option_notype_title,:price,:ip,:cart_type,:quantity,:date_created)');

					}

					if(isset($_GET['count2'], $_GET['count3'], $_GET['count4']) && $_GET['count2']!='' && $_GET['count3']!='' && $_GET['count4']!=''){

						$options = '';

						$option_yesno = '';

						$option_notype = '';

						$option_notype_title = '';

						for($i = 1; $i < $_GET['count3']+1; $i++){

							$options .= $_GET['option_'.$i].',';

							$get_option_id = substr($options,0,strlen($options)-1);

						}

						for($j = 1; $j < $_GET['count2']+1; $j++){

							$option_yesno .= $_GET['option_yesno_'.$j].',';

							$get_option_id_yesno = substr($option_yesno,0,strlen($option_yesno)-1);

						}

						for($k = 1; $k < $_GET['count4']+1; $k++){

							$option_notype .= $_GET['option_notype_'.$k].',';

							$option_notype_title .= $_GET['option_notype_title_'.$k].',';

							$get_option_id_notype = substr($option_notype,0,strlen($option_notype)-1);

							$get_option_id_notype_title = substr($option_notype_title,0,strlen($option_notype_title)-1);

						}

					}

					

					$array = array(

						':quantity' => 1,

						':id' => $row_cart['id'],

						':options' => $get_option_id,

						':option_yesno' => $get_option_id_yesno,

						':option_notype' => $get_option_id_notype,

						':option_notype_title' => $get_option_id_notype_title,

						':price' => $_GET['price'],

						':ip' => $_SERVER['REMOTE_ADDR'],

						':cart_type' => 'options',

						':date_created' => $date_created

					);

					

					$stmt->execute($array);

				}

			}

		}

		

	}else if(isset($_GET['option_1'], $_GET['option_yesno_1']) && $_GET['option_1']!='' && $_GET['option_yesno_1']!=''){

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

			}

			

		}else{

		

			$stmt_cart = $conn->prepare("SELECT * FROM menus WHERE id='".$id."'");

						  

			$stmt_cart->execute();

			

			$rows_cart = $stmt_cart->fetchAll(PDO::FETCH_ASSOC);

			

			if($rows_cart){

				foreach($rows_cart as $row_cart){

					if(isset($_GET['title']) && $_GET['title']!=''){

						$stmt = $conn->prepare('INSERT INTO `cart` (product_id, options, option_yesno, title_custom, price, ip, cart_type, quantity,date_created)

						VALUES(:id,:options,:option_yesno,'.$_GET['title'].',:price,:ip,:cart_type,:quantity,:date_created)');

					}else{

						$stmt = $conn->prepare('INSERT INTO `cart` (product_id, options, option_yesno, price, ip, cart_type, quantity,date_created)

						VALUES(:id,:options,:option_yesno,:price,:ip,:cart_type,:quantity,:date_created)');

					}

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

					

					$array = array(

						':quantity' => 1,

						':id' => $row_cart['id'],

						':options' => $get_option_id,

						':option_yesno' => $get_option_id_yesno,

						':price' => $_GET['price'],

						':ip' => $_SERVER['REMOTE_ADDR'],

						':cart_type' => 'options',

						':date_created' => $date_created

					);

					

					$stmt->execute($array);

				}

			}

		}

		

	}else if(isset($_GET['option_yesno_1'], $_GET['option_notype_1'], $_GET['option_notype_title_1']) && $_GET['option_yesno_1']!='' && $_GET['option_notype_1']!='' && $_GET['option_notype_title_1']!=''){

		if(isset($_GET['count2'], $_GET['count4']) && $_GET['count2']!='' && $_GET['count4']!=''){

			$option_yesno = '';

			$option_notype = '';

			$option_notype_title = '';

			for($j = 1; $j < $_GET['count2']+1; $j++){

				$option_yesno .= $_GET['option_yesno_'.$j].',';

				$get_option_id_yesno = substr($option_yesno,0,strlen($option_yesno)-1);

			}

			for($k = 1; $k < $_GET['count4']+1; $k++){

				$option_notype .= $_GET['option_notype_'.$k].',';

				$option_notype_title .= $_GET['option_notype_title_'.$k].',';

				$get_option_id_notype = substr($option_notype,0,strlen($option_notype)-1);

				$get_option_id_notype_title = substr($option_notype_title,0,strlen($option_notype_title)-1);

			}

		}

		$stmt_c = $conn->prepare("SELECT * FROM cart WHERE option_yesno IN ('".$get_option_id_yesno."') AND option_notype IN ('".$get_option_id_notype."') AND option_notype_title IN ('".$get_option_id_notype_title."')");

					  

		$stmt_c->execute();

		

		$rows_c = $stmt_c->fetchAll(PDO::FETCH_ASSOC);

		

		if($rows_c){

			foreach($rows_c as $row_c){

				$stmt = $conn->prepare('UPDATE cart SET quantity=:quantity WHERE option_yesno=:id_yesno AND option_notype=:id_notype AND option_notype_title=:id_notype_title');

						

				$stmt->execute(array(

					':quantity' => $row_c['quantity']+1,	

					':id_yesno' => $get_option_id_yesno,

					':id_notype' => $get_option_id_notype,

					':id_notype_title' => $get_option_id_notype_title,		

				));	

			}

			

		}else{

		

			$stmt_cart = $conn->prepare("SELECT * FROM menus WHERE id='".$id."'");

						  

			$stmt_cart->execute();

			

			$rows_cart = $stmt_cart->fetchAll(PDO::FETCH_ASSOC);

			

			if($rows_cart){

				foreach($rows_cart as $row_cart){

					if(isset($_GET['title']) && $_GET['title']!=''){

						$stmt = $conn->prepare('INSERT INTO `cart` (product_id, option_yesno, option_notype, option_notype_title, title_custom, price, ip, cart_type, quantity,date_created)

						VALUES(:id,:option_yesno,:option_notype,:option_notype_title,'.$_GET['title'].',:price,:ip,:cart_type,:quantity,:date_created)');

					}else{

						$stmt = $conn->prepare('INSERT INTO `cart` (product_id, option_yesno, option_notype, option_notype_title, price, ip, cart_type, quantity,date_created)

						VALUES(:id,:option_yesno,:option_notype,:option_notype_title,:price,:ip,:cart_type,:quantity,:date_created)');

					}

					if(isset($_GET['count2'], $_GET['count4']) && $_GET['count2']!='' && $_GET['count4']!=''){

						$option_yesno = '';

						$option_notype = '';

						$option_notype_title = '';

						for($j = 1; $j < $_GET['count2']+1; $j++){

							$option_yesno .= $_GET['option_yesno_'.$j].',';

							$get_option_id_yesno = substr($option_yesno,0,strlen($option_yesno)-1);

						}

						for($k = 1; $k < $_GET['count4']+1; $k++){

							$option_notype .= $_GET['option_notype_'.$k].',';

							$option_notype_title .= $_GET['option_notype_title_'.$k].',';

							$get_option_id_notype = substr($option_notype,0,strlen($option_notype)-1);

							$get_option_id_notype_title = substr($option_notype_title,0,strlen($option_notype_title)-1);

						}

					}

					

					$array = array(

						':quantity' => 1,

						':id' => $row_cart['id'],

						':option_yesno' => $get_option_id_yesno,

						':option_notype' => $get_option_id_notype,

						':option_notype_title' => $get_option_id_notype_title,

						':price' => $_GET['price'],

						':ip' => $_SERVER['REMOTE_ADDR'],

						':cart_type' => 'options',

						':date_created' => $date_created

					);

					

					$stmt->execute($array);

				}

			}

		}

		

	}else if(isset($_GET['option_1'], $_GET['option_notype_1'], $_GET['option_notype_title_1']) && $_GET['option_1']!='' && $_GET['option_notype_1']!='' && $_GET['option_notype_title_1']!=''){

		if(isset($_GET['count3'], $_GET['count4']) && $_GET['count3']!='' && $_GET['count4']!=''){

			$options = '';

			$option_yesno = '';

			$option_notype = '';

			$option_notype_title = '';

			for($i = 1; $i < $_GET['count3']+1; $i++){

				$options .= $_GET['option_'.$i].',';

				$get_option_id = substr($options,0,strlen($options)-1);

			}

			for($k = 1; $k < $_GET['count4']+1; $k++){

				$option_notype .= $_GET['option_notype_'.$k].',';

				$option_notype_title .= $_GET['option_notype_title_'.$k].',';

				$get_option_id_notype = substr($option_notype,0,strlen($option_notype)-1);

				$get_option_id_notype_title = substr($option_notype_title,0,strlen($option_notype_title)-1);

			}

		}

		$stmt_c = $conn->prepare("SELECT * FROM cart WHERE options IN ('".$get_option_id."') AND option_notype IN ('".$get_option_id_notype."') AND option_notype_title IN ('".$get_option_id_notype_title."')");

					  

		$stmt_c->execute();

		

		$rows_c = $stmt_c->fetchAll(PDO::FETCH_ASSOC);

		

		if($rows_c){

			foreach($rows_c as $row_c){

				$stmt = $conn->prepare('UPDATE cart SET quantity=:quantity WHERE option_yesno=:id_yesno AND options=:id AND option_notype=:id_notype AND option_notype_title=:id_notype_title');

						

				$stmt->execute(array(

					':quantity' => $row_c['quantity']+1,	

					':id' => $get_option_id,

					':id_notype' => $get_option_id_notype,

					':id_notype_title' => $get_option_id_notype_title,		

				));	

			}

			

		}else{

		

			$stmt_cart = $conn->prepare("SELECT * FROM menus WHERE id='".$id."'");

						  

			$stmt_cart->execute();

			

			$rows_cart = $stmt_cart->fetchAll(PDO::FETCH_ASSOC);

			

			if($rows_cart){

				foreach($rows_cart as $row_cart){

					if(isset($_GET['title']) && $_GET['title']!=''){

						$stmt = $conn->prepare('INSERT INTO `cart` (product_id, options, option_notype, option_notype_title, title_custom, price, ip, cart_type, quantity,date_created)

						VALUES(:id,:options,:option_notype,:option_notype_title,'.$_GET['title'].',:price,:ip,:cart_type,:quantity,:date_created)');

					}else{

						$stmt = $conn->prepare('INSERT INTO `cart` (product_id, options, option_notype, option_notype_title, price, ip, cart_type, quantity,date_created)

						VALUES(:id,:options,:option_notype,:option_notype_title,:price,:ip,:cart_type,:quantity,:date_created)');

					}

					if(isset($_GET['count3'], $_GET['count4']) && $_GET['count3']!='' && $_GET['count4']!=''){

						$options = '';

						$option_notype = '';

						$option_notype_title = '';

						for($i = 1; $i < $_GET['count3']+1; $i++){

							$options .= $_GET['option_'.$i].',';

							$get_option_id = substr($options,0,strlen($options)-1);

						}

						for($k = 1; $k < $_GET['count4']+1; $k++){

							$option_notype .= $_GET['option_notype_'.$k].',';

							$option_notype_title .= $_GET['option_notype_title_'.$k].',';

							$get_option_id_notype = substr($option_notype,0,strlen($option_notype)-1);

							$get_option_id_notype_title = substr($option_notype_title,0,strlen($option_notype_title)-1);

						}

					}

					

					$array = array(

						':quantity' => 1,

						':id' => $row_cart['id'],

						':options' => $get_option_id,

						':option_notype' => $get_option_id_notype,

						':option_notype_title' => $get_option_id_notype_title,

						':price' => $_GET['price'],

						':ip' => $_SERVER['REMOTE_ADDR'],

						':cart_type' => 'options',

						':date_created' => $date_created

					);

					

					$stmt->execute($array);

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

		$stmt_c = $conn->prepare("SELECT * FROM cart WHERE options IN ('".$get_option_id."') AND product_id='".$_GET['id']."'");

					  

		$stmt_c->execute();

		

		$rows_c = $stmt_c->fetchAll(PDO::FETCH_ASSOC);

		

		if($rows_c){

			foreach($rows_c as $row_c){
				$stmt = $conn->prepare('UPDATE cart SET quantity=:quantity WHERE options=:id');
	
						
	
				$stmt->execute(array(
	
					':quantity' => $row_c['quantity']+1,	
	
					':id' => $get_option_id,		
	
				));
			}

			

		}else{
			
			$stmt_cart = $conn->prepare("SELECT * FROM menus WHERE id='".$id."'");

						  

			$stmt_cart->execute();

			

			$rows_cart = $stmt_cart->fetchAll(PDO::FETCH_ASSOC);

			

			if($rows_cart){

				foreach($rows_cart as $row_cart){
					if(isset($_GET['title']) && $_GET['title']!=''){

						$stmt = $conn->prepare('INSERT INTO `cart` (product_id, options, title_custom, price, ip, cart_type, quantity,date_created)

						VALUES(:id,:options,'.$_GET['title'].',:price,:ip,:cart_type,:quantity,:date_created)');

					}else{

						$stmt = $conn->prepare('INSERT INTO `cart` (product_id, options, price, ip, cart_type, quantity,date_created)

						VALUES(:id,:options,:price,:ip,:cart_type,:quantity,:date_created)');

					}

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

						':cart_type' => 'options',

						':date_created' => $date_created

					));

				}

			}

		}

		

	}else if(isset($_GET['option_yesno_1']) && $_GET['option_yesno_1']!=''){

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

			}

			

		}else{

		

			$stmt_cart = $conn->prepare("SELECT * FROM menus WHERE id='".$id."'");

						  

			$stmt_cart->execute();

			

			$rows_cart = $stmt_cart->fetchAll(PDO::FETCH_ASSOC);

			

			if($rows_cart){

				foreach($rows_cart as $row_cart){

					if(isset($_GET['title']) && $_GET['title']!=''){

						$stmt = $conn->prepare('INSERT INTO `cart` (product_id, option_yesno, title_custom, price, ip, cart_type, quantity,date_created)

						VALUES(:id,:option_yesno,'.$_GET['title'].',:price,:ip,:cart_type,:quantity,:date_created)');

					}else{

						$stmt = $conn->prepare('INSERT INTO `cart` (product_id, option_yesno, price, ip, cart_type, quantity,date_created)

						VALUES(:id,:option_yesno,:price,:ip,:cart_type,:quantity,:date_created)');

					}

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

						':cart_type' => 'options',

						':date_created' => $date_created

					));

				}

			}

		}

		

	}else if(isset($_GET['option_notype_1'], $_GET['option_notype_title_1']) && $_GET['option_notype_1']!='' && $_GET['option_notype_title_1']!=''){

		if(isset($_GET['count4'])){

		$option_notype = '';

		$option_notype_title = '';

		for($i = 1; $i < $_GET['count4']+1; $i++){

			$option_notype .= $_GET['option_notype_'.$i].',';

			$option_notype_title .= $_GET['option_notype_title_'.$i].',';

			$get_option_id_notype = substr($option_notype,0,strlen($option_notype)-1);

			$get_option_id_notype_title = substr($option_notype_title,0,strlen($option_notype_title)-1);

		}

		}

		$stmt_c = $conn->prepare("SELECT * FROM cart WHERE option_notype IN ('".$get_option_id_notype."') AND option_notype_title IN ('".$get_option_id_notype_title."')");

					  

		$stmt_c->execute();

		

		$rows_c = $stmt_c->fetchAll(PDO::FETCH_ASSOC);

		

		if($rows_c){

			foreach($rows_c as $row_c){

				$stmt = $conn->prepare('UPDATE cart SET quantity=:quantity WHERE option_notype=:id AND option_notype_title=:id_title');

						

				$stmt->execute(array(

					':quantity' => $row_c['quantity']+1,	

					':id' => $get_option_id_notype,

					':id_title' => $get_option_id_notype_title,		

				));	

			}

			

		}else{

			$stmt_cart = $conn->prepare("SELECT * FROM menus WHERE id='".$id."'");

						  

			$stmt_cart->execute();

			

			$rows_cart = $stmt_cart->fetchAll(PDO::FETCH_ASSOC);

			

			if($rows_cart){

				foreach($rows_cart as $row_cart){

					if(isset($_GET['title']) && $_GET['title']!=''){

						$stmt = $conn->prepare('INSERT INTO `cart` (product_id, option_notype, option_notype_title, title_custom, price, ip, cart_type, quantity,date_created)

						VALUES(:id,:option_notype,:option_notype_title,'.$_GET['title'].',:price,:ip,:cart_type,:quantity,:date_created)');

					}else{

						$stmt = $conn->prepare('INSERT INTO `cart` (product_id, option_notype, option_notype_title, price, ip, cart_type, quantity,date_created)

						VALUES(:id,:option_notype,:option_notype_title,:price,:ip,:cart_type,:quantity,:date_created)');

					}

					$option_notype = '';

					$option_notype_title = '';

					for($i = 1; $i < $_GET['count4']+1; $i++){

						$option_notype .= $_GET['option_notype_'.$i].',';

						$option_notype_title .= $_GET['option_notype_title_'.$i].',';

						$get_option_id_notype = substr($option_notype,0,strlen($option_notype)-1);

						$get_option_id_notype_title = substr($option_notype_title,0,strlen($option_notype_title)-1);

					}

					$stmt->execute(array(

						':quantity' => 1,

						':id' => $row_cart['id'],

						':option_notype' => $get_option_id_notype,

						':option_notype_title' => $get_option_id_notype_title,

						':price' => $_GET['price'],

						':ip' => $_SERVER['REMOTE_ADDR'],

						':cart_type' => 'options',

						':date_created' => $date_created

					));

				}

			}

		}

		

	}else{

		$stmt_c = $conn->prepare("SELECT * FROM cart WHERE product_id='".$id."'");

					  

		$stmt_c->execute();

		

		$rows_c = $stmt_c->fetchAll(PDO::FETCH_ASSOC);

		

		if($rows_c){

			if(isset($_GET['title']) && $_GET['title']!='undefined'){

				$stmt_custom = $conn->prepare("SELECT * FROM cart WHERE title_custom='".$_GET['title']."'");

					  

				$stmt_custom->execute();

				

				$rows_custom = $stmt_custom->fetchAll(PDO::FETCH_ASSOC);

				

				if($rows_custom){

					foreach($rows_custom as $row_custom){

						$stmt = $conn->prepare('UPDATE cart SET quantity=:quantity WHERE title_custom=:title_custom');
								

						$stmt->execute(array(

							':quantity' => $row_custom['quantity']+1,	

							':title_custom' => $_GET['title'],		

						));

					}

				}else{

					$stmt = $conn->prepare('INSERT INTO `cart` (product_id, title_custom, price, ip, cart_type, quantity,date_created)

					VALUES(:id,'.$_GET['title'].',:price,:ip,:cart_type,:quantity,:date_created)');					

					$stmt->execute(array(

						':quantity' => 1,

						':id' => $id,

						':price' => $_GET['price'],

						':ip' => $_SERVER['REMOTE_ADDR'],

						':cart_type' => 'nooptions',

						':date_created' => $date_created

					));

				}			

			}else{

				foreach($rows_c as $row_c){

					$stmt = $conn->prepare('UPDATE cart SET quantity=:quantity WHERE product_id=:id');

									

					$stmt->execute(array(

						':quantity' => $row_c['quantity']+1,	

						':id' => $id,		

					));

				}

			}

		}else{

			$stmt_cart = $conn->prepare("SELECT * FROM menus WHERE id='".$id."'");

						  

			$stmt_cart->execute();

			

			$rows_cart = $stmt_cart->fetchAll(PDO::FETCH_ASSOC);

			

			if($rows_cart){

				foreach($rows_cart as $row_cart){

					if(isset($_GET['title']) && $_GET['title']!=''){

						$stmt = $conn->prepare('INSERT INTO `cart` (product_id, title_custom, price, ip, cart_type, quantity,date_created)

						VALUES(:id,'.$_GET['title'].',:price,:ip,:cart_type,:quantity,:date_created)');

					}else{

						$stmt = $conn->prepare('INSERT INTO `cart` (product_id, price, ip, cart_type, quantity,date_created)

						VALUES(:id,:price,:ip,:cart_type,:quantity,:date_created)');

					}

					$stmt->execute(array(

						':quantity' => 1,

						':id' => $row_cart['id'],

						':price' => $_GET['price'],

						':ip' => $_SERVER['REMOTE_ADDR'],

						':cart_type' => 'nooptions',

						':date_created' => $date_created

					));

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

	}

}else if(isset($_GET['action']) && $_GET['action']=='plus'){

	if(!empty($_SESSION["CART_USER_ID"])) {

		$id = $_GET['id'];

		

		$sql = "SELECT * FROM cart WHERE id='".$id."'";

		

		$stmt = $conn->prepare($sql);

					  

		$stmt->execute();

		

		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		

		if($rows){

			foreach($rows as $row){

				$sql_del = 'UPDATE cart SET quantity=:quantity WHERE id=:id';

				

				$stmt = $conn->prepare($sql_del);

								

				$stmt->execute(array(

					':id' => $id,

					':quantity' => $row['quantity']+1,		

				));		

			}

		}

	}

}