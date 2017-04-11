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

    <title>Login</title>



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

        	<div class="col-md-6">

                <div class="page-content">

                    <h2 class="page-content-title"><i class="icon-arrow-right"></i>NEW CUSTOMER</h2>

                      <p>

                      	  <h4>Register Account</h4>

                          <label>By creating an account you will be able to shop faster, be up to date on an order's status, and keep track of the orders you have previously made.</label>

                      </p>

                      <p>

                          <a href="register"><input type="submit" id="register" name="register" class="submit button small color" value="Continue"></a>

                      </p>

                </div>

            </div>

            <form action="setups/files/login_all.php" method="post" enctype="multipart/form-data" id="form_login" name="form_login" onSubmit="return validateLogin();">

            <div class="col-md-6">

                <div class="page-content">

                    <h2 class="page-content-title"><i class="icon-arrow-right"></i>LOGIN</h2>

                    <?php

					if($_GET['login']=='error'){

					?>

                    	<label style="color:red;">Email or Password is invalid</label>

                    <?php

					}

					?>

                      <p>

                          <input type="text" class="required-item" value="" name="email" id="email" aria-required="true" placeholder="Email">

                      </p>

                      <p>

                          <input type="password" class="required-item" id="password" name="password" value="" aria-required="true" placeholder="Password">

                      </p>

                      <p>

                          <input type="submit" id="login" name="login" class="submit button small color" value="Login">

                      </p>
			<p>

                          <a href="javascript:void(0)" onClick="ForgotModal()">FORGOT PASSWORD?</a>
                          
                          <div class="modal fade" id="forgot_password" role="dialog">
        
                          <div class="modal-dialog">

                          

                            <!-- Modal content-->

                            <div class="modal-content">

                              <div class="modal-header">

                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                                <h4 class="modal-title" style="color:#000">Enter Email Address</h4>

                              </div>

                              <div class="modal-body" style="color:#000">

                                <input type="email" name="forgot_email" id="forgot_email" class="form-text required fluid" >

                              </div>

                              <div class="modal-footer">

                                <button type="button" class="btn btn-success" onClick="resetpass(document.getElementById('forgot_email').value)">Done</button>


                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                              </div>

                            </div>

                            

                          </div>

                          </div>

                      </p>

                </div>

            </div>

            </form>

		</div><!-- End row1 -->

	</div><!-- End container pin -->

</div><!-- End container -->

</div>

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

<script type="text/javascript" src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js/petrojs-1.0.0.min.js"></script>

<script type="text/javascript" src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js/home.js"></script>

</body></html>