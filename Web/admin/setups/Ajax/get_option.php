<?php 

	require_once('../../../app/themes/lib/system.lib.php');
	$conn = PetroFDS::ConnectDB();
	
	$child_id = ''.$_GET['child_id'].'';
	
	$stmt = $conn->prepare('SELECT * FROM `option_menu` WHERE id IN ('.$child_id.')');

	$stmt->execute();

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if($rows){
		echo '<select class="selectpicker" data-style="btn-primary" required="required">';
		echo '<OPTION value=""></OPTION>';
		foreach($rows as $row){
			echo '<OPTION id="'.$row['id'].'" value="'.$row['children'].'">'.$row['title'].'</OPTION>';	
		}
		echo '</select>';
	}