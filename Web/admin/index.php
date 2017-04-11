<?php
	if(!file_exists('../app/themes/lib/db.cfg')){
		die('Please Install the application to start proceeding and please connect to the internet for installation PATH=/install.');
	}
	//Start session
	session_start();
	
	//Unset the variables stored in session
	unset($_SESSION['SESS_USER_ID']);
	unset($_SESSION['SESS_FIRST_NAME']);
	unset($_SESSION['SESS_LAST_NAME']);
	unset($_SESSION['SESS_ID']);
	include_once '../app/themes/lib/system.lib.php';
	/** Set Timezone **/
	PetroFDS::SetTimeZone();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html class="js" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" dir="ltr" lang="en"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="apple-touch-icon" sizes="57x57" href="favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
<link rel="manifest" href="favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<link type="text/css" rel="stylesheet" media="all" href="css/codefilter.css">
<link type="text/css" rel="stylesheet" media="all" href="css/css_362fbe8a5deda61b5d709b7d7037c720.css">
<link type="text/css" rel="stylesheet" media="screen" href="css/css_c44b348a591096b8b5b21a67859a8e46.css">
<link type="text/css" rel="stylesheet" media="print" href="css/css_39e85aee73137490a299fe56338f2db3.css">
<!--[if lte IE 8]><style type='text/css' media='screen'>@import '/profiles/openatrium/themes/ginkgo/ie.css';</style><![endif]-->    
<title>PetroFDS | Admin Login</title>
  </head>
  <body class="not-front not-logged-in page-user no-sidebars og-context og-context-197 i18n-en tao rubik admin-static layout-login .ginkgoProcessed">

  <a id="skipnav" href="#content">Skip navigation</a>  <div id="branding" class="dropdown-blocks toggle-blocks clear-block processed"><div class="clear-block">
      <div class="branding-left position left size-50">
                  <div id="language-switcher"><ul><li class="en first active"><a href="" class="language-link active">Recorded IP:</a></li>
<li class="pt-br"><a href="" class="language-link"><?php echo $_SERVER['REMOTE_ADDR'] ?></a></li>
</ul></div>
      </div>
      <div class="branding-right position left size-50">
                    

<div id="block-atrium-account" class="block block-atrium block-widget block-notitle">
  
  
      <div class="block-content clear-block ">
      <a href="contact_us" class="active">Contact US</a>    </div>
  
  </div>


        
                            

<div id="block-ap_core-register" class="block block-ap_core block-widget block-notitle">
  
  
      <div class="block-content clear-block ">
      <a href="">HELP</a>    </div>
  
  </div>

<div id="block-atrium-account" class="block block-atrium block-widget block-notitle">
  
  
      <div class="block-content clear-block ">
      <a href="" class="active">LATEST NEWS</a>    </div>
  
  </div>

    </div>
  </div></div>

  <div id="global"><div class="limiter clear-block"><div class="clear-block">
      </div>
  </div></div></div>

  
  <div id="page-tools"><div class="limiter clear-block">
    <h1 class="page-title page-title-hidden">User account</h1>    <div class="tabs clear-block"><ul class="links primary-tabs">
<li class="active"><a href="index">Log in</a></li>
</ul></div>              </div></div>


<div id="page"><div class="limiter clear-block">

  <div id="content"><div class="page-region clear-block">
          <div class="page-content content-wrapper clear-block"><form action="login.php" accept-charset="UTF-8" method="post" id="user-login">
<div><div class="form form-layout-simple clear-block">
  <div class="form-item form-item-labeled" id="edit-openid-identifier-wrapper">
      <label for="edit-openid-identifier">Log in using OpenID: </label>
    <input maxlength="255" name="openid_identifier" id="edit-openid-identifier" class="form-text fluid" type="text">      <div class="description"><a href="http://openid.net/">What is OpenID?</a></div>
  </div>
<div class="form-item form-item-labeled" id="edit-name-wrapper">
      <label for="edit-name">User Name: <span class="form-required" title="This field is required.">*</span></label>
      <input type="hidden" id='my_ip' name='my_ip' value='<?php echo $_SERVER['REMOTE_ADDR'] ?>' />
    <input maxlength="60" name="name" id="edit-name" autocomplete="off" onkeypress="key_press(event)" class="form-text required fluid" type="text">      <div class="description">Enter your User Name provided by ThePetronics.</div>
  </div>
<div class="form-item form-item-labeled" id="edit-pass-wrapper">
      <label for="edit-pass">Password: <span class="form-required" title="This field is required.">*</span></label>
    <input name="pass" id="edit-pass" onkeypress="key_press(event)" maxlength="128" class="form-text required fluid" type="password">      <div class="description">Enter the password that accompanies your User Name.</div>
  </div>
<input name="form_build_id" id="form-569eba405297699076d76f89e3e08eec" value="form-569eba405297699076d76f89e3e08eec" type="hidden">
<input name="form_id" id="edit-user-login" value="user_login" type="hidden">
<input name="openid.return_to" id="edit-openid.return-to" value="" type="hidden">
      <div class="buttons"><input name="op" id="edit-submit" value="Log in" class="form-submit" type="button" onClick="form_submit()">
</div>
  </div>
<?php if(isset($_GET['error'])) echo('<div align="center" style="color:#F00">Incorrect Username or Password</div>'); ?>
<?php if(isset($_GET['session'])) echo('<div align="center" style="color:#F00">Session Time Out: Please Re Enter Username and Password</div>'); ?>
<?php if(isset($_GET['sess'])) echo('<div align="center" style="color:#F00">Session Out: Another User Logged in</div>'); ?>

</div></form>
</div>
          </div></div>
  
</div></div>
<script>
function key_press(e)
{
	if(e.keyCode == 13) 
	{ 
		form_submit(); // returning false will prevent the event from bubbling up. 
	} 

}
function form_submit()
{
	if(document.getElementById('edit-name').value=="")
		alert('Please Enter Your Username');
	else if(document.getElementById('edit-pass').value=="")
		alert('Please Enter Your Password');		
	else
		document.forms['user-login'].submit();
}
</script>
    <div id="footer"><div class="limiter clear-block">
    <div class="limiter footer">  

<div id="block-ap_core-disclaimer" class="block block-ap_core block-notitle">
  
  
      <div class="block-content clear-block ">
      <img width="60" height="60" class="disclaimer-logo" title="Logo" alt="Logo" src="images/appicon.png">
      &copy; Copyright 2016-<?php echo date('Y') ?>. All Rights Reserved. ThePetronics. PetroFDS Version 1.0<br> If you have any observations and comments regarding this application please feel free to contact @<b> <?php echo PetroFDS::get_email_config('info_email'); ?> </b> </div>
  
  </div>


</div>    <div class="footer-message">Developed by <a href="http://www.thepetronics.com">ThePetronics</a></div>      </div></div>
  
  
  
  

</body></html>