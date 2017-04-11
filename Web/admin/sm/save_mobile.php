<?php 
	include('../auth_admin.php');
	require_once('../../app/themes/lib/system.lib.php');
	$conn = PetroFDS::ConnectDB();

	if($_POST['mobile_status'] == "new"){

	

		$stmt = $conn->prepare('INSERT INTO mobile_setting (api_key)

		VALUES(:api_key)');

			

		$stmt->execute(array(

			':api_key' => $_POST['api_key'],

		));

		header('Location: mobile');

	}else{
		$stmt_2 = $conn->prepare('UPDATE `mobile_setting` SET api_key=:api_key WHERE id=:id');

					

		$stmt_2->execute(array(

			':api_key' => $_POST['api_key'],
			
			':id' => $_POST['id']

		));

		header('Location: mobile');

	}

?>