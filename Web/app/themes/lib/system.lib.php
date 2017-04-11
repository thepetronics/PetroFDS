<?php

class PetroFDS{

	

	/** 

	 * Return Select Option Data

	 * @var varchar

	**/

	private static $return_option;

	/** 

	 * Return Currency Sign

	 * @var varchar

	**/

	private static $return_currency;

	/** 

	 * Return Get Base Dir

	 * @var varchar

	**/

	private static $get_dir;

	/** 

	 * Return File Name

	 * @var varchar

	**/

	private static $file_name;

	/** 

	 * Return Open Close Website Config

	 * @var varchar

	**/

	private static $file_name_days;
	
	/** 

	 * Return Open Close emails Config

	 * @var varchar

	**/

	private static $file_name_emails;

	/** 

	 * Return Dropdown Start Data

	 * @var varchar

	**/

	private static $start_dropdown;

	/** 

	 * Return System Config Data

	 * @var varchar

	**/

	private static $return_config_data;
	
	/** 

	 * Return Emails Config Data

	 * @var varchar

	**/

	private static $return_emails_data;

	/** 

	 * Return Dropdown Option Data

	 * @var varchar

	**/

	private static $Option_dropdown;

	/** 

	 * Return Dropdown End Data

	 * @var varchar

	**/

	private static $dropdown_end;

	/** 

	 * Return Real Client IP Address

	 * @var varchar

	**/

	private static $ip_address;

	/** 

	 * Return Client Full Details

	 * @var varchar

	**/

	private static $detail_client;

	/** 

	 * Return Client OS

	 * @var varchar

	**/

	private static $return_os;

	/** 

	 * Return TimeZone

	 * @var varchar

	**/

	private static $return_timezone;

	/** 

	 * Return Converted Float

	 * @var Int

	**/

	private static $float;

	/** 

	 * Return Subtract Percentage

	 * @var Int

	**/

	private static $return_price;

	/** 

	 * Return Checkbox

	 * @var Varchar

	**/

	private static $return_checkbox;
	
	/** 
	 * Return Unread Emails Count
	 * @var Int
	**/
	private static $unread_emails;
	/** 
	 * Return Encrypt String
	 * @var Varchar
	**/
	private static $enc_string;
	/** 
	 * Return Decrypt String
	 * @var Varchar
	**/
	private static $dec_string;

	

	/** 

	 * Database function 

	 * for connection

	**/

	public static function ConnectDB(){
		$DBData = json_decode(file_get_contents(PetroFDS::findThis('app').'app/themes/lib/db.cfg'), true);
		
		//database host

		$servername = $DBData['host'];

		//database name

		$database = $DBData['databasename'];

		//database username

		$username = $DBData['username'];

		//database password

		$password = $DBData['password'];

		

		try {

		$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

		$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			return $conn;

		}

		catch(PDOException $e)

		{

			return "Connection failed: " . $e->getMessage();

		}

	}

	/**

	 * Set Timezone for Website

	**/

	public static function SetTimeZone(){

		date_default_timezone_set(PetroFDS::get_system_config('country_region'));		

	}

	/**

	 * Get default timezone

	**/

	public static function GetTimeZone(){

		$timezone = date_default_timezone_get();

		self::$return_timezone = $timezone;

		return self::$return_timezone;		

	}

	/**

	 * Get client ip who access website 

	**/

	public static function get_client_ip_env() {

		$ipaddress = '';

		if (getenv('HTTP_CLIENT_IP'))

			$ipaddress = getenv('HTTP_CLIENT_IP');

		else if(getenv('HTTP_X_FORWARDED_FOR'))

			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');

		else if(getenv('HTTP_X_FORWARDED'))

			$ipaddress = getenv('HTTP_X_FORWARDED');

		else if(getenv('HTTP_FORWARDED_FOR'))

			$ipaddress = getenv('HTTP_FORWARDED_FOR');

		else if(getenv('HTTP_FORWARDED'))

			$ipaddress = getenv('HTTP_FORWARDED');

		else if(getenv('REMOTE_ADDR'))

			$ipaddress = getenv('REMOTE_ADDR');

		else

			$ipaddress = 'UNKNOWN';

	 	

		self::$ip_address = $ipaddress;

		return self::$ip_address;

	}

	/**

	 * Get client operating systems information who 

	 * access website

	**/

	public static function os_info($uagent)

	{

		global $uagent;

		$oses   = array(

			'Win311' => 'Win16',

			'Win95' => '(Windows 95)|(Win95)|(Windows_95)',

			'WinME' => '(Windows 98)|(Win 9x 4.90)|(Windows ME)',

			'Win98' => '(Windows 98)|(Win98)',

			'Win2000' => '(Windows NT 5.0)|(Windows 2000)',

			'WinXP' => '(Windows NT 5.1)|(Windows XP)',

			'WinServer2003' => '(Windows NT 5.2)',

			'WinVista' => '(Windows NT 6.0)',

			'Windows 7' => '(Windows NT 6.1)',

			'Windows 8' => '(Windows NT 6.2)',

			'Windows 8.1' => '(Windows NT 6.3)',

			'Windows 10' => '(Windows NT 10)',

			'WinNT' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)',

			'OpenBSD' => 'OpenBSD',

			'SunOS' => 'SunOS',

			'Ubuntu' => 'Ubuntu',

			'Android' => 'Android',

			'Linux' => '(Linux)|(X11)',

			'iPhone' => 'iPhone',

			'iPad' => 'iPad',

			'MacOS' => '(Mac_PowerPC)|(Macintosh)',

			'QNX' => 'QNX',

			'BeOS' => 'BeOS',

			'OS2' => 'OS\/2',

			'SearchBot' => '(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp)|(MSNBot)|(Ask Jeeves\/Teoma)|(ia_archiver)'

		);

		$uagent = strtolower($uagent ? $uagent : $_SERVER['HTTP_USER_AGENT']);

		foreach ($oses as $os => $pattern)

			if (preg_match('/' . $pattern . '/i', $uagent))

				self::$return_os = $os;

				return self::$return_os;

		return 'Unknown';

	}

	/**

	 * Get Clients all details

	**/

	public static function get_client_details() {

		$ip = PetroFDS::get_client_ip_env();

		$browser = $_SERVER['HTTP_USER_AGENT'];

		$time = date("H:i A dS F");

		

		$arr = array('ip' => $ip,

				'browser' => $browser,

				'OS' => PetroFDS::os_info($browser),

				'time' => $time);

	 	$detail_client = serialize($arr);

		self::$detail_client = $detail_client;

		return self::$detail_client;

	}

	/**

	 * Function to find directory path

	**/

	public static function findThis($get){

		$d = '';

		for($i = 0; $i < 20; $i++){

			if(file_exists($d.$get)){

				self::$get_dir = $d;

				return self::$get_dir;

			}else{

				$d.="../";

			}

		}

	}

	/**

	 * Get System Configuration filename

	**/

	public static function fileName(){

		$name = 'sysconfig';

		self::$file_name = $name;

		return self::$file_name;

	}

	/**

	 * Get Days Configuration filename

	**/

	public static function fileName_Days(){

		$name = 'daysconfig';

		self::$file_name_days = $name;

		return self::$file_name_days;

	}
	
	/**

	 * Get Emails Configuration filename

	**/

	public static function fileName_Emails(){

		$name = 'emails';

		self::$file_name_emails = $name;

		return self::$file_name_emails;

	}

	/**

	 * Function to find data in System Configuration file

	 * as given parameter 

	**/

	public static function get_system_config($name) {

		$array = unserialize(file_get_contents(PetroFDS::findThis('Systemfiles').'Systemfiles/'.PetroFDS::fileName()));

		self::$return_config_data = $array[':'.$name];	

		return self::$return_config_data;

	}

	/**

	 * Function to find data in Days Configuration file

	 * as given parameter

	**/

	public static function get_days_config() {

		$array = json_decode(file_get_contents(PetroFDS::findThis('Systemfiles').'Systemfiles/'.PetroFDS::fileName_Days()), TRUE);

		self::$return_config_data = $array['days_config'];	

		return self::$return_config_data;

	}
	
	/**

	 * Function to find data in Email Configuration file

	 * as given parameter

	**/

	public static function get_email_config($name) {

		$array = unserialize(file_get_contents(PetroFDS::findThis('Systemfiles').'Systemfiles/'.PetroFDS::fileName_Emails()));

		self::$return_emails_data = $array[':'.$name];	

		return self::$return_emails_data;

	}
	
	/**
	 * Function to find Today open or close time in Days Configuration file
	 * as given parameter
	**/
	public static function get_today_times($param) {
		$day = date('l');
		foreach(PetroFDS::get_days_config() as $value){
			if($value['days']==$day){
				return $value[$param];
			}
		}
	}
	/**

	 * Get currency symbol

	**/

	public static function get_currency() {

		$currency_name = PetroFDS::get_system_config('website_currency');

		self::$return_currency = $currency_name;

		return self::$return_currency;

	}

	/**
	 * Get Website Status if it is open or not
	**/
	public static function getWebsiteStatus(){
		$conn = PetroFDS::ConnectDB();
		
		$day = date('l');
		$time = ((int) date('H', time()));
		
		$sql = 'SELECT * FROM `website_open_close` WHERE deleted=0';
		
		$stmt = $conn->prepare($sql);
		
		$stmt->execute();
		
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		if($rows){
			foreach($rows as $value){
				if($value['days']==$day){
					$open_explode = explode(':',$value['website_open']);
					$close_explode = explode(':',$value['website_close']);
					if($time>=$open_explode[0] && $time<$close_explode[0]){
						return 'Success';
					}else{
						return 'Failed';
					}
				}
			}
		}
	}

	/**

	 * Function to run websites if everything is perfect

	**/

	public static function run(){

		PetroFDS::Session(PetroFDS::get_client_details(),PetroFDS::get_client_ip_env());

		header('Location:index');

	}

	/**

	 * Function to get select attribute with elements

	**/

	public static function getSelect($value,$label1,$label2){

		if($value == '1'){

			$return = '

			<option value=""></option>

			<option value="1" selected="selected">'.$label1.'</option>

			<option value="0">'.$label2.'</option>

			';

			

			self::$return_option = $return;

		}else{

			$return = '

			<option value=""></option>

			<option value="1">'.$label1.'</option>

			<option value="0" selected="selected">'.$label2.'</option>

			';

			

			self::$return_option = $return;

		}

		

		return self::$return_option;

	}

	/**

	 * Function to create user session for addtocart

	**/

	public static function Session($txt,$ip){

		$target_path_real = PetroFDS::findThis('Systemfiles').'Systemfiles/sessions/';

		foreach (glob($target_path_real."*") as $file) {

			if (filemtime($file) < time() - 86400) {

				unlink($file);

			}

		}

			

		if ( ! is_dir($target_path_real)) {

				mkdir($target_path_real);

		}

		

		$target_path_full = PetroFDS::findThis('Systemfiles').'Systemfiles/sessions/sess_'.date('mdy-his').'';

		

		$SESSION = fopen($target_path_full, "w") 

		or die("Unable to open file!");

		fwrite($SESSION, $txt);

		fclose($SESSION);

	}

	/**

	 * Function to convert time in 12 hours format with AMPM

	**/

	public static function ftime($time,$f) {

		if (gettype($time)=='string')	

		  $time = strtotime($time);	 

	  

		return ($f==24) ? date("G:i", $time) : date("g:i a", $time);	

  	}

	/**

	 * Function to start or open select tag with given parameters

	**/

	public static function Start_Dropdown($num,$id,$start){

		

		$return = '';

		if($start == 'first'){

			//$return = '<div class="controls"><select class="selectpicker custom_width_options" data-style="btn-info" id="'.$id.'select'.$num.'" required="required" onchange="AjaxSelect(this,\''.$num.'\',\''.$id.'\')">';

			$return = '<div class="controls"><select class="selectpicker custom_width_options" data-style="btn-info" id="'.$id.'select'.$num.'" required="required" onchange="set_price_normal_options(this,\''.PetroFDS::get_currency().'\',\''.$id.'\')">';

		}else if($start == 'middle'){

			$return = '<select class="selectpicker custom_width_options" data-style="btn-info" id="'.$id.'second_select'.$num.'" required="required" onchange="AjaxSelect(this,\''.$num.'\',\''.$id.'\')">';

		}else if($start == 'last'){

			$return = '<select class="selectpicker custom_width_options" data-style="btn-info" required="required">';

		}

		$return .= '<option value="" price="0.00"></option>';

		

		self::$start_dropdown = $return;

		return self::$start_dropdown;

	}

	/**

	 * Function for select options give in parameters

	**/

	public static function Dropdown_Option($option_id,$value,$title,$price){

		if(isset($price) && $price!='0'){

			$price_option = '('.PetroFDS::get_currency().PetroFDS::Float_To_Decimal($price).')';

		}

		$return = '<option price="'.$price.'" value="'.$option_id.'" id="'.$value.'">'.$title.''.$price_option.'</option>';

		

		self::$Option_dropdown = $return;

		echo self::$Option_dropdown;

	}

	/**

	 * Function to end or close select tag

	**/

	public static function End_Dropdown($price,$size){

		$return = '</select></div></div>';

		self::$dropdown_end = $return;

		

		return self::$dropdown_end;

	}

	/**

	 * Function to start or open checkbox tag with given parameters

	**/

	public static function Checkbox($num,$id,$name,$price,$option_id){
		$price_option = '';

		if(isset($price) && $price!='0'){

			$price_option = '('.PetroFDS::get_currency().PetroFDS::Float_To_Decimal($price).')';

		}

		

		$return = '

		<label style="font-size:10px"><input value="0" onclick="setCheckbox(this,\''.$id.'\',\''.$num.'\',\''.$option_id.'\',\''.PetroFDS::get_currency().'\',\''.$price.'\')" type="checkbox">					        '.$name.' '.$price_option.'</label>

		<input type="hidden" value="0" ide="not_added" price="'.$price.'" id="'.$id.'select'.$num.'">

		';

		self::$return_checkbox = $return;

		

		return self::$return_checkbox;

	}

	/**

	 * Function to convert float numbers into decimal numbers with two 

	 * numbers after points  

	**/

	public static function Float_To_Decimal($num){

		$return = number_format((float)$num, 2, '.', '');

		

		self::$float = $return;

		

		return self::$float;

	}

	/**

	 * Function to subtract percentage from price   

	**/

	public static function Get_Discount_Price($price,$amount){

		$return = $price * ((100-$amount) / 100);

		

		self::$return_price = $return;

		

		return self::$return_price;

	}
	
	public static function SetWebsiteConfig($path_config_file){
		$conn = PetroFDS::ConnectDB();
		
		$sql = 'SELECT * FROM `system_config` WHERE status=1';


		$stmt = $conn->prepare($sql);
		
					
		
		$stmt->execute();
		
					
		
		$rows = $stmt->fetchAll();
		
		
		
		if($rows){
			foreach($rows as $row){
		
				$id = $row['id'];
		
				$website_title = $row['website_title'];
		
				$website_path = $row['website_path'];
				
				$website_path_media = str_replace("app","media",$row['website_path']);
		
				$website_currency = $row['website_currency'];
		
				$price_discount = $row['price_discount'];
		
				$store_postcode = $row['store_postcode'];
		
				$country_region = $row['country_region'];
		
				$status = $row['status'];
		
				
		
				$array = array(
		
					':id' => $id,
		
					':website_title' => $website_title,
		
					':website_path' => $website_path,
					
					':website_path_media' => $website_path_media,
		
					':website_currency' => $website_currency,
		
					':price_discount' => $price_discount,
		
					':store_postcode' => $store_postcode,
		
					':country_region' => $country_region,
		
					':status' => $status
		
				);
		
				setcookie('currency', $website_currency, time()+3600);
		
				setcookie('loc', $website_path, time()+3600);
		
			}
		
			file_put_contents($path_config_file, serialize($array));
		}
	}
	
	public static function SetupEmails($path_config_file_emails){
		$conn = PetroFDS::ConnectDB();
		
		$sql_emails = 'SELECT * FROM `emails`';



		$stmt_emails = $conn->prepare($sql_emails);
	
					
	
		$stmt_emails->execute();
	
					
	
		$rows_emails = $stmt_emails->fetchAll();
	
		
	
		if($rows_emails){
			foreach($rows_emails as $row_emails){
				$id = $row_emails['id'];
	
				$admin_email = $row_emails['admin_email'];
	
				$admin_email_pass = $row_emails['admin_email_pass'];
	
				$order_email = $row_emails['order_email'];
				
				$order_email_pass = $row_emails['order_email_pass'];
	
				$info_email = $row_emails['info_email'];
	
				$info_email_pass = $row_emails['info_email_pass'];
				
				$array_emails = array(
	
					':id' => $id,
		
					':admin_email' => $admin_email,
		
					':admin_email_pass' => $admin_email_pass,
		
					':order_email' => $order_email,
		
					':order_email_pass' => $order_email_pass,
		
					':info_email' => $info_email,
		
					':info_email_pass' => $info_email_pass
	
				);
	
			}
		}
		
		file_put_contents($path_config_file_emails, serialize($array_emails));
	}
	
	public static function SetWebsiteTime($path_config_file_days){
		$response["days_config"] = array();
		
		$conn = PetroFDS::ConnectDB();
		
		$sql_1 = 'SELECT * FROM `website_open_close` WHERE deleted=0';


		$stmt_1 = $conn->prepare($sql_1);
	
					
	
		$stmt_1->execute();
	
					
	
		$rows_1 = $stmt_1->fetchAll();
	
		
	
		if($rows_1){
	
			foreach($rows_1 as $row_1){
	
				$id = $row_1['id'];
	
				$system_config_id = $row_1['system_config_id'];
	
				$days = $row_1['days'];
	
				$website_open = $row_1['website_open'];
	
				$website_close = $row_1['website_close'];
	
				$total_hours = $row_1['total_hours'];
	
				$array_days = array(
	
					'id' => $id,
	
					'system_config_id' => $system_config_id,
	
					'days' => $days,
	
					'website_open' => $website_open,
	
					'website_close' => $website_close,
	
					'total_hours' => $total_hours
	
				);
	
				$post = $array_days;
	
				array_push($response['days_config'],$post);
				
				file_put_contents($path_config_file_days, json_encode($response));
			}
		}
	}

	public static function Get_Unread_Email($dmURL,$email,$password){
		$emailAddress = $email;
		$emailPassword = $password;
		$domainURL = $dmURL;
		$useHTTPS = true;
		
		$inbox = imap_open('{'.$domainURL.':143/notls}INBOX',$emailAddress,$emailPassword) or die('Cannot connect to domain:' . imap_last_error());
		
		$oResult = imap_search($inbox, 'UNSEEN');
		
		if(empty($oResult))
			$nMsgCount = 0;
		else
			$nMsgCount = count($oResult);
		
		self::$unread_emails = $nMsgCount;
		return self::$unread_emails;	
		imap_close($inbox);	
	}
	public static function Safe_Encrypt($pure_string, $encryption_key) {
		$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
		self::$enc_string = $encrypted_string;
		return self::$enc_string;
	}
	public static function Safe_Decrypt($encrypted_string, $encryption_key) {
		$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
		self::$dec_string = $decrypted_string;
		return self::$dec_string;
	}
	
	/**

	 * Function of custom query for add,edit or delete from parameter

	**/

	public static function CustomQuery($qry=''){

		$conn = PetroFDS::ConnectDB();

		
		$sql = $qry;


		$stmt = $conn->prepare($sql);
		

		$stmt->execute();

	}
	
	/**

	 * Function to get custom query from parameter

	**/

	public static function getCustomQuery($qry=''){

		$conn = PetroFDS::ConnectDB();

		
		$sql = $qry;


		$stmt = $conn->prepare($sql);
		

		$stmt->execute();

		

		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		

		if($rows){

			return $rows;

		}

	}
	
	/**

	 * Function to get registered Admin Side Users details with where clause in parameter

	**/

	public static function getAdminUsers($where=''){

		$conn = PetroFDS::ConnectDB();

		

		if(isset($where) && $where!=''){

			$sql = 'SELECT * FROM `admin` WHERE status=1 '.$where.'';

		}else{

			$sql = 'SELECT * FROM `admin` WHERE status=1';

		}

		$stmt = $conn->prepare($sql);

		

		$stmt->execute();

		

		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		

		if($rows){

			return $rows;

		}

	}

	/**

	 * Function to get registered Users details with where clause in parameter

	**/

	public static function getUsers($where=''){

		$conn = PetroFDS::ConnectDB();

		

		if(isset($where) && $where!=''){

			$sql = 'SELECT * FROM `users` WHERE status=1 '.$where.'';

		}else{

			$sql = 'SELECT * FROM `users` WHERE status=1';

		}

		$stmt = $conn->prepare($sql);

		

		$stmt->execute();

		

		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		

		if($rows){

			return $rows;

		}

	}

	/**

	 * Function to get all Category from database with where clause in parameter

	**/

	public static function getCategory($where=''){

		$conn = PetroFDS::ConnectDB();

		

		if(isset($where) && $where!=''){

			$sql = 'SELECT * FROM `category` WHERE status=1 '.$where.'';

		}else{

			$sql = 'SELECT * FROM `category` WHERE status=1';

		}

		$stmt = $conn->prepare($sql);

		

		$stmt->execute();

		

		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		

		if($rows){

			return $rows;

		}

	}

	/**

	 * Function to get Menus fro database with where clause in parameter

	**/

	public static function getMenu($where=''){

		$conn = PetroFDS::ConnectDB();

		

		if(isset($where) && $where!=''){

			$sql = 'SELECT * FROM `menus` WHERE status=1 '.$where.'';

		}else{

			$sql = 'SELECT * FROM `menus` WHERE status=1';

		}

		$stmt = $conn->prepare($sql);

		

		$stmt->execute();

		

		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		

		if($rows){

			return $rows;

		}

	}

	/**

	 * Function to get Home Menu list with where clause in parameter

	**/

	public static function getMenuHomeList($where=''){

		$conn = PetroFDS::ConnectDB();

		

		if(isset($where) && $where!=''){

			$sql = 'SELECT * FROM `menus` WHERE status=1 AND price!=0 '.$where.'';

		}else{

			$sql = 'SELECT * FROM `menus` WHERE status=1 AND price!=0';

		}

		

		$stmt = $conn->prepare($sql);

		

		$stmt->execute();

		

		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		

		if($rows){

			return $rows;

		}

	}

	/**

	 * Function to get Featured menu with where clause in parameter

	**/

	public static function getFeaturedMenu($where=''){

		$conn = PetroFDS::ConnectDB();

		

		if(isset($where) && $where!=''){

			$sql = 'SELECT * FROM `menus` WHERE status=1 AND price!=0 AND featured_product=1 '.$where.'';

		}else{

			$sql = 'SELECT * FROM `menus` WHERE status=1 AND price!=0 AND featured_product=1';

		}

		$stmt = $conn->prepare($sql);

		

		$stmt->execute();

		

		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		

		if($rows){

			return $rows;

		}

	}

	/**

	 * Function to get menu custom option with where clause in parameter

	**/

	public static function getMenuCustomOption($where=''){

		$conn = PetroFDS::ConnectDB();

		

		if(isset($where) && $where!=''){

			$sql = 'SELECT * FROM `menu_custom_option` WHERE deleted=0 '.$where.'';

		}else{

			$sql = 'SELECT * FROM `menu_custom_option` WHERE deleted=0';

		}

		$stmt = $conn->prepare($sql);

		

		$stmt->execute();

		

		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		

		if($rows){

			return $rows;

		}

	}

	/**

	 * Function to get orders details with where clause in parameter

	**/

	public static function getOrderdetails($where=''){

		$conn = PetroFDS::ConnectDB();

		

		if(isset($where) && $where!=''){

			$sql = 'SELECT * FROM `order_details` WHERE '.$where.'';

		}else{

			$sql = 'SELECT * FROM `order_details`';

		}

		$stmt = $conn->prepare($sql);

		

		$stmt->execute();

		

		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		

		if($rows){

			return $rows;

		}

	}

	/**

	 * Function to get orders with where clause in parameter

	**/

	public static function getOrders($where=''){

		$conn = PetroFDS::ConnectDB();

		

		if(isset($where) && $where!=''){

			$sql = 'SELECT * FROM `orders` WHERE '.$where.'';

		}else{

			$sql = 'SELECT * FROM `orders`';

		}

		$stmt = $conn->prepare($sql);

		

		$stmt->execute();

		

		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		

		if($rows){

			return $rows;

		}

	}

	/**

	 * Function to get delivery areas and prices with where clause in parameter

	**/


	public static function getDeliveryAreas($where=''){

		$conn = PetroFDS::ConnectDB();

		

		if(isset($where) && $where!=''){

			$sql = 'SELECT * FROM `post_code` WHERE deleted=0 '.$where.'';

		}else{

			$sql = 'SELECT * FROM `post_code` WHERE deleted=0';

		}

		$stmt = $conn->prepare($sql);

		

		$stmt->execute();

		

		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		

		if($rows){

			return $rows;

		}

	}
	public static function EmptySessionCart($ip){
		$conn = PetroFDS::ConnectDB();
		
		$stmt_del = $conn->prepare('DELETE FROM cart WHERE ip=:ip');						

		$stmt_del->execute(array(
	
			':ip' => $ip,		
	
		));
	}
	public static function EmptyCart(){
		$conn = PetroFDS::ConnectDB();
		
		$sql_empty_cart = 'DELETE FROM cart WHERE date_created < (NOW() - INTERVAL 300 MINUTE)';

		$stmt_empty_cart = $conn->prepare($sql_empty_cart);								
		
		$stmt_empty_cart->execute();
	}
	/** Check Cache Directory **/
	public static function StartCache($dir){
		if (!file_exists($dir)) {
    		mkdir($dir);
		}
	}
	/** Create new Cache **/
	public static function CreateCache($name,$content){
		$Cachefile = fopen($name, "w") or die("Unable to open file!");
		fwrite($Cachefile, $content);
		fclose($Cachefile);
	}
	/** Check cache exists or not **/
	public static function CheckCache($name){
		if(file_exists($name)){
			if (time()-filemtime($name) > 2 * 3600) {
				return 'No';
			}else{
				return 'Yes';
			}
		}else{
			return 'No';
		}
	}
	/** Read Cache **/
	public static function ReadCache($name){
		$inc = file_get_contents($name);
		echo $inc;
	}
	public static function SendMobileNotification($reg_id, $message){
		$conn = PetroFDS::ConnectDB();
		
		$sql_mobile = 'SELECT * FROM mobile_setting';

		$stmt_mobile = $conn->prepare($sql_mobile);								
		
		$stmt_mobile->execute();
		
		$rows = $stmt_mobile->fetch();
		
		define("FIREBASE_API_KEY", $rows['api_key']);
		define("FIREBASE_FCM_URL", "https://fcm.googleapis.com/fcm/send");
	
		$fields = array(
		
		'to' => $reg_id ,
		'priority' => "high",
		'notification' => array( "tag"=>"chat", "body" => $message, "sound" => "super_ring.mp3" ),
		);
		
		echo "<br>";
		echo json_encode($fields);
		echo "<br>";
		
		$headers = array(
		'Authorization: key=' . FIREBASE_API_KEY,
		'Content-Type: application/json'
		);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, FIREBASE_FCM_URL);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		
		$result = curl_exec($ch);
		if ($result === FALSE) {
			die('Problem occurred: ' . curl_error($ch));
		}
		
		curl_close($ch);
		//echo $result;
	}
}