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

    <title>View Orders - <?php echo $_SESSION['LOGIN_USER_FULLNAME']; ?></title>



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

			<div class="col-md-12">

				<div class="box_style_2" id="main_menu">

					<h2 class="inner">Orders</h2>

                    <table width="100%" class="table table-striped cart-list">

                      <thead>

                          <tr>

                              <td class="name">SHIP TO</td>

                              <td>DATE</td>

                              <td>ORDER ID</td>

			      <td>DECLINE REASON</td>

			      <td>DELIVERY TIME</td>

                              <td>STATUS</td>

                              <td class="model"></td>

                          </tr>

                      </thead>

                      <tbody>

                      <?php

					  $sql='SELECT * FROM order_details WHERE user_id=:user_id ORDER BY id DESC';

					  

					  $stmt_order = $conn->prepare($sql);

							  

					  $stmt_order->execute(array(

							':user_id' => $_SESSION['LOGIN_USER_ID']

					  ));

					  

					  $rows_order = $stmt_order->fetchAll(PDO::FETCH_ASSOC);

					  

					  if($rows_order){

						  foreach($rows_order as $row_order){

							  $sql='SELECT * FROM users WHERE id=:user_id';

					  

							  $stmt_user = $conn->prepare($sql);

									  

							  $stmt_user->execute(array(

							  		':user_id' => $_SESSION['LOGIN_USER_ID']

							  ));

							  

							  $rows_user = $stmt_user->fetchAll(PDO::FETCH_ASSOC);

							  

							  if($rows_user){

								  foreach($rows_user as $row_user){

						  ?>

							  <tr>

								  <td class="name"><strong class="pr_name"><?php echo $row_user['firstname'].' '.$row_user['lastname']; ?></strong></td>

								  <td><?php echo date('d/m/Y',strtotime($row_order['date_created'])); ?></td>

								  <td><?php echo $row_order['id']; ?></td>
                                  
                                  <td><?php echo $row_order['decline_reason']; ?></td>
                                  
                                  <td><?php echo $row_order['order_time']; ?></td>

                                  <?php

								  if($row_order['status'] == '0')

								  {

								  ?>

								  	<td><label style="text-transform:uppercase; color:yellow">Pending</label></td>

                                  <?php

								  }else if($row_order['status'] == '1'){

								  ?>

                                  	<td><label style="text-transform:uppercase; color:pink">Accepted</label></td>

                                  <?php

								  }else if($row_order['status'] == '3'){

								  ?>

                                  	<td><label style="text-transform:uppercase; color:red">Decline</label></td>

                                  <?php

								  }else if($row_order['status'] == '2'){

								  ?>

                                  	<td><label style="text-transform:uppercase; color:green">Delivered</label></td>

                                  <?php

								  }

								  ?>

                                  <td><a target="_blank" href="admin/Orders/print_order?user_id=<?php echo $row_order['user_id'] ?>&order_id=<?php echo $row_order['id'] ?>"><strong class="pr_name" style="color:#000;">View Order</strong></a></td>

							  </tr>

						  <?php

								  }

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

</body>

</html>