<?php

session_start();

include_once 'app/themes/lib/system.lib.php';

/** Database Connection **/
$conn = PetroFDS::ConnectDB();

/** Set Timezone **/
PetroFDS::SetTimeZone();
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

    <title>Menu</title>



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

    

    <!-- New Font Style -->

	<link rel="stylesheet" href="<?php echo PetroFDS::get_system_config('website_path_media') ?>/css_new/myfont/font.css">

    

    <link rel="stylesheet" type="text/css" href="<?php echo PetroFDS::get_system_config('website_path_media') ?>/css1/bootstrap-select.css">

	
    <!-- Offline Style -->

	<link rel="stylesheet" href="<?php echo PetroFDS::get_system_config('website_path_media') ?>/css_new/offline.css">
    <link rel="stylesheet" href="<?php echo PetroFDS::get_system_config('website_path_media') ?>/css_new/offline-language.css">

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
    <?php
	if(PetroFDS::getWebsiteStatus() != 'Success'){
	?>
        <div class = "alert alert-danger">Your are about to order on closed time.</div>
    <?php
	}
	?>
		<div class="row">
			<div class="col-md-3">
                <div id="nav_mob_display" class="navigation-1 navigation_mobile navigation_mobile_main" style="margin:0px auto 0; display: none;">
                <div id="cat_mob_display_name" class="navigation_mobile_click" style="height:50px; line-height:50px;">Categories...</div>
                <ul id="cat_mob_display" style="display: none; height:350px; overflow-y:auto;">
                
                	<?php
					if(is_array(PetroFDS::getCategory())){
					foreach(PetroFDS::getCategory() as $Category_Mob){

					?>
                
                    <li><a onClick="CategoryNav(this)" href="#cat_<?php echo $Category_Mob['id'] ?>"><?php echo $Category_Mob['name'] ?></a></li>
                    
                    <?php

					}
					}else{
					?>
                    <li><a href="#">Please enter some categories</a></li>
                    <?php
					}
					?>
                
                </ul>
                
                </div>

                <div class="box_style_1" id="cat-overflow" style="max-height: 100%;">

					<ul id="cat_nav">

                    	<?php
						if(is_array(PetroFDS::getCategory())){
						foreach(PetroFDS::getCategory() as $Category){

						?>

							<li><a href="#cat_<?php echo $Category['id'] ?>"><?php echo $Category['name'] ?><i class="icon-angle-right pull-right"></i></a></li>

						<?php

						}
						}else{
						?>
                        	<li><a href="#">Please enter some categories</a></li>
                        <?php
						}
						?>

					</ul>

				</div><!-- End box_style_1 -->

			</div><!-- End col-md-3 -->
            <div class="col-md-2">

                <a class="btn_full" id="button-red" data-toggle="modal" data-target="#myWorkinghours">Delivery Areas</a>

                <div id="myWorkinghours" class="modal fade" role="dialog">

                  <div class="modal-dialog">

                    <div class="modal-content" id="body_workinghours">

                      <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                        <h4 class="modal-title" style="color:#F00">Delivery Areas</h4>

                      </div>

                      <div class="modal-body selectwidthauto" style="overflow: visible;">

							<table border="1" width="100%" style="text-align:center;" cellpadding="10">

                            <tr>

                            <td><h4>Price</h4></td>

                            <td><h4>PostCode</h4></td>

                            </tr>

                            <?php

                            foreach((array)PetroFDS::getDeliveryAreas() as $value){

                                echo '<tr><td>

                                '.PetroFDS::get_currency().$value['price'].'

                                </td><td>

                                '.$value['postcode'].'

                                </td></tr>';

                            }

                            ?>

                            </tr>

                            </table>

                      </div>

                      <div class="modal-footer">

                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                      </div>

                    </div>

                  </div>

                </div>

            </div>

            <div class="col-md-2">

                <a class="btn_full" id="button-red" data-toggle="modal" data-target="#mypaymentmethod">Payment Method</a>

                <div id="mypaymentmethod" class="modal fade" role="dialog">

                  <div class="modal-dialog">

                    <div class="modal-content" id="body_paymentmethod">

                      <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                        <h4 class="modal-title" style="color:#F00">Payment Method</h4>

                      </div>

                      <div class="modal-body selectwidthauto" style="overflow: visible;">

                            <h4>Cash On Delivery</h4>

                      </div>

                      <div class="modal-footer">

                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                      </div>

                    </div>

                  </div>

                </div>

            </div>

            <div class="col-md-2">

                <a class="btn_full" id="button-red" data-toggle="modal" data-target="#myworkinghours">Working Hours</a>

                <div id="myworkinghours" class="modal fade" role="dialog">

                  <div class="modal-dialog">

                    <div class="modal-content" id="body_workinghours">

                      <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                        <h4 class="modal-title" style="color:#F00">Working Hours</h4>

                      </div>

                      <div class="modal-body selectwidthauto" style="overflow: visible;">

                            <table border="1" width="100%" style="text-align:center;" cellpadding="10">

                            <tr><td><h4>Days</h4></td>

                            <td><h4>Open Time</h4></td>

                            <td><h4>Close Time </h4></td></tr>

                            <?php

                            foreach(PetroFDS::get_days_config() as $value){

                                echo '<tr><td>

                                '.$value['days'].'

                                </td><td>

                                '.PetroFDS::ftime($value['website_open'],12).'

                                </td><td>

                                '.PetroFDS::ftime($value['website_close'],12).'

                                </td></tr>';

                            }

                            ?>

                            </tr>

                            </table>

                      </div>

                      <div class="modal-footer">

                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                      </div>

                    </div>

                  </div>

                </div>

             </div>

			<div class="col-md-6">

				<div class="box_style_2" id="main_menu">

					<h2 class="inner">Menu</h2>

                    <?php

					$count = 1;
					if(is_array(PetroFDS::getCategory())){
					foreach(PetroFDS::getCategory() as $Category_1){

					?>

					<h3 class="nomargin_top" id="cat_<?php echo $Category_1['id'] ?>"><?php echo $Category_1['name'] ?></h3>
					<img src="<?php echo 'var/cat_images/'.$Category_1['id'].'/'.$Category_1['image']; ?>" onerror="this.src='<?php echo PetroFDS::get_system_config('website_path_media') ?>/images/notavailable.png';"  />
					<table class="table table-striped cart-list">

					<thead>

					<tr>

						<th>

							 Item

						</th>

						<th>

							 Price

						</th>

						<th>

							 Order

						</th>

					</tr>

					</thead>

					<tbody>

                    <?php

					$count = 1;

					foreach((array) PetroFDS::getMenu('AND category_id='.$Category_1['id'].'') as $Menu){

					?>

					<tr>

						<td>

							<h5><?php echo $count.'. '.$Menu['name']; ?></h5>

							<p style="width:250px;">

								<?php echo $Menu['description']; ?>

							</p>

						</td>

                        <?php
						
						$rows_custom = PetroFDS::getMenuCustomOption('AND menu_id='.$Menu['id'].'');

						

						if($rows_custom){

						?>

                        <td>

                        </td>

                        <td>

                        </td>

                        <?php

							foreach($rows_custom as $row_custom){

						?>

                        <tr>

						<td>

                        	<label><?php echo htmlentities($row_custom['title']) ?></label>

						</td>

                        <td>

                        	<?php

							if(isset($row_custom['price']) && $row_custom['price']!=''){

							?>

								<strong><?php echo PetroFDS::get_currency().' '.PetroFDS::Float_To_Decimal($row_custom['price']); ?></strong>

                            <?php

							}else{

							?>

                            	<strong><?php echo PetroFDS::get_currency().' '.PetroFDS::Float_To_Decimal($Menu['price']); ?></strong>

                            <?php

							}

							?>

                        </td>

						<td class="options">

                        	<?php

                            if(isset($Menu['options_with_type']) && $Menu['options_with_type']!=''){

								if(isset($_SESSION['POST_CODE']) && $_SESSION['POST_CODE']!=''){

                            ?>

								<?php

								if(isset($row_custom['price']) && $row_custom['price']!=''){

								?>

                                <a href="javascript:void(0)" data-toggle="modal" onclick="showDialog('<?php echo $Menu['id'] ?>','<?php echo htmlentities($row_custom['id']) ?>','<?php echo $row_custom['price'] ?>');" data-target="#myModal<?php echo $Menu['id'] ?>"><i class="icon-plus-sign-alt" id="icon-add"></i></a>

                                <?php

								}else{

								?>

                                <a href="javascript:void(0)" data-toggle="modal" onclick="showDialog('<?php echo $Menu['id'] ?>','<?php echo htmlentities($row_custom['id']) ?>',null);" data-target="#myModal<?php echo $Menu['id'] ?>"><i class="icon-plus-sign-alt" id="icon-add"></i></a>

                                <?php

								}

								?>

                                <div id="myModal<?php echo $Menu['id'] ?>" class="modal fade" role="dialog">

                                  <div class="modal-dialog">

                                    <div class="modal-content" id="body<?php echo $Menu['id'] ?>">

                                      

                                    </div>

                                  </div>

                                </div>

                            <?php

								}else{

							?>

                            	<a href="javascript:void(0)" data-toggle="modal" data-target="#myPostCodeModal<?php echo $Menu['id'] ?>"><i class="icon-plus-sign-alt" id="icon-add"></i></a>

                            	<div id="myPostCodeModal<?php echo $Menu['id'] ?>" class="modal fade" role="dialog">

                                  <div class="modal-dialog">

                                    <div class="modal-content" id="body_postcode<?php echo $Menu['id'] ?>">

                                      <div class="modal-header">

                                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                                        <h4 class="modal-title">Please Enter PostCode to Continue </h4>

                                      </div>

                                      <div class="modal-body selectwidthauto" style="overflow: visible;">

                                      	<input type="text" style="border:2px solid #F00" name="postcode_menu" id="postcode_menu<?php echo $Menu['id'] ?>">

                                      </div>

                                      <div class="modal-footer">

                                      <button type="button" class="btn btn-success" data-dismiss="modal" onClick="Postcode('<?php echo $Menu['id'] ?>')">Done</button>

                                      </div>

                                    </div>

                                  </div>

                                </div>

                            <?php

								}

							}else if(isset($row_custom['option_with_type']) && $row_custom['option_with_type']!=''){

								if(isset($_SESSION['POST_CODE']) && $_SESSION['POST_CODE']!=''){

							?>

                            	<?php

								if(isset($row_custom['price']) && $row_custom['price']!=''){

								?>

                                <a href="javascript:void(0)" data-toggle="modal" onclick="showDialog('<?php echo $Menu['id'] ?>','<?php echo htmlentities($row_custom['id']) ?>','<?php echo $row_custom['price'] ?>');" data-target="#myModal<?php echo $Menu['id'] ?>"><i class="icon-plus-sign-alt" id="icon-add"></i></a>

                                <?php

								}else{

								?>

                                <a href="javascript:void(0)" data-toggle="modal" onclick="showDialog('<?php echo $Menu['id'] ?>','<?php echo htmlentities($row_custom['id']) ?>',null);" data-target="#myModal<?php echo $Menu['id'] ?>"><i class="icon-plus-sign-alt" id="icon-add"></i></a>

                                <?php

								}


								?>

                            <div id="myModal<?php echo $Menu['id'] ?>" class="modal fade" role="dialog">

                              <div class="modal-dialog">

                                <div class="modal-content" id="body<?php echo $Menu['id'] ?>">

                                  

                                </div>

                              </div>

                            </div>

                            <?php

								}else{

							?>

                            	<a href="javascript:void(0)" data-toggle="modal" data-target="#myPostCodeModal<?php echo $Menu['id'] ?>"><i class="icon-plus-sign-alt" id="icon-add"></i></a>

                            	<div id="myPostCodeModal<?php echo $Menu['id'] ?>" class="modal fade" role="dialog">

                                  <div class="modal-dialog">

                                    <div class="modal-content" id="body_postcode<?php echo $Menu['id'] ?>">

                                      <div class="modal-header">

                                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                                        <h4 class="modal-title">Please Enter PostCode to Continue </h4>

                                      </div>

                                      <div class="modal-body selectwidthauto" style="overflow: visible;">

                                      	<input type="text" style="border:2px solid #F00" name="postcode_menu" id="postcode_menu<?php echo $Menu['id'] ?>">

                                      </div>

                                      <div class="modal-footer">

                                      <button type="button" class="btn btn-success" data-dismiss="modal" onClick="Postcode('<?php echo $Menu['id'] ?>')">Done</button>

                                      </div>

                                    </div>

                                  </div>

                                </div>

                            <?php

								}

							}else{

								if(isset($_SESSION['POST_CODE']) && $_SESSION['POST_CODE']!=''){

								$stmt_type_no = $conn->prepare("SELECT * FROM menu_option_type_no WHERE menu_id='".$Menu['id']."' AND deleted=0");



								$stmt_type_no->execute();

								

								$rows_type_no = $stmt_type_no->fetchAll(PDO::FETCH_ASSOC);

								

								if($rows_type_no){

							?>

                            	<?php

								if(isset($row_custom['price']) && $row_custom['price']!=''){

								?>

                                <a href="javascript:void(0)" data-toggle="modal" onclick="showDialog('<?php echo $Menu['id'] ?>','<?php echo htmlentities($row_custom['id']) ?>','<?php echo $row_custom['price'] ?>');" data-target="#myModal<?php echo $Menu['id'] ?>"><i class="icon-plus-sign-alt" id="icon-add"></i></a>

                                <?php

								}else{

								?>

                                <a href="javascript:void(0)" data-toggle="modal" onclick="showDialog('<?php echo $Menu['id'] ?>','<?php echo htmlentities($row_custom['id']) ?>',null);" data-target="#myModal<?php echo $Menu['id'] ?>"><i class="icon-plus-sign-alt" id="icon-add"></i></a>

                                <?php

								}

								?>

                            	<div id="myModal<?php echo $Menu['id'] ?>" class="modal fade" role="dialog">

                                  <div class="modal-dialog">

                                    <div class="modal-content" id="body<?php echo $Menu['id'] ?>">

                                      

                                    </div>

                                  </div>

                                </div>

                            <?php

								}else{

									if(PetroFDS::getWebsiteStatus() == 'Success'){

										if(isset($row_custom['price']) && $row_custom['price']!=''){

										?>

												<a href="javascript:void(0)" onClick="addtocart('add','<?php echo $Menu['id'] ?>','<?php echo $row_custom['id'] ?>','<?php echo $row_custom['price'] ?>')"><i class="icon-plus-sign-alt" id="icon-add"></i></a>	

										<?php

												}else{

										?>

												<a href="javascript:void(0)" data-toggle="modal" onClick="addtocart('add','<?php echo $Menu['id'] ?>','<?php echo $row_custom['id'] ?>')" data-target="#myModal<?php echo $Menu['id'] ?>"><i class="icon-plus-sign-alt" id="icon-add"></i></a>

										<?php

										}

									}else{

										?>

                                        <a onClick="showDialog('<?php echo $Menu['id'] ?>')" data-toggle="modal" data-target="#ErrorModal<?php echo $Menu['id'] ?>" href="javascript:void(0)" id="15"><i class="icon-plus-sign-alt" id="icon-add"></i></a>

                                            <div id="ErrorModal<?php echo $Menu['id'] ?>" class="modal fade" role="dialog">

                                              <div class="modal-dialog">

                                                <div class="modal-content" id="body<?php echo $Menu['id'] ?>">

                                                  

                                                </div>

                                              </div>

                                            </div>

                                        <?php

									}

								}

								}else{

							?>

                            	<a href="javascript:void(0)" data-toggle="modal" data-target="#myPostCodeModal<?php echo $Menu['id'] ?>"><i class="icon-plus-sign-alt" id="icon-add"></i></a>

                            	<div id="myPostCodeModal<?php echo $Menu['id'] ?>" class="modal fade" role="dialog">

                                  <div class="modal-dialog">

                                    <div class="modal-content" id="body_postcode<?php echo $Menu['id'] ?>">

                                      <div class="modal-header">

                                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                                        <h4 class="modal-title">Please Enter PostCode to Continue </h4>

                                      </div>

                                      <div class="modal-body selectwidthauto" style="overflow: visible;">

                                      	<input type="text" style="border:2px solid #F00" name="postcode_menu" id="postcode_menu<?php echo $Menu['id'] ?>">

                                      </div>

                                      <div class="modal-footer">

                                      <button type="button" class="btn btn-success" data-dismiss="modal" onClick="Postcode('<?php echo $Menu['id'] ?>')">Done</button>

                                      </div>

                                    </div>

                                  </div>

                                </div>

                            <?php

								}

							}

							?>

						</td>

                        </tr>

                        <?php

							}

						}else{

						?>

                        <td>

                            <strong><?php echo PetroFDS::get_currency().' '.PetroFDS::Float_To_Decimal($Menu['price']); ?></strong>

						</td>

                        <td class="options">

                        <?php

							if(isset($Menu['options_with_type']) && $Menu['options_with_type']!=''){

								if(isset($_SESSION['POST_CODE']) && $_SESSION['POST_CODE']!=''){

							?>

                            <a href="javascript:void(0)" data-toggle="modal" onclick="showDialog('<?php echo $Menu['id'] ?>');" data-target="#myModal<?php echo $Menu['id'] ?>"><i class="icon-plus-sign-alt" id="icon-add"></i></a>

                            

                            <div id="myModal<?php echo $Menu['id'] ?>" class="modal fade" role="dialog">

                              <div class="modal-dialog">

                                <div class="modal-content" id="body<?php echo $Menu['id'] ?>">

                                  

                                </div>

                              </div>

                            </div>

                            <?php

								}else{

							?>

                            	<a href="javascript:void(0)" data-toggle="modal" data-target="#myPostCodeModal<?php echo $Menu['id'] ?>"><i class="icon-plus-sign-alt" id="icon-add"></i></a>

                            	<div id="myPostCodeModal<?php echo $Menu['id'] ?>" class="modal fade" role="dialog">

                                  <div class="modal-dialog">

                                    <div class="modal-content" id="body_postcode<?php echo $Menu['id'] ?>">

                                      <div class="modal-header">

                                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                                        <h4 class="modal-title">Please Enter PostCode to Continue </h4>

                                      </div>

                                      <div class="modal-body selectwidthauto" style="overflow: visible;">

                                      	<input type="text" style="border:2px solid #F00" name="postcode_menu" id="postcode_menu<?php echo $Menu['id'] ?>">

                                      </div>

                                      <div class="modal-footer">

                                      <button type="button" class="btn btn-success" data-dismiss="modal" onClick="Postcode('<?php echo $Menu['id'] ?>')">Done</button>

                                      </div>

                                    </div>

                                  </div>

                                </div>

                            <?php

								}

							}else{

								if(isset($_SESSION['POST_CODE']) && $_SESSION['POST_CODE']!=''){

								if(PetroFDS::getWebsiteStatus() == 'Success'){

								$stmt_type_no_1 = $conn->prepare("SELECT * FROM menu_option_type_no WHERE menu_id='".$Menu['id']."' AND deleted=0");



								$stmt_type_no_1->execute();

								

								$rows_type_no_1 = $stmt_type_no_1->fetchAll(PDO::FETCH_ASSOC);

								

								if($rows_type_no_1){

							?>
								<a href="javascript:void(0)" data-toggle="modal" onclick="showDialog('<?php echo $Menu['id'] ?>');" data-target="#myModal<?php echo $Menu['id'] ?>"><i class="icon-plus-sign-alt" id="icon-add"></i></a>
                            	<div id="myModal<?php echo $Menu['id'] ?>" class="modal fade" role="dialog">

                                  <div class="modal-dialog">

                                    <div class="modal-content" id="body<?php echo $Menu['id'] ?>">

                                      

                                    </div>

                                  </div>

                                </div>

                            <?php

								}else{

							?>

                   			<a href="javascript:void(0)" onClick="addtocart('add','<?php echo $Menu['id'] ?>',null,'<?php echo $Menu['price'] ?>')"><i class="icon-plus-sign-alt" id="icon-add"></i></a>         

                            <?php

								}

								}else{

							?>

                            	<a onClick="showDialog('<?php echo $Menu['id'] ?>')" data-toggle="modal" data-target="#ErrorModal<?php echo $Menu['id'] ?>" href="javascript:void(0)" id="15"><i class="icon-plus-sign-alt" id="icon-add"></i></a>

                                <div id="ErrorModal<?php echo $Menu['id'] ?>" class="modal fade" role="dialog">

                                  <div class="modal-dialog">

                                    <div class="modal-content" id="body<?php echo $Menu['id'] ?>">

                                      

                                    </div>

                                  </div>

                                </div>

                            <?php

								}

								}else{

							?>

                            	<a href="javascript:void(0)" data-toggle="modal" data-target="#myPostCodeModal<?php echo $Menu['id'] ?>"><i class="icon-plus-sign-alt" id="icon-add"></i></a>

                            	<div id="myPostCodeModal<?php echo $Menu['id'] ?>" class="modal fade" role="dialog">

                                  <div class="modal-dialog">

                                    <div class="modal-content" id="body_postcode<?php echo $Menu['id'] ?>">

                                      <div class="modal-header">

                                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                                        <h4 class="modal-title">Please Enter PostCode to Continue </h4>

                                      </div>

                                      <div class="modal-body selectwidthauto" style="overflow: visible;">

                                      	<input type="text" style="border:2px solid #F00;" name="postcode_menu" id="postcode_menu<?php echo $Menu['id'] ?>">

                                      </div>

                                      <div class="modal-footer">

                                      <button type="button" class="btn btn-success" data-dismiss="modal" onClick="Postcode('<?php echo $Menu['id'] ?>')">Done</button>

                                      </div>

                                    </div>

                                  </div>

                                </div>

                            <?php

								}

							}

						?>

						</td>

                        <?php

						}

						?>

					</tr>

                    <?php

					$count++;

					}

					?>

					</tbody>

					</table>

                    <?php

					}
					}else{
					?>
                    <label>Please enter some from admin panel to continue</label>
                    <?php
					}
					?>

				</div><!-- End box_style_1 -->

			</div><!-- End col-md-6 -->

            

			<div class="col-md-3">

				<div style="height: 665px;" class="pin-wrapper"><div style="width: 260px;" id="cart_box">

					<h3><strong>Your order</strong> <i class="icon-delivery pull-right font-icon" style="margin-top:-28px;"></i></h3>

                    <div id="side_cart_open">

					<img src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/images/load.gif" style="margin-left:95px; margin-top:20px;" />

                    </div>

                    <?php

					if(PetroFDS::getWebsiteStatus() == 'Success'){

					?>

                    <cite style="font-size:10px; color:grey; margin-left:8px;">Delivery will end at <?php echo PetroFDS::ftime(PetroFDS::get_today_times('website_close'),12);?> that would be in</cite>

                    <strong id="countdown" class="Timer"></strong>

					<?php

					}else{

					?>

                    <strong class="Timer">Store is Closed Now</strong>

      				<?php

					}

					?>

				</div></div><!-- End cart_box -->

			</div><!-- End col-md-3 -->

		</div><!-- End row -->

	</div><!-- End container pin -->

</div><!-- End container -->

<!-- End Content =============================================== -->
<div id="mobstickyfooter" style="position: fixed; bottom:0; width: 100%; height: 35px; background-color: #CCC; border-top:#999 solid 1px; display:none"><a href="checkout" id="checkout_mob" class="btn_mobfootred">Checkout ></a><a href="#cart_box" class="btn_mobfootgreen">Order: <span id="price_mob"></span></a></div>
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

<script>$("#cart_box").pin({padding: {top: 50, bottom: 20},minWidth: 1100, containerSelector: "#container_pin"})

$(".box_style_1").pin({minWidth: 1100, marginbottom:220, containerSelector: "#container_pin"})

</script>

<script type="text/javascript" src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js/bootstrap-select.js"></script>

<script type="text/javascript" src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js/petrojs-1.0.0.min.js"></script>

<script type="text/javascript" src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js/save_order.js"></script>

<script type="text/javascript" src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js/offline.min.js"></script>

<script type="text/javascript" src="<?php echo PetroFDS::get_system_config('website_path_media') ?>/js/menu.js"></script>

<script type="text/javascript">

getTimer();

</script>

</body></html>