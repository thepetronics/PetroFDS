<?php 
	include('../auth_admin.php');

	require_once('../../app/themes/lib/system.lib.php');
	$conn = PetroFDS::ConnectDB();

	

	if($_POST['cate_status'] == "new"){

	

		$stmt = $conn->prepare('INSERT INTO post_code (postcode, price)

		VALUES(:postcode,:price)');

		foreach($_POST['postcode'] as $row=>$vars){

		$stmt->execute(array(

			':postcode' => $vars,

			':price' => $_POST['price'][$row]

		));

		}

		

		header('Location: set_post_code');

	

	}else{		

		if($_POST['postcode'] != "")

		{
			
			//Start taking values in an array

			$optinfo = array('id' => $_POST["id"],

						 'postcode' => $_POST["postcode"],

						 'price' => $_POST["price"]);

			//End taking values in an array			 

			$optdaysCount = count($optinfo["postcode"]);

			for ($i = 0; $i < $optdaysCount; $i++)

			{
				// START Custom Options UPDATE DATA

				if(isset($optinfo['id'][$i]) && $optinfo['id'][$i]!="")

				{
					$stmt_2 = $conn->prepare('UPDATE `post_code` SET postcode=:postcode,price=:price,deleted=:deleted WHERE id=:id');

					

						$stmt_2->execute(array(

							':postcode' => $_POST['postcode'][$i],

							':price' => $_POST['price'][$i],

							':id' => $_POST['id'][$i],

							':deleted' => $_POST['code_deleted'][$i],

						));
				}else{
					
					$stmt_3 = $conn->prepare('INSERT INTO `post_code` (postcode, price, deleted)

					VALUES(:postcode,:price,:deleted)');

				

					$stmt_3->execute(array(

						':postcode' => $optinfo['postcode'][$i],

						':price' => $optinfo['price'][$i],

						':deleted' => $_POST['code_deleted'][$i],

					));
					
				}

			}
		}
		header('Location: set_post_code');

	}

?>