<?php
session_start();

include_once 'app/themes/lib/system.lib.php';

/** Database Connection **/
$conn = PetroFDS::ConnectDB();

/** Set Timezone **/
PetroFDS::SetTimeZone();
?>



<!DOCTYPE html>



<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->



<!--[if IE 9 ]><html class="ie ie9" lang="en"> <![endif]-->



<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->



<head>







	<!-- Basic Page Needs -->



	<meta charset="utf-8">



	<title><?php echo PetroFDS::get_system_config('website_title') ?></title>



	<meta name="description" content="">



	<meta name="author" content="">



	



	<!-- Mobile Specific Metas -->



	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">



	



	<!-- Main Style -->



	<link rel="stylesheet" href="<?php echo PetroFDS::get_system_config('website_path_media') ?>/css_new/style.css">



	



	<!-- Skins -->



	<link rel="stylesheet" href="<?php echo PetroFDS::get_system_config('website_path_media') ?>/css_new/skins/green.css">



	



	<!-- Responsive Style -->



	<link rel="stylesheet" href="<?php echo PetroFDS::get_system_config('website_path_media') ?>/css_new/responsive.css">



  



</head>



<body>







<div class="loader"><div class="loader_html"></div></div>







<div id="wrap" class="grid_1200">



	



	<?php include_once 'main_content/header.php'; ?>

	<div class="slideshow slideshow-2">


		<div class="tp-banner-container">


			<div class="tp-banner">



				<ul>



					<li data-transition="random" data-slotamount="7" data-masterspeed="1500">



						<!-- MAIN IMAGE -->



						<img src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/images/slideshow.png" alt="" data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">



						



						<div class="slideshow-bg"



						data-y="310"



						data-x="center"



						data-start="0"></div>



						<!-- LAYERS -->



						



						<!-- LAYER NR. 1 -->



						<div class="slide-h2 tp-caption randomrotate skewtoleft tp-resizeme start"



							data-y="310"



							data-x="center"



							data-hoffset="0"



							data-start="300"



							data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"



							data-speed="500"



							data-easing="Power3.easeInOut"



							data-endspeed="300"



							style="z-index: 2"><h2>Feeling Hungry !</h2>



						</div>



						



						<!-- LAYER NR. 2 -->



						<div class="slide-h2 tp-caption customin"



							data-y="380"



							data-x="center"



							data-hoffset="0"



							data-start="600"



							data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"



							data-speed="500"



							data-easing="Power3.easeInOut"



							data-endspeed="300"



							style="z-index: 2"><h2>We Offer You Agreat Tasting Experience</h2>



						</div>



						



						<!-- LAYER NR. 4 -->



						<div class="slide-a tp-caption customin"



							data-x="center"



							data-y="500"



							data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"



							data-speed="500"



							data-start="1800"



							data-easing="Power3.easeInOut"



							data-endspeed="500"



							style="z-index: 3"><a href="menu">Order Now</a>



						</div>



					</li>



					<li data-transition="random" data-slotamount="7" data-masterspeed="1000">



						<!-- MAIN IMAGE -->



						<img src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/images/slideshow-2.png" alt="" data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">



						



						<div class="slideshow-bg"



						data-y="310"


						data-x="center"



						data-start="0"></div>



						<!-- LAYERS -->



						



						<!-- LAYER NR. 1 -->



						<div class="slide-h2 tp-caption randomrotate skewtoleft tp-resizeme start"



							data-y="310"



							data-x="center"



							data-hoffset="0"



							data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"



							data-speed="500"



							data-start="500"



							data-easing="Power3.easeInOut"



							data-endspeed="300"



							style="z-index: 2"><h2>Agreat Tasting Experience</h2>



						</div>



		



						<!-- LAYER NR. 2 -->



						<div class="slide-h2 tp-caption customin"



							data-y="380"



							data-x="center"



							data-hoffset="0"



							data-start="600"



							data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"



							data-speed="500"



							data-easing="Power3.easeInOut"



							data-endspeed="300"



							style="z-index: 2"><h2>We Know How To Make Your Life Awesome</h2>



						</div>



		



						<!-- LAYER NR. 4 -->



						<div class="slide-a tp-caption customin"



							data-x="center"



							data-y="500"



							data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"



							data-speed="500"



							data-start="1800"



							data-easing="Power3.easeInOut"



							data-endspeed="500"



							style="z-index: 3"><a href="menu">Order Now</a>



						</div>



					</li>



					<li data-transition="random" data-slotamount="7" data-masterspeed="1000">



						<!-- MAIN IMAGE -->



						<img src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/images/slideshow-3.png" alt="" data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">



						



						<div class="slideshow-bg"



						data-y="310"



						data-x="center"



						data-start="0"></div>



						<!-- LAYERS -->



						



						<!-- LAYER NR. 1 -->



						<div class="slide-h2 tp-caption randomrotate skewtoleft tp-resizeme start"



							data-y="310"



							data-x="center"



							data-hoffset="0"



							data-start="300"



							data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"



							data-speed="500"



							data-easing="Power3.easeInOut"



							data-endspeed="300"



							style="z-index: 2"><h2>Sexy Food</h2>



						</div>



						



						<!-- LAYER NR. 2 -->



						<div class="slide-h2 tp-caption customin"



							data-y="380"



							data-x="center"



							data-hoffset="0"



							data-start="600"



							data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"



							data-speed="500"



							data-easing="Power3.easeInOut"



							data-endspeed="300"



							style="z-index: 2"><h2>Awesome For Restaurant & Food Lovers</h2>



						</div>



						



						<!-- LAYER NR. 4 -->



						<div class="slide-a tp-caption customin"



							data-x="center"



							data-y="500"



							data-hoffset="100"



							data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"



							data-speed="500"



							data-start="1800"



							data-easing="Power3.easeInOut"



							data-endspeed="500"



							style="z-index: 4"><a href="about">Read More</a>



						</div>



		



						<div class="slide-a slide-a-2 tp-caption customin"



							data-x="center"



							data-y="500"



							data-hoffset="-100"



							data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"



							data-speed="500"



							data-start="2100"



							data-easing="Power3.easeInOut"



							data-endspeed="500"



							style="z-index: 4"><a href="menu">Order Now</a>



						</div>



					</li>



					<!-- SLIDE  -->



					<li data-transition="random" data-slotamount="7" data-masterspeed="1000">



						<!-- MAIN IMAGE -->



						<img src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/images/slideshow-4.png" alt="" data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">



						



						<div class="slideshow-bg"



						data-y="310"



						data-x="center"



						data-start="0"></div>



						<!-- LAYERS -->



						



						<!-- LAYER NR. 1 -->



						<div class="slide-h2 tp-caption randomrotate skewtoleft tp-resizeme start"



							data-y="310"



							data-x="center"



							data-hoffset="0"



							data-start="300"



							data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"



							data-speed="500"



							data-easing="Power3.easeInOut"



							data-endspeed="300"



							style="z-index: 2"><h2>Wanna Taste Anew Life !</h2>



						</div>



		



						<!-- LAYER NR. 2 -->



						<div class="slide-h2 tp-caption customin"



							data-y="380"



							data-x="center"



							data-hoffset="0"



							data-start="600"



							data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"



							data-speed="500"



							data-easing="Power3.easeInOut"



							data-endspeed="300"



							style="z-index: 2"><h2>We Offer You Agreat Tasting Experience</h2>



						</div>



		



						<!-- LAYER NR. 4 -->



						<div class="slide-a tp-caption customin"



							data-x="center"



							data-y="500"



							data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"



							data-speed="500"



							data-start="1800"



							data-easing="Power3.easeInOut"



							data-endspeed="500"



							style="z-index: 4"><a href="menu">Order Now</a>



						</div>



					</li>



				</ul>



			</div>



		</div><!-- End tp-banner-container -->



	</div><!-- End slideshow -->



	<div class="slideshow-height"></div>



	



	<div class="section-1">



		<div class="container">



			<div class="row">



				<div class="col-md-12">



					<div class="section-title">



						<div><h3>Our Menu</h3><span></span></div>



						<p>EXCITE YOUR TASTE BUDS<br/>



						RICE • SEAFOOD • PIZZAS • BURGERS &amp; ETC</p>



					</div>



				</div>



                <?php



				foreach((array)PetroFDS::getCategory('LIMIT 8') as $Homelist){



				?>



				<div class="col-md-3 menu-item-3">



					<div class="menu-item">



						<div class="menu-new"><span>New</span></div>



						<div class="menu-img"><img alt="" style="height:130px;" src="<?php echo 'var/cat_images/'.$Homelist['id'].'/'.$Homelist['image']; ?>" onerror="this.src='<?php echo PetroFDS::get_system_config('website_path_media') ?>/images/No_image_available.jpg';"></div>



						<div class="menu-content">



							<div class="menu-icon"><img alt="" src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/images/icon-1.png"></div>



							<h3><a href="menu"><?php echo $Homelist['name'] ?></a></h3>



							<div class="dishes-footer">



                                <a class="dishes-order" style="width:100%" href="menu">Order It Now</a>



                            </div>



						</div>



					</div>



				</div>



                <?php



				}



				?>



				<div class="check-menu"><a href="menu">Check All Menu Categories</a></div>



			</div>



		</div>



	</div><!-- End section-1 -->



	



    <div class="section-2">



		<div class="re_s_3"></div>



		<div class="container">



			<div class="callout">



				<div class="callout-s"></div>



				<div class="callout-inner">



					<h1 style="color:#F00;">Your Title</h1>



					<div class="row">



						<div class="col-md-10">



							<h4><br/>



<br/>



edit home page from app/themes/local/index.<br/>



<br/>



</h4>



						</div>



						<div class="col-md-12">



							<a href="menu" class="callout-a">Order Now</a>



						</div>



					</div>



					<div class="clearfix"></div>



				</div>



				<div class="callout-outer-1"></div>



				<div class="callout-outer-2"></div>



				<div class="clearfix"></div>



			</div>



		</div>



	</div><!-- End section-2 -->



    



	<br>



    <br>



	



	<?php include_once 'main_content/footer.php'; ?>



</div><!-- End wrap -->







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