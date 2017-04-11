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

    <title>Edit Profile - <?php echo $_SESSION['LOGIN_USER_FULLNAME'] ?></title>



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

<?php

$rows = PetroFDS::getUsers('AND id='.$_SESSION['LOGIN_USER_ID'].'');



if($rows){

	foreach($rows as $row){

?>

<div class="container margin_60_35">

	<div id="container_pin">

		<div class="row">

            <form action="setups/files/register_edit.php" method="post" enctype="multipart/form-data" id="form" name="form" onSubmit="return validateFormEdit();">

            <div class="col-md-12">

                <div class="page-content">

                    <h2 class="page-content-title"><i class="icon-group"></i>EDIT PROFILE <span style="color:red; font-size:10px;">(If you dont want to change password leave the fields blank.)</span></h2>

                    <div class="form-style form-js">

                    <?php 

					if(isset($_GET['success']) && $_GET['success']=='true'){

					?>

						<label style="color:green;">Your Profile is Updated</label>

					<?php

					}

					?>

                    <label id="valid_user" style="color:red;"></label>

                    <input type="hidden" id="id" name="id" value="<?php echo $row['id'] ?>">

                        <div class="row">

                            <div class="col-md-6">

                                <p>

                                    <input type="text" class="required-item" value="<?php echo $row['firstname'] ?>" name="firstname" id="firstname" aria-required="true" placeholder="Firstname">

                                </p>

                            </div>

                            <div class="col-md-6">

                                <p>

                                    <input type="email" class="required-item" id="email" name="email" value="<?php echo $row['email'] ?>" onkeyup="Checkemail(this.value,<?php echo $row['id'] ?>)" aria-required="true" placeholder="Email">			

                                </p>

                            </div>

                            <div class="col-md-6">

                                <p>

                                    <input type="text" class="required-item" id="lastname" name="lastname" value="<?php echo $row['lastname'] ?>" aria-required="true" placeholder="Lastname">

                                </p>

                            </div>

                            <div class="col-md-6">    

                                <p>

                                    <input type="text" id="contact_no" name="contact_no" class="required-item" aria-required="true" value="<?php echo $row['contact_no'] ?>" placeholder="Contact No">

                                </p>

                            </div>

                            <div class="col-md-6">

                                <p>

                                    <input type="password" class="required-item" value="" name="password" id="password" aria-required="true" placeholder="Password">

                                </p>

                            </div>

                            <div class="col-md-6">

                                <p>

                                    <input type="password" class="required-item" value="" name="password_con" id="password_con" aria-required="true" placeholder="Confirm Password">

                                </p>

                            </div>

                            <div class="col-md-6">

                                <p>

                                    <input type="text" class="required-item" id="add_1" name="add_1" value="<?php echo $row['add_1'] ?>" aria-required="true" placeholder="Address 1">

                                </p>

                            </div>

                            <div class="col-md-6">

                                <p>

                                    <input type="text" class="required-item" id="add_2" name="add_2" value="<?php echo $row['add_2'] ?>" aria-required="true" placeholder="Address 2">

                                </p>

                            </div>

                            <div class="col-md-6">

                                <p>

                                    <input type="text" class="required-item" value="<?php echo $row['city'] ?>" name="city" id="city" aria-required="true" placeholder="City">

                                </p>

                            </div>

                            <div class="col-md-6">

                                <p>

                                    <input type="text" class="required-item" id="post_code" name="post_code" value="<?php echo $row['post_code'] ?>" aria-required="true" placeholder="Post Code">

                                </p>

                            </div>

                            <div class="col-md-12">

                                <input type="hidden" value="edit" name="method" id="method" />

                                <p>

                                	<label><input type="checkbox" id="submit_check" onchange="document.getElementById('btn_sub').disabled = !this.checked;"> I have read and agree to the <a href="#" style="color:red;">Privacy Policy</a>.</label>				

                                <div id="comp_order" class="form-message">

                                	<input name="submit" id="btn_sub" value="Edit" disabled class="submit button small color black" type="submit">&nbsp;

                                </div>

                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            </form>

		</div><!-- End row -->

	</div><!-- End container pin -->

</div><!-- End container -->

</div>

<?php

	}

}

?>

<!-- End Content =============================================== -->

 <?php include_once 'main_content/footer.php'; ?>

    

    

<!-- COMMON SCRIPTS -->

<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/jquery-1.js"></script>

<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/common_scripts_min.js"></script>

<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/functions.js"></script>

<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/validate.js"></script>

<script type="text/javascript" src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js/petrojs-1.0.0.min.js"></script>

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

<script type="text/javascript" src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js/home.js"></script>

</body></html>