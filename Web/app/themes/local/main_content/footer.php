<footer id="footer">

		<div class="go-up"><i class="icon-chevron-up"></i></div>

		<div class="container">

			<div class="row">

				<div class="col-md-3">

					<div class="footer-widget footer-widget-1">

						<h6>PetroFDS</h6>

						<p><!--About Content--></p>

						<div class="footer-social">

							<ul>

								<li class=""><a href="#"><i class="icon-facebook"></i></a></li>

								<li class=""><a href="#"><i class="icon-twitter"></i></a></li>

								<li class=""><a href="#"><i class="icon-pinterest"></i></a></li>

								<li class=""><a href="#"><i class="icon-rss"></i></a></li>

							</ul>

						</div>

					</div>
                    <br/>
                    <div class="footer-widget footer-widget-3">
						<ul style="margin-top:30px;">
							<li>Line1</li>
                            <li>Line2</li>
                            <li>Line3</li>
						</ul>
					</div>
                    
				</div>

				<div class="col-md-3">

					<div class="footer-widget footer-widget-2">

						<h6>Login Details</h6>

                        <?php

                        if(isset($_SESSION['LOGIN_USER_ID'])){

						?>

							<div class="subscribe" style="color:#FFF;">

                            Welcome - <?php echo $_SESSION['LOGIN_USER_FULLNAME'] ?><br/>

                                <div class="subscribe-input">

                                    <a href="setups/files/logout_all"><input type="submit" value="Logout"></a>

                                </div>

                            </div>

                        <?php

						}else{

						?>

                            <form action="setups/files/login_all.php" method="post" class="subscribe" enctype="multipart/form-data">

                                <div class="col-md-10">

                                    <div class="subscribe-input">

                                        <input type="text" name="email" id="email" required="required" placeholder="Email address ...">

                                        <i class="icon-envelope-alt"></i>

                                    </div>

                                    <br/>

                                    <div class="subscribe-input">

                                        <input type="password" name="password" id="password" required="required" placeholder="Password here ...">

                                        <i class="icon-key"></i>

                                    </div>

                                    <br/>

                                    <div class="subscribe-input">

                                        <input type="submit" value="Login">

                                    </div>

                                </div>

                            </form>

                        <?php

						}

						?>
					</div>
				</div>
				
				<div class="col-md-3">

					<div class="footer-widget footer-widget-3">

						<h6>Site Menu</h6>

						<ul>

							<li><a href="index">Home</a></li>

							<li><a href="about">About Us</a></li>

							<li><a href="menu">Our Menus</a></li>

							<li><a href="account">My Account</a></li>

							<li><a href="cart">Shopping Cart</a></li>

							<li><a href="contact">Contact Us</a></li>

						</ul>

					</div>

				</div>

				<div class="col-md-3">

					<div class="footer-widget footer-widget-4">

						<h6>Opening Hours</h6>

						<div class="row">

                        <?php

						foreach(PetroFDS::get_days_config() as $value){

							echo '<div class="col-md-5">'.$value['days'].'</div>';

							echo '<div class="col-md-7">'.PetroFDS::ftime($value['website_open'],12).' - '.PetroFDS::ftime($value['website_close'],12).'</div><br/>';

						}

						?>

						</div>

					</div>

				</div>

			</div><!-- End row -->

		</div><!-- End container -->

	</footer><!-- End footer -->

	<footer id="footer-bottom">

		<div class="container">

			<div class="row">

				<div class="col-md-6">

					<div class="copyright">ThePetronics |  All Rights Reserved PetroFDS Version 1.0</div>

				</div>

				<div class="col-md-6">

					<a class="copyrights" href="http://www.thepetronics.com">Powered By ThePetronics</a>

				</div>

			</div>

		</div><!-- End container -->

		<div class="re_s_6"></div>

	</footer><!-- End footer-bottom -->