<?php
include_once 'app/themes/lib/system.lib.php';
?>
<!DOCTYPE html>

<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->

<!--[if IE 9 ]><html class="ie ie9" lang="en"> <![endif]-->

<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->

<head>

<meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="keywords" content="">

    <meta name="description" content="">

    <meta name="author" content="">

    <title>Contact</title>



    <!-- Favicons-->

    <link rel="shortcut icon" href="" type="image/x-icon">

    <link rel="apple-touch-icon" type="image/x-icon" href="">

    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="">

    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="">

    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="">

    

    <!-- Main Style -->

	<link rel="stylesheet" href="<?php echo PetroFDS::get_system_config('website_path_media') ?>/css_new/style.css">

	

	<!-- Skins -->

	<link rel="stylesheet" href="<?php echo PetroFDS::get_system_config('website_path_media') ?>/css_new/skins/green.css">

	

	<!-- Responsive Style -->

	<link rel="stylesheet" href="<?php echo PetroFDS::get_system_config('website_path_media') ?>/css_new/responsive.css">



    <!--[if lt IE 9]>

      <script src="js/html5shiv.min.js"></script>

      <script src="js/respond.min.js"></script>

    <![endif]-->

  

</head>

<body>

<?php include_once 'main_content/header.php'; ?>

<!--[if lte IE 8]>

    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a>.</p>

<![endif]-->

<!-- Content ================================================== -->

	

	<div class="breadcrumbs">

		<div class="container">

			<div class="row">

				<div class="col-md-12">

					<h1>Contact Us</h1>

					<div class="crumbs">

						<a href="#">Home</a>

						<span class="crumbs-span">/</span>

						<span class="current">Contact Us</span>

					</div>

				</div>

			</div><!-- End row -->

		</div>

	</div><!-- End breadcrumbs -->

	

	<div class="section-1">

		<div class="re_s_2"></div>

		<div class="container">

			<div class="row">

				<div class="col-md-12">

					<div class="section-title">

						<div><h3>We Wanna Hear From You :)</h3><span></span></div>

						<h2>Contact Us</h2>

					</div>

					<div class="clearfix"></div>

					

					<div class="contact-map">

						<iframe height="444" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3617.520549995185!2d67.0416212145889!3d24.948398084012545!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb3407dca2de45d%3A0x51937283ae30099e!2sThe+Petronics!5e0!3m2!1sen!2s!4v1491234482441"></iframe>

					</div>

					

					<div class="row">

						<div class="col-md-8">

							<div class="page-content">

								<h2 class="page-content-title"><i class="icon-envelope-alt"></i>Contact Form</h2>

								<p>Please complete the below form and click Send.</p>
								
                                <?php
								if(isset($_GET['Success']) && $_GET['Success']=='true'){
								?>
                                <p style="color:green;">Your request has been Submitted.</p>
                                <?php
								}
								?>
                                
								<form class="form-style" action="EmailServer/sendinfo.php" method="post">

									<div class="row">

										<div class="col-md-6">

											<p>

												<input type="text" class="required-item" value="" name="name" id="name" required aria-required="true" placeholder="Your Name">

											</p>

											<p>

												<input type="text" id="phone" name="phone" value="" placeholder="Phone">

											</p>

										</div>

										<div class="col-md-6">

											<p>

												<input type="email" class="required-item" id="email" name="email" value="" aria-required="true" required placeholder="Email">

											</p>

											<p>

												<input type="text" id="subject" name="subject" class="required-item" aria-required="true" value="" placeholder="Subject">

											</p>

										</div>

										<div class="col-md-12">

											<div class="form-message">

												<textarea id="message" class="required-item" name="message" required aria-required="true" cols="58" rows="7"></textarea>

												<input name="submit" type="submit" value="Send" class="submit button small color">

											</div>

										</div>

									</div>

								</form>

							</div>

						</div>

						<div class="col-md-4">

							<div class="page-content">

								<h2 class="page-content-title"><i class="icon-food"></i>Contact Information</h2>

								<ul class="contact-information">

                                	<li>Address : 5th Floor Park Avenue P.E.C.H.S, Karachi Pakistan</li>

									<li>Phone No : +92-343-2009248</li>

									<li>Email : info@thepetronics.com Or fdsinfo@thepetronics.com</li>

								</ul>

							</div>

							<div class="page-content">

								<h2 class="page-content-title"><i class="icon-share-alt"></i>Follow Us On Social Networks</h2>

								<div class="contact-social">

									<ul>

										<li class=""><a href="#"><i class="icon-facebook"></i></a></li>

										<li class=""><a href="#"><i class="icon-twitter"></i></a></li>

										<li class=""><a href="#"><i class="icon-google-plus"></i></a></li>

										<li class=""><a href="#"><i class="icon-pinterest"></i></a></li>

									</ul>

								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

			

		</div>

	</div><!-- End section-1 -->

<!-- End Content =============================================== -->

<?php include_once 'main_content/footer.php'; ?>



<!-- js -->
<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js_new/jquery.min.js"></script>
<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js_new/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js_new/jquery.easing.1.3.min.js"></script>
<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js_new/html5.js"></script>
<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js_new/twitter/jquery.tweet.js"></script>
<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js_new/jquery.inview.min.js"></script>
<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js_new/jquery.prettyPhoto.js"></script>
<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js_new/jquery.bxslider.min.js"></script>
<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js_new/jquery.themepunch.plugins.min.js"></script>
<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js_new/jquery.themepunch.revolution.min.js"></script>
<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js_new/custom.js"></script>
<!-- End js -->



</body>

</html>