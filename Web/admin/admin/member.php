<?php 
include('../auth_admin.php'); 
require_once('../../app/themes/lib/system.lib.php');
$conn = PetroFDS::ConnectDB();
PetroFDS::SetTimeZone();
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<HTML>

<head>
  <meta content="text/html; charset=UTF-8" http-equiv="content-type">
  <title>PetroFDS | Member Area</title>
  <link rel="stylesheet" href="../css/dashboard.css">
</head>
<?php include('../main_content/header_admin.php'); ?> 

<body>

<table width="100%" border="0" class="sindh " style="background-image:url('')">
	<tr>
    	<td>
<?php include('dashboard.php'); ?>         
        </td>
	</tr>
</table>

<?php include('../main_content/footer.php'); ?> 

</body>
</html>