<?php
include_once 'install.lib.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Petro Food Delivery System | Installation</title>
<link rel="apple-touch-icon" sizes="57x57" href="../admin/favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="../admin/favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="../admin/favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="../admin/favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="../admin/favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="../admin/favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="../admin/favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="../admin/favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="../admin/favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="../admin/favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="../admin/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="../admin/favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="../admin/favicon/favicon-16x16.png">
<link rel="manifest" href="../admin/favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="../admin/favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<link rel="stylesheet" type="text/css" href="css/topbar.css" />
<link rel="stylesheet" type="text/css" href="css/navigation.css" />
<link rel="stylesheet" type="text/css" href="css/layout.css" />
<link rel="stylesheet" type="text/css" href="css/layout-responsive.css" />
<link rel="stylesheet" type="text/css" href="css/skin.css" />
<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'></head>
<body>
<?php
PetroFDSInstall::CheckStatus();
if(isset($_GET['status'])){
	if($_GET['status'] == "success"){
?>
	<label align="center" style="color:#34b43e">Applicaton installed successfully go back to login page and delete install folder AdminURL=/admin.</label>
<?php
	}else if($_GET['status'] == "failed"){
?>
	<label align="center" style="color:#F00">Failed Applicaton not installed successfully try again after removing database.</label>
<?php
	}
}
?>
<h3 align="center" style="font-weight:bold; color:#34B43E;">Petro(Food Delivery System) Installation</h3>
<div id="loading-form"></div>
<form action="install" method="post" enctype="multipart/form-data" id="f1" name="f1" onsubmit="return validateForm()">
<fieldset class="form-note">
<table>
<tr>
<td>
<label class="imp-note-red">Please read this carefully before start proceeding the installation. You have to setup some cronjobs for your emails.</label>
</td>
</tr>
<tr>
<td>
<label>There are 3 files which is managed by your server cronjob paths are:</label>
<ol class="ol">
<li>CronJob.php Time=30mins</li>
<li>EmailServer/emailuser.php Time=5mins</li>
<li>EmailServer/notifyemail.php Time=2 times in a Day</li>
</ol>
</td>
</tr>
</table>
</fieldset>
<fieldset class="form-config">
<table>
<tr>
<td>
<p>Database Host:</p>
</td>
<td style="padding-left:200px;">
<input class="input" type="text" name="database_host" id="database_host" />
</td>
</tr>
<tr>
<td>
<p>Database Name:</p>
</td>
<td style="padding-left:200px;">
<input class="input" type="text" name="database_name" id="database_name" />
</td>
</tr>
<tr>
<td>
<p>Database Username:</p>
</td>
<td style="padding-left:200px;">
<input class="input" type="text" name="database_username" id="database_username" />
</td>
</tr>
<tr>
<td>
<p>Database Password:</p>
</td>
<td style="padding-left:200px;">
<input class="input" type="password" name="database_password" id="database_password" />
</td>
</tr>
<tr>
</tr>
</table>
</fieldset>
<fieldset class="admin-setup">
<table>
<tr>
<td>
<p>Firstname:</p>
</td>
<td style="padding-left:200px;">
<input class="input" type="text" name="admin_firstname" id="admin_firstname" />
</td>
</tr>
<tr>
<td>
<p>Lastname:</p>
</td>
<td style="padding-left:200px;">
<input class="input" type="text" name="admin_lastname" id="admin_lastname" />
</td>
</tr>
<tr>
<td>
<p>Username:</p>
</td>
<td style="padding-left:200px;">
<input class="input" type="text" name="admin_username" id="admin_username" />
</td>
</tr>
<tr>
<td>
<p>Password:</p>
</td>
<td style="padding-left:200px;">
<input class="input" type="password" name="admin_password" id="admin_password" />
</td>
</tr>
<tr>
<td><p>Website Title:</p></td>
<td style="padding-left:200px;"><input type="text" id="website_title" name="website_title" /></td>
</tr>
</table>
</fieldset>
<fieldset class="localize-check">
<table>
<tr>
<td>
<p>Time Zone:</p>
</td>
<td style="padding-left:200px;" id="zone">
</td>
</tr>
<tr>
<td>
<p>Default Currency:</p>
</td>
<td style="padding-left:200px;">
<input type="text" id="currency" name="currency" />
<label class="imp-note-red">Note: Currency should be in html format like <span>&amp;euro;</span> for Euro</label>
</td>
</tr>
</table>
</fieldset>
<fieldset class="submit">
<input type="submit" class="btn" value="Install" />
</fieldset>
</form>
<script type="text/javascript" src="js/authentication_install.js"></script>
</body>
</html>