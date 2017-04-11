<?php 

	include('../../auth_admin.php'); 
	require_once('../../../app/themes/lib/system.lib.php');
	$conn = PetroFDS::ConnectDB();
		
	$stmt = $conn->prepare("SELECT * FROM option_type WHERE status=1");

	$stmt->execute();

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	echo '<OPTION value=""></OPTION>';
if($rows){
	foreach($rows as $row){
		echo '<OPTION value="'.$row['id'].'">'.$row['type'].'</OPTION>';	
	}
}