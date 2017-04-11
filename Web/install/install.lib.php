<?php
class PetroFDSInstall{
	public static function CheckStatus(){
		if(file_exists('../app/themes/lib/db.cfg')){
			echo '<label>Application installed please remove install directory.</label>';
		}
	}
	public static function CreateConfig($configfile,$host,$database_name,$username,$password) 
	{
		if(file_exists($configfile)==FALSE)
		{	
			$newconfigfile = fopen($configfile, "w") or die("Unable to open file!");
			$array = array(
				'host' => $host,
				'databasename' => $database_name,
				'username' => $username,
				'password' => $password
			);
			$fulldata = json_encode($array);
			fwrite($newconfigfile, $fulldata);
			fclose($newconfigfile);
		}   
	} 
	public static function InstallApp($pdo,$database_name,$filename,$admin_firstname,$admin_lastname,$admin_username,$admin_password,$website_title,$timezone,$currency){
		$dbname = "`".str_replace("`","``",$database_name)."`";
		$pdo->query("CREATE DATABASE IF NOT EXISTS $dbname");
		$pdo->query("use $dbname");
		// Temporary variable, used to store current query
		$templine = '';
		// Read in entire file
		$lines = file($filename);
		// Loop through each line
		foreach ($lines as $line)
		{
		// Skip it if it's a comment
		if (substr($line, 0, 2) == '--' || $line == '')
			continue;
		
		// Add this line to the current segment
		$templine .= $line;
		// If it has a semicolon at the end, it's the end of the query
		if (substr(trim($line), -1, 1) == ';')
		{
			// Perform the query
			$pdo->query($templine);
			// Reset temp variable to empty
			$templine = '';
		}
		}
		$pdo->query("INSERT INTO admin (firstname, lastname, username, password, role_id, status) VALUES('$admin_firstname','$admin_lastname','$admin_username','".md5($admin_password)."',0,1)");
		$pdo->query("INSERT INTO system_config (website_title, website_path, website_currency, country_region, status) VALUES('$website_title','app/themes/local','$currency','$timezone',1)");
		return true;
	}
}