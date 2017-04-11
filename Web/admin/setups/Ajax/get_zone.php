<?php 

	include('../../auth_admin.php'); 
	require_once('../../../app/themes/lib/system.lib.php');
	$conn = PetroFDS::ConnectDB();
	
	$stmt = $conn->prepare('SELECT * FROM `system_config` WHERE status=1');

	$stmt->execute();

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if($rows){
		foreach($rows as $row){
			echo $row['country_region'];	
		}
	}