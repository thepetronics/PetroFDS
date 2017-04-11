<?php
if(isset($_GET['key']) && $_GET['key']=='index'){
	include_once ''.PetroFDS::get_system_config('website_path').'/index.php';
	exit();
}else if(isset($_GET['key']) && $_GET['key']=='menu'){
	include_once ''.PetroFDS::get_system_config('website_path').'/menu.php';
	exit();
}else if(isset($_GET['key']) && $_GET['key']=='account'){
	include_once ''.PetroFDS::get_system_config('website_path').'/account.php';
	exit();
}else if(isset($_GET['key']) && $_GET['key']=='orders'){
	include_once ''.PetroFDS::get_system_config('website_path').'/view_order.php';
	exit();
}else if(isset($_GET['key']) && $_GET['key']=='cart'){
	include_once ''.PetroFDS::get_system_config('website_path').'/cart.php';
	exit();
}else if(isset($_GET['key']) && $_GET['key']=='checkout'){
	include_once ''.PetroFDS::get_system_config('website_path').'/checkout.php';
	exit();
}else if(isset($_GET['key']) && $_GET['key']=='success'){
	include_once ''.PetroFDS::get_system_config('website_path').'/success.php';
	exit();
}else if(isset($_GET['key']) && $_GET['key']=='login'){
	include_once ''.PetroFDS::get_system_config('website_path').'/login.php';
	exit();
}else if(isset($_GET['key']) && $_GET['key']=='register'){
	include_once ''.PetroFDS::get_system_config('website_path').'/register.php';
	exit();
}else if(isset($_GET['key']) && $_GET['key']=='editprofile'){
	include_once ''.PetroFDS::get_system_config('website_path').'/edit_profile.php';
	exit();
}else if(isset($_GET['key']) && $_GET['key']=='success_register'){
	include_once ''.PetroFDS::get_system_config('website_path').'/success_register.php';
	exit();
}else if(isset($_GET['key']) && $_GET['key']=='about'){
	include_once ''.PetroFDS::get_system_config('website_path').'/about.php';
	exit();
}else if(isset($_GET['key']) && $_GET['key']=='contact'){
	include_once ''.PetroFDS::get_system_config('website_path').'/contact.php';
	exit();
}
