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
<link rel="shortcut icon" href="sites/all/themes/alfa/favicon.ico" type="image/x-icon">
    <link type="text/css" rel="stylesheet" media="all" href="css/codefilter.css">
<link type="text/css" rel="stylesheet" media="all" href="css/css_362fbe8a5deda61b5d709b7d7037c720.css">
<link type="text/css" rel="stylesheet" media="screen" href="css/css_c44b348a591096b8b5b21a67859a8e46.css">
<link type="text/css" rel="stylesheet" media="print" href="css/css_39e85aee73137490a299fe56338f2db3.css">
    <script type="text/javascript" src="js/js_2340d918bf99489dc1d0ca3d01267d39.js"></script>
  <title>PetroFDS | Contact Us</title>
  </head>
  <body class="not-front not-logged-in page-user one-sidebar sidebar-right og-context og-context-197 i18n-en tao rubik admin-static page .ginkgoProcessed">

  <div id="branding" class="dropdown-blocks toggle-blocks clear-block processed"><div class="clear-block">
      <div class="branding-left position left size-50">
                  <div id="language-switcher"><ul><li class="en first active"><a href="" class="language-link active">Recorded IP:</a></li>
<li class="pt-br"><a href="" class="language-link"><?php echo $_SERVER['REMOTE_ADDR'] ?></a></li>
</ul></div>
      </div>
      <div class="branding-right position left size-50">
                    

<div id="block-atrium-account" class="block block-atrium block-widget block-notitle">
  
      <div class="block-content clear-block ">
      <a href="contact_us.php" class="active">Contact US</a>    </div>
  
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
<li><a href="index">Log in</a></li>
</ul></div>              </div></div>
  
<div id="page"><div class="limiter clear-block" >
<br />  
<div class="form-item form-item-labeled" id="edit-name-wrapper">
<table width="100%" border="0">
	<tr>
    	<td>      <label style="font-size:18px">The Peronics</label></td>
    	<td>&nbsp;</td>
    </tr>
    <tr>
    	<td> 
	Website: <a target="_blank" href="http://www.thepetronics.com">The Petronics</a> <br /> Address: 5th Floor Park Avenue
P.E.C.H.S, Karachi Pakistan. <br /> Ph: +92-343-2009248 <br /> E-Mail: <a href='mailto:info@thepetronics.com'>fdsinfo@thepetronics.com </a>
        
        </td>
    </tr>
</table>
  </div>
</div></div>

    <div id="footer"><div class="limiter clear-block">
    <div class="limiter footer">  

<div id="block-ap_core-disclaimer" class="block block-ap_core block-notitle">
  
  
      <div class="block-content clear-block ">
      <img width="60" height="60" class="disclaimer-logo" title="Logo" alt="Logo" src="images/appicon.png">
      &copy; Copyright 2016-<?php echo date('Y') ?>. All Rights Reserved. ThePetronics. PetroFDS Version 1.0<br> If you have any observations and comments regarding this application please feel free to contact @<b> <?php echo PetroFDS::get_email_config('info_email'); ?> </b> </div>
  
  </div>


</div>    <div class="footer-message">Developed by <a href="http://www.thepetronics.com">ThePetronics</a></div>      </div></div>
  

  
  

</body></html>