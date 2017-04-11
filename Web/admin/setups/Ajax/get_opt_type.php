<?php 

	require_once('../../../app/themes/lib/system.lib.php');
	$conn = PetroFDS::ConnectDB();
	$ln = $_GET['ln'];
	$i = 0;	
	$stmt = $conn->prepare("SELECT * FROM `option_type` WHERE status=1");

	$stmt->execute();

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if($rows){
		foreach($rows as $row){
			$i++;
			$HTML = '';
			$HTML .= '<input type="hidden" id="option_custom_'.$i.'_'.$ln.'" value="0" />';
			$HTML .= '<label class="checkbox"><input type="checkbox" name="option_custom_check[]" id="option_custom_check_'.$i.'_'.$ln.'" value="0" onclick="check_click_custom(\''.$ln.'\',\''.$i.'\',\'option_custom\',\''.$row['id'].'\')" />'.$row['type'].'</label>';
			echo $HTML;
		}
	}