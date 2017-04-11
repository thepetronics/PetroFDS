<?php 

	include('../auth_admin.php');
	require_once('../../app/themes/lib/system.lib.php');
	$conn = PetroFDS::ConnectDB();

	

	if($_POST['cate_status'] == "new"){

	

		$stmt = $conn->prepare('INSERT INTO system_config (website_title, website_path, website_currency, price_discount, store_postcode, country_region, status)

		VALUES(:website_title,:website_path,:website_currency,:price_discount,:store_postcode,:country_region,:status)');

			

		$stmt->execute(array(

			':website_title' => $_POST['web_title'],

			':website_path' => $_POST['web_path'],

			':website_currency' => $_POST['web_currency'],

			':price_discount' => $_POST['price_discount'],

			':store_postcode' => $_POST['store_postcode'],

			':country_region' => $_POST['country_region'],

			':status' => $_POST['status']

		));

		

		$stmt_1 = $conn->prepare("SELECT * FROM `system_config` WHERE status=1 ORDER BY id DESC LIMIT 1");



		$stmt_1->execute();

	

		$rows_1 = $stmt_1->fetchAll(PDO::FETCH_ASSOC);

		

		if($rows_1){

			foreach($rows_1 as $row_1){

				if($_POST['days']!=''){

					$stmt_2 = $conn->prepare('INSERT INTO website_open_close (system_config_id, days, website_open, website_close, total_hours)

					VALUES(:system_config_id,:days,:website_open,:website_close,:total_hours)');

						

					foreach($_POST['days'] as $row=>$vars){

						$stmt_2->execute(array(

							':system_config_id' => $row_1['id'],

							':days' => $vars,

							':website_open' => $_POST['open_time'][$row],

							':website_close' => $_POST['close_time'][$row],

							':total_hours' => $_POST['total_hours'][$row]

						));

					}

				}

			}

		}

		

		header('Location: system_config');

	

	}else{

			

		$stmt = $conn->prepare('UPDATE system_config SET website_title=:website_title, website_path=:website_path, website_currency=:website_currency, price_discount=:price_discount, store_postcode=:store_postcode, country_region=:country_region, status=:status WHERE id=:id');

		 

		$stmt->execute(array(

			':website_title' => $_POST['web_title'],

			':website_path' => $_POST['web_path'],

			':website_currency' => $_POST['web_currency'],

			':price_discount' => $_POST['price_discount'],

			':store_postcode' => $_POST['store_postcode'],

			':country_region' => $_POST['country_region'],

			':status' => $_POST['status'],

			':id' => $_POST['id']			

		));

					

		if($_POST['days'] != "")

		{

			//Start taking values in an array

			$optinfo = array('system_config_id' => $_POST["system_config_id"],

						 'line_id' => $_POST["line_id"],						  

						 'days' => $_POST["days"],

						 'website_open' => $_POST["open_time"],					 

						 'website_close' => $_POST["close_time"],

						 'total_hours' => $_POST["total_hours"],

						 'opt_deleted' => $_POST["opt_deleted"]);

			//End taking values in an array			 

			$optdaysCount = count($optinfo["days"]);

			

			for ($i = 0; $i < $optdaysCount; $i++)

			{

				// START Custom Options UPDATE DATA

				if($optinfo['line_id'][$i]!="")

				{

					$stmt_2 = $conn->prepare('UPDATE `website_open_close` SET days=:days,website_open=:website_open,website_close=:website_close,total_hours=:total_hours,deleted=:deleted WHERE id=:id AND system_config_id=:system_config_id');

					

						$stmt_2->execute(array(

							':days' => $_POST['days'][$i],

							':website_open' => $_POST['open_time'][$i],

							':website_close' => $_POST['close_time'][$i],

							':total_hours' => $_POST['total_hours'][$i],

							':system_config_id' => $_POST['system_config_id'][$i],

							':id' => $_POST['line_id'][$i],

							':deleted' => $_POST['opt_deleted'][$i],

						));

				}else{

					$stmt_1 = $conn->prepare("SELECT * FROM `system_config` WHERE status=1 ORDER BY id DESC LIMIT 1");



					$stmt_1->execute();

				

					$rows_1 = $stmt_1->fetchAll(PDO::FETCH_ASSOC);

					

					if($rows_1){

						foreach($rows_1 as $row_1){

							$stmt_2 = $conn->prepare('INSERT INTO `website_open_close` (system_config_id, days, website_open, website_close, total_hours, deleted)

							VALUES(:system_config_id,:days,:website_open,:website_close,:total_hours,:deleted)');

						

							$stmt_2->execute(array(

								':system_config_id' => $row_1['id'],

								':days' => $optinfo['days'][$i],

								':website_open' => $optinfo['website_open'][$i],

								':website_close' => $optinfo['website_close'][$i],

								':total_hours' => $optinfo['total_hours'][$i],

								':deleted' => $_POST['opt_deleted'][$i],

							));

								

						}

					}

				}

			}

		}

		

		header('Location: system_config');

	}

?>