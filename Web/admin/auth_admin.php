<?php
	//Start session
	session_start();
	
	//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['SESS_USER_ID']) || (trim($_SESSION['SESS_USER_ID']) == '')) {
			header("location: ../index.php?session=1");
			exit();
	}
	
	if($_SESSION['ROLE_ID']!=0){
		$dir = dirname(__FILE__).'/session/'.$_SESSION['SESS_USERNAME'].'/';
		foreach (glob($dir."*") as $file) {
			$string = file_get_contents($file);
			$permission = json_decode($string, true);
		}
	}
?>