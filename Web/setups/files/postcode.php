<?php

session_start();

include_once '../../app/themes/lib/system.lib.php';

$conn = PetroFDS::ConnectDB();



$postcode = $_GET['postcode'];



if(isset($postcode) && $postcode!=''){

	$sql_postcode = "SELECT * FROM post_code WHERE deleted=0 AND postcode='".$postcode."'";

	$stmt = $conn->prepare($sql_postcode);	

	$stmt->execute();

	

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	

	if($rows){

		foreach($rows as $row){

			$_SESSION['POST_CODE'] = $row['postcode'];

			echo 'Success';

		}

	}else{

		echo 'NotFound';	

	}

}else{

	echo 'Failed';

}