<?php
session_start();
include_once 'app/themes/lib/system.lib.php';
$conn = PetroFDS::ConnectDB();
?>
<!DOCTYPE html>
<!--[if IE 9]><html class="ie ie9"> <![endif]-->
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Success</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="">
    
    <!-- GOOGLE WEB FONT -->
    <link href="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/css.css" rel="stylesheet" type="text/css">

    <!-- BASE CSS -->
    <link href="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/base.css" rel="stylesheet">
    
    <!-- Radio and check inputs -->
    <link href="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/grey.css" rel="stylesheet">
    
    <!-- Main Style -->
	<link rel="stylesheet" href="<?php echo PetroFDS::get_system_config('website_path_media') ?>/css_new/style.css">
	
	<!-- Skins -->
	<link rel="stylesheet" href="<?php echo PetroFDS::get_system_config('website_path_media') ?>/css_new/skins/green.css">
	
	<!-- Responsive Style -->
	<link rel="stylesheet" href="<?php echo PetroFDS::get_system_config('website_path_media') ?>/css_new/responsive.css">
    
    <link rel="stylesheet" type="text/css" href="<?php echo PetroFDS::get_system_config('website_path_media') ?>/css1/bootstrap-select.css">

    <!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->

</head>

<body style="overflow: visible;">
<?php include_once 'main_content/header.php'; ?>
<!--[if lte IE 8]>
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a>.</p>
<![endif]-->

<!-- Content ================================================== -->
<div class="container margin_60_35">
	<div id="container_pin">
		<div class="row">
			<div class="col-md-12">
				<div class="box_style_2" id="main_menu">
					<h2 class="inner">Success</h2>
                    <h4 style="color:green;">Your Order has been successfully completed To Check the process of your order please login and view orders. We also email you a copy of receipt</h4>
				</div><!-- End box_style_1 -->
			</div><!-- End col-md-6 -->
		</div><!-- End row -->
	</div><!-- End container pin -->
</div><!-- End container -->
<!-- End Content =============================================== -->
 <?php include_once 'main_content/footer.php'; ?>
    
    
<!-- COMMON SCRIPTS -->
<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/jquery-1.js"></script>
<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/common_scripts_min.js"></script>
<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/functions.js"></script>
<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/validate.js"></script>
<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js_new/custom.js"></script>
<!-- SPECIFIC SCRIPTS -->
<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/cat_nav_mobile.js"></script>
<script>$('#cat_nav').mobileMenu();</script>
<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/custom.js"></script>
<script>
 $(function() {
	 'use strict';
	  $('a[href*=#]:not([href=#])').click(function() {
	    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
	      var target = $(this.hash);
	      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
	      if (target.length) {
	        $('html,body').animate({
	          scrollTop: target.offset().top - 70
	        }, 1000);
	        return false;
	      }
	    }
	  });
	});
</script>
<script type="text/javascript" src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js/bootstrap-select.js"></script>
<script type="text/javascript" src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js/petrojs-1.0.0.min.js"></script>
<script type="text/javascript" src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js/menu.js"></script>
<script type="text/javascript" src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js/save_order.js"></script>
</body></html>