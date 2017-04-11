<div id="header-top">

		<div class="container clearfix">

			<div class="row">

				<div class="col-md-6">

					<div class="header-half-1"></div>

				</div>

				<div class="col-md-6">

					<div class="header-half-2">Call Us Now : 01389 711 797 <span> | </span> Get In Touch : <?php echo PetroFDS::get_email_config('info_email'); ?></div>

				</div>

			</div>

		</div><!-- End container -->

	</div><!-- End header-top -->

	<header id="header" class="header-2">

		<div class="re_s_2"></div>

		<div class="container clearfix">

			<div class="logo"><a href="index"><img alt="" src="media/themes/local/images/green/logo.png"></a></div>

			<div class="row">

				<div class="col-md-6">

					<div class="navigation navigation-1">

						<ul>

							<li><a href="index">Home</a></li>

							<li><a href="about">About Us</a></li>

							<li><a href="menu">Our Menu</a></li>

						</ul>

					</div>

				</div>

				<div class="col-md-6">

					<div class="navigation navigation-2">

						<ul>

							<?php
							if(isset($_SESSION['LOGIN_USER_ID'])){
							?>
								<li><a href="account">My Account</a></li>
                            <?php
							}else{
							?>
                            	<li><a href="login">My Account</a></li>
                            <?php
							}
							?>

                            <li><a href="cart">Shopping Cart</a></li>

							<li><a href="contact">Contact</a></li>

						</ul>

					</div>

				</div>

			</div>

		</div><!-- End container -->

		<div class="re_s_1"></div>

	</header><!-- End header -->