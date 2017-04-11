<?php
session_start();

include_once '../../app/themes/lib/system.lib.php';

$conn = PetroFDS::ConnectDB();

if(isset($_GET['id']) && $_GET['id']!=''){
	$rows = PetroFDS::getUsers('AND email="'.$_GET['email'].'" AND id="'.$_GET['id'].'"');
	
	if($rows){
		echo 'notavailable';
	}else{
		$rows_1 = PetroFDS::getUsers('AND email="'.$_GET['email'].'"');
		if($rows_1){
			echo 'available';
		}else{
			echo 'notavailable';
		}
	}
}else{
	$rows = PetroFDS::getUsers('AND email="'.$_GET['email'].'"');
	
	if($rows){
		echo 'available';
	}else{
		echo 'notavailable';
	}
}