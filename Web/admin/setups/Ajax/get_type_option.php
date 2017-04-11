<?php 

	include('../../auth_admin.php'); 
	require_once('../../../app/themes/lib/system.lib.php');
	$conn = PetroFDS::ConnectDB();
	
	$stmt = $conn->prepare('SELECT * FROM `option` WHERE status=1 AND is_yes_no=0 AND type_id=0');

	$stmt->execute();

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if($rows){
		echo '<option value=""></option>';
		foreach($rows as $row){
			echo '<OPTION value="'.$row['id'].'">'.$row['title'].'</OPTION>';	
		}
	}