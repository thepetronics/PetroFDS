<?php 
if(!file_exists('../../app/themes/lib/db.cfg')){
	die('Please Install the application to start proceeding and please connect to the internet for installation PATH=/install.');
}
PetroFDS::SetTimeZone();
$AdminDatas = PetroFDS::getAdminUsers('AND id='.$_SESSION['SESS_USER_ID'].'');
foreach((array)$AdminDatas as $AdminData){
	$FullAdminName = $AdminData['firstname'].' '.$AdminData['lastname'];
}
?>
<link rel="apple-touch-icon" sizes="57x57" href="../favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="../favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="../favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="../favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="../favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="../favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="../favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="../favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="../favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="../favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="../favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="../favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="../favicon/favicon-16x16.png">
<link rel="manifest" href="../favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="../favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<link type="text/css" href="../css/main/style.css" rel="stylesheet"><style>._css3m{display:none}</style>
<link href="../css/main/member.css" media="screen" rel="stylesheet" type="text/css">

<div id="branding" style="background:#F00; margin-bottom:5px;" class="dropdown-blocks toggle-blocks clear-block processed">
	<div class="clear-block">
      <div class="branding-left position left size-50">
      	<div id="language-switcher">
        	<ul>
            	<li class="en first active"><a href="" class="language-link active">Recorded IP:</a></li>
				<li class="pt-br"><a href="" class="language-link"><?php echo $_SESSION['USER_IP'] ?></a></li>
			</ul>
        </div>
      </div>
      <div class="branding-right position left size-50">              
		<div id="language-switcher" style="float:right;">
            <ul>
                <li class="en first active"><a href="" class="language-link active">Welcome, <b><?php echo $FullAdminName ?> </b></a><a class="language-link" href='../logout'>Log Out</a></li>
            </ul>
  		</div>
      </div>
	</div>
</div>
<?php
if($_SESSION['ROLE_ID']==0){
	
	$sql_email = PetroFDS::getCustomQuery('SELECT * FROM `emails`');
	foreach((array)$sql_email as $row_email){
		$admin_email = $row_email['admin_email'];
		$admin_email_pass = $row_email['admin_email_pass'];
	}
?>
<ul class="topmenu" id="css3menu1" style="">
  <li class="topmenu"><a style="" title="Home" href="../admin/member"><img alt="" src="../images/main/001_01.png">Dashboard</a></li>
	<li class="toproot"><a style="" title="Schemes" href="#"><span><img alt="" src="../images/main/001_50.png">Setups</span></a>
	<div style="width:315px;" class="submenu">
	<div style="width:50%" class="column"><ul>
		<li><a title="Categories" href="../setups/categories"><img alt="" src="../images/main/001_49.png">Categories</a></li>

		<li><a title="Set Options" href="../setups/options"><span><img alt="" src="../images/main/001_49.png">Set Options</span></a></li>

        <li><a title="Coupon Code" href="../setups/coupon_code"><span><img alt="" src="../images/main/001_49.png">Coupon Code</span></a></li>
        
        <li><a title="Set Post Code" href="../setups/set_post_code"><span><img alt="" src="../images/main/001_49.png">Set Post Code</span></a></li>
	</ul></div>
	<div style="width:50%" class="column"><ul>

		<li><a title="Products" href="../setups/list_products"><span><img alt="" src="../images/main/001_49.png">Products</span></a></li>
        
        <li><a title="Loyalty Points" href="../setups/loyalty_points"><span><img alt="" src="../images/main/001_49.png">Loyalty Points</span></a></li>

		<li><a title="Set Option Type" href="../setups/option_type"><span><img alt="" src="../images/main/001_49.png">Set Option Type</span></a></li>

	</ul></div></div>
</li>
	<li class="toproot"><a style="" title="System Management" href="#"><span><img alt="" src="../images/main/133.png">System Management</span></a>
	<div style="width:300px;" class="submenu">
	<div style="width:50%" class="column"><ul>
    
   		<li><a title="Users Management" href="../sm/view_user"><span><img alt="" src="../images/main/001_49.png">Users Management</span></a>
		<div class="submenu">
		<div class="column"><ul>
			<li><a title="Add User" href="../sm/add_user"><img alt="" src="../images/main/001_55.png">Add User</a></li>
			<li><a title="View Users" href="../sm/view_user"><img alt="" src="../images/main/001_04.png">View User</a></li>
		</ul></div></div>
		</li>
        
        <li><a title="Frontend Users Management" href="../sm/view_user_frontend"><span><img alt="" src="../images/main/001_49.png">Frontend Users Management</span></a>
		<div class="submenu">
		<div class="column"><ul>
			<li><a title="Add User" href="../sm/add_user_frontend"><img alt="" src="../images/main/001_55.png">Add User</a></li>
			<li><a title="View Users" href="../sm/view_user_frontend"><img alt="" src="../images/main/001_04.png">View User</a></li>
		</ul></div></div>
		</li>

   		<li><a title="Role Management" href="../sm/view_role"><span><img alt="" src="../images/main/001_49.png">Roles Management</span></a>
		<div class="submenu">
		<div class="column"><ul>
			<li><a title="Add Role" href="../sm/add_role"><img alt="" src="../images/main/001_55.png">Add Role</a></li>
			<li><a title="View Roles" href="../sm/view_role"><img alt="" src="../images/main/001_04.png">View Roles</a></li>
		</ul></div></div>
		</li>

   		<li><a title="Permissions Management" href="../sm/add_permission"><span><img alt="" src="../images/main/001_49.png">Permissions Management</span></a>
		</li>
        
        <li><a title="System Configuration" href="../sm/system_config"><span><img alt="" src="../images/main/001_49.png">System Configuration</span></a>
		</li>
		
        <li><a title="Email Setup" href="../sm/emails"><span><img alt="" src="../images/main/001_49.png">Email Setup</span></a>
		</li>
        
        <li><a title="Mobile App Setting" href="../sm/mobile"><span><img alt="" src="../images/main/001_49.png">Mobile App Setting</span></a>
		</li>
    
    
	</ul></div>

	<div style="width:50%" class="column">
    </div>


    </div>
</li>
	<li class="topmenu"><a style="height:24px;line-height:24px;" title="Orders" href="../Orders/"><img alt="" src="../images/main/001_20.png">Orders</a></li>
	<li class="topmenu"><a style="height:24px;line-height:24px;" title="Personal Setting" href="../admin/profile"><img alt="" src="../images/main/001_11.png">Personal Setting</a></li>
	<li class="topmenu"><a style="height:24px;line-height:24px;" title="Log Out" href="../logout"><img alt="" src="../images/main/logout.png">Log Out</a></li>
</ul>
<?php
}else{
?>
<ul class="topmenu" id="css3menu1" style="">
  <li class="topmenu"><a style="" title="Home" href="../admin/member"><img alt="" src="../images/main/001_01.png">Dashboard</a></li>
	<li class="toproot"><a style="" title="Schemes" href="#"><span><img alt="" src="../images/main/001_50.png">Setups</span></a>
	<div style="width:315px;" class="submenu">
	<div style="width:50%" class="column">
    <ul>
    <?php
	if($permission['category']==1){
	?>
		<li><a title="Categories" href="../setups/categories"><img alt="" src="../images/main/001_49.png">Categories</a></li>
	<?php
	}
	if($permission['options']==1){
	?>
		<li><a title="Set Options" href="../setups/options"><span><img alt="" src="../images/main/001_49.png">Set Options</span></a></li>
	<?php
	}
	if($permission['couponcode']==1){
	?>
        <li><a title="Coupon Code" href="../setups/coupon_code"><span><img alt="" src="../images/main/001_49.png">Coupon Code</span></a></li>
    <?php
	}
	?>
	</ul></div>
	<div style="width:50%" class="column"><ul>
	<?php
	if($permission['product']==1){
	?>
		<li><a title="Products" href="../setups/list_products"><span><img alt="" src="../images/main/001_49.png">Products</span></a></li>
    <?php
	}
	if($permission['loyaltypoint']==1){
	?>   
        <li><a title="Loyalty Points" href="../setups/loyalty_points"><span><img alt="" src="../images/main/001_49.png">Loyalty Points</span></a></li>
	<?php
	}
	if($permission['optiontype']==1){
	?>
		<li><a title="Set Option Type" href="../setups/option_type"><span><img alt="" src="../images/main/001_49.png">Set Option Type</span></a></li>
	<?php
	}
	if($permission['postcode']==1){
	?>        
        <li><a title="Set Post Code" href="../setups/set_post_code"><span><img alt="" src="../images/main/001_49.png">Set Post Code</span></a></li>
	<?php
	}
	?>
	</ul></div></div>
</li>
	<li class="toproot"><a style="" title="System Management" href="#"><span><img alt="" src="../images/main/133.png">System Management</span></a>
	<div style="width:300px;" class="submenu">
	<div style="width:50%" class="column"><ul>
    <?php
	if($permission['user_management']==1){
	?>
   		<li><a title="Users Management" href="../sm/view_user"><span><img alt="" src="../images/main/001_49.png">Users Management</span></a>
		<div class="submenu">
		<div class="column"><ul>
			<li><a title="Add User" href="../sm/add_user"><img alt="" src="../images/main/001_55.png">Add User</a></li>
			<li><a title="View Users" href="../sm/view_user"><img alt="" src="../images/main/001_04.png">View User</a></li>
		</ul></div></div>
		</li>
    <?php
	}
	if($permission['frontend_user_management']==1){
	?>
    	<li><a title="Frontend Users Management" href="../sm/view_user_frontend"><span><img alt="" src="../images/main/001_49.png">Frontend Users Management</span></a>
		<div class="submenu">
		<div class="column"><ul>
			<li><a title="Add User" href="../sm/add_user_frontend"><img alt="" src="../images/main/001_55.png">Add User</a></li>
			<li><a title="View Users" href="../sm/view_user_frontend"><img alt="" src="../images/main/001_04.png">View User</a></li>
		</ul></div></div>
		</li>
    <?php
	}
	if($permission['roles_management']==1){
	?>
        <li><a title="Role Management" href="../sm/view_role"><span><img alt="" src="../images/main/001_49.png">Roles Management</span></a>
        <div class="submenu">
        <div class="column"><ul>
            <li><a title="Add Role" href="../sm/add_role"><img alt="" src="../images/main/001_55.png">Add Role</a></li>
            <li><a title="View Roles" href="../sm/view_role"><img alt="" src="../images/main/001_04.png">View Roles</a></li>
        </ul></div></div>
        </li>
    <?php
	}
	if($permission['system_config']==1){
	?>    
        <li><a title="System Configuration" href="../sm/system_config"><span><img alt="" src="../images/main/001_49.png">System Configuration</span></a>
		</li>
    <?php
	}
	if($permission['email_setups']==1){
	?>   
    <li><a title="Email Setup" href="../sm/emails"><span><img alt="" src="../images/main/001_49.png">Email Setup</span></a>
	</li>
    <?php
	}
	if($permission['mobile_setups']==1){
	?>   
    <li><a title="Mobile App Setting" href="../sm/mobile"><span><img alt="" src="../images/main/001_49.png">Mobile App Setting</span></a>
	</li>
    <?php
	}
	?> 
	</ul></div>

	<div style="width:50%" class="column">
    </div>


    </div>
</li>
	<?php
	if($permission['orders']==1){
	?>
        <li class="topmenu"><a style="height:24px;line-height:24px;" title="Orders" href="../Orders/"><img alt="" src="../images/main/001_20.png">Orders</a></li>
    <?php
	}
	?>
	<li class="topmenu"><a style="height:24px;line-height:24px;" title="Personal Setting" href="../admin/profile"><img alt="" src="../images/main/001_11.png">Personal Setting</a></li>
	<li class="topmenu"><a style="height:24px;line-height:24px;" title="Log Out" href="../logout"><img alt="" src="../images/main/logout.png">Log Out</a></li>
</ul>
<?php
}
?>