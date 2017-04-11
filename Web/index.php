<?php

if(!file_exists('app/themes/lib/db.cfg')){
	die('Please Install the application to start proceeding and please connect to the internet for installation PATH=/install.');
}else{
	include_once 'app/themes/lib/system.lib.php';
	/** Database Connection **/
	$conn = PetroFDS::ConnectDB();
	
	/** Set Timezone **/
	PetroFDS::SetTimeZone();
	
	include_once 'Controller.php';
	
	/** System Files path Where all system information have been saved **/
	$dir = PetroFDS::findThis('app').'Systemfiles';
	
	/** Config File Path **/
	$path_config_file = $dir.'/'.PetroFDS::fileName();
	
	/** Website times File Path **/
	$path_config_file_days = $dir.'/'.PetroFDS::fileName_Days();
	
	/** Email File Path **/
	$path_config_file_emails = $dir.'/'.PetroFDS::fileName_Emails();	
	
	/** Make Directory of System Files if not Exists **/
	if ( ! is_dir($dir)) {
		/** Make Directory **/
		mkdir($dir);
	}
	
	/** Setup New Config Data of Website **/
	PetroFDS::SetWebsiteConfig($path_config_file);
	
	/** Setup New Emails Settings **/
	PetroFDS::SetupEmails($path_config_file_emails);
	
	/** Setup New Website Times **/
	PetroFDS::SetWebsiteTime($path_config_file_days);
	
	/** Delete Old Product From The Cart **/
	PetroFDS::EmptyCart();	
	
	/** Run the Application **/
	PetroFDS::run();
}
?>