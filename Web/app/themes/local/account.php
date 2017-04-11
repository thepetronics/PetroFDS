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

    <title>Account - <?php echo $_SESSION['LOGIN_USER_FULLNAME']; ?></title>



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

				<div class="box_style_2" id="main_menu">

					<h2 class="inner">Welcome <?php echo $_SESSION['LOGIN_USER_FULLNAME'] ?> </h2>

					<table width="100%">

					<tbody>

                    	<tr>

                        	<td>

                            <h4><a id="textlabel" href="orders">View Orders</a></h4>

                            </td>

                            <td>

                            <h4><a id="textlabel" href="editprofile">Edit Profile</a></h4>

                            </td>

                            <td>

                            <h4><a id="textlabel" href="setups/files/logout_all">Logout</a></h4>	

                            </td>

                        </tr>

                    </tbody>

                    </table>

				</div><!-- End box_style_1 -->

			</div><!-- End col-md-6 -->

            <div class="col-md-6">

				<div class="box_style_2" id="main_menu">

					<h2 class="inner">User Details</h2>

					<table width="100%">

					<tbody>

                    	<tr>

                        <?php

						$rows = PetroFDS::getUsers('AND id='.$_SESSION['LOGIN_USER_ID'].'');

						foreach($rows as $row){

						?>

                        	<td>

                            <h4>Address: <?php echo $row['add_1'] ?></h4>

                            </td>

                        	<td>

                            <h4>Loyalty Points: <?php echo $row['loyalty_point'] ?></h4>

                            </td>

                            <td>

                            <h4>Loyalty ID: <?php echo $row['loyalty_id'] ?></h4>

                            </td>

                        <?php

						}

						?>

                        </tr>

                    </tbody>

                    </table>

				</div><!-- End box_style_1 -->

			</div><!-- End col-md-6 -->

		</div><!-- End row -->

        <div class="row">

        	<div class="col-md-12">

				<div class="box_style_2" id="main_menu">

					<h2 class="inner">Last Order Information</h2>

					<table width="100%">

					<tbody>

                        <?php

						$rows = PetroFDS::getOrderdetails('user_id='.$_SESSION['LOGIN_USER_ID'].' ORDER BY id DESC LIMIT 1');

						foreach($rows as $row){

							$rows_order = PetroFDS::getOrders('user_id='.$_SESSION['LOGIN_USER_ID'].' ORDER BY order_detail_id DESC LIMIT 1');

							foreach($rows_order as $row_order){

								$rows_menu = PetroFDS::getMenu('AND id="'.$row_order['product_id'].'"');	

								foreach($rows_menu as $row_menu){

						?>

                        		<tr>

                                    <td>

                                    <h4>Name: <?php echo $row_menu['name']?></h4>

                                    </td>    

                                    <td>

                                    <h4>Description: <?php echo $row_menu['description']?></h4>

                                    </td>

                                    <td>

                                    <h4>Quantity: <?php echo $row_order['quantity']?></h4>

                                    </td>

                                </tr>

                                <tr>

                                	<td>

                                    <h4>Price : <?php echo PetroFDS::get_currency().$row_order['price'] ?></h4>	

                                    </td>

                                    <td>

                                    <h4>About Order: <?php echo $row['about_order'] ?></h4>

                                    </td>

                                    <td>

                                    <?php

									if($row['status'] == '0'){

									?>

                                    	<h4>Order Status: <span style="color:yellow;">Pending</span></h4>

                                    <?php

									}else if($row['status'] == '1'){

									?>

                                    	<h4>Order Status: <span style="color:pink;">Accepted</span></h4>

                                    <?php

									}else if($row['status'] == '2'){

									?>

                                    	<h4>Order Status: <span style="color:green;">Delivered</span></h4>

                                    <?php

									}else if($row['status'] == '3'){

									?>

                                    	<h4>Order Status: <span style="color:red;">Decline</span></h4>

                                    <?php

									}

									?>

                                    </td>

                                </tr>

                        <?php

								}

							}

						}

						?>

                    </tbody>

                    </table>

				</div><!-- End box_style_1 -->

			</div><!-- End col-md-6 -->

        </div><!-- End row2 -->

	</div><!-- End container pin -->

</div><!-- End container -->

<!-- End Content =============================================== -->

<?php include_once 'main_content/footer.php'; ?>

    

    

<!-- COMMON SCRIPTS -->

<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/jquery-1.js"></script>

<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/common_scripts_min.js"></script>

<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/functions.js"></script>

<script src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/menufiles/validate.js"></script>



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