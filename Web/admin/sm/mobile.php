<?php 
require_once('../../app/themes/lib/system.lib.php');
include('../auth_admin.php'); 
if($_SESSION['ROLE_ID']!=0){
	die("You don't have permission to access please contact administrator.");
}
$conn = PetroFDS::ConnectDB();
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<HTML>

<head>
  <meta content="text/html; charset=UTF-8" http-equiv="content-type">

  <title>PetroFDS | Mobile App Setting</title>
</head>


<body>

<?php  include('../main_content/header_admin.php'); ?> 

<?php
$qry_mobile="SELECT * FROM mobile_setting";

$stmt_mobile = $conn->prepare($qry_mobile);

$stmt_mobile->execute();

$rows_mobile = $stmt_mobile->fetchAll(PDO::FETCH_ASSOC);

if($rows_mobile){
	foreach($rows_mobile as $row_mobile){
?>
<label>&nbsp;</label>
<center><label style="font-family:Arial,Helvetica,sans-serif;font-size:25px;color:#f16445;text-align:center" >MOBILE APP SETTING</label></center>
  <div >
  <div class="page-region" >
  <div class="page-content content-wrapper clear-block ">
  	<form  autocomplete="off" action="save_mobile.php" accept-charset="UTF-8" method="post" enctype="multipart/form-data">

	<table width="100%">
	<tr>
   		<td width="50%">
       	<div class="form form-layout-simple clear-block" >
		
        		<fieldset class=" fieldset titled">
					<legend><span class="fieldset-title">API INFORMATION</span></legend>
					<div class="fieldset-content clear-block ">
					<input type="hidden" id="id" name="id" value="<?php echo $row_mobile['id'] ?>" />
                    <input type="hidden" id="mobile_status" name="mobile_status" value="edit" />
                    <div class="form-item form-item-labeled" id="edit-mail-wrapper">
                    <table>
                    	<tr>
                        	<td>
           						<label>API KEY:</label>
                                <input type="text" class="form-text required fluid" size="100" id="api_key" name="api_key" value="<?php echo $row_mobile['api_key'] ?>">
                            </td>
                        </tr>
                        <tr>
                        	<td>
                            <label style="color:#F00;">Follow These Steps to get you API Key:</label>
                            <ol>
                            <li>Goto: <a target="_blank" href="https://console.firebase.google.com/">https://console.firebase.google.com/</a> then enter login details.</li>
                            <li>On Firebase dashboard click add project.</li>
                            <li>Type Project name and select your country/region.</li>
                            <li>After creating your project click add firebase to your android app.</li>
                            <li>Type your android app package name Like: com.thepetronics.petro.fds and then enter app nickname.</li>
                            <li>Then Download config file called:google-services and place it in app folder.</li>
                            <li>Then Click on setting icon from overview and click project setting.</li>
                            <li>Click cloud messaging and copy Legacy server key which is your original API key for FCM.</li>
                            </ol>
                            <label style="color:#F00;">If you don't understand after following the above steps please take guid from that link:<a style="text-transform:none;" target="_blank" href="https://firebase.google.com/docs/cloud-messaging/"> https://firebase.google.com/docs/cloud-messaging/</a></label>
                            </td>
                        </tr>
                    </table>	
				  	</div>
					</div>
				</fieldset>
		</div>
        <table  style="border:0;" width="100%" >
        	<tr style="background-color:#CCC" >


                <td align="right" style="height:40px;vertical-align:middle" colspan="2">
                <input value="Save" class="form-submit" type="submit">&nbsp;
                </td>
            </tr>
        </table>
        </td>
        </tr>
        </table>
        </form>
       </div>
    </div>
  </div>
</div>
</div>
<?php
	}
}else{
?>
<label>&nbsp;</label>
<center><label style="font-family:Arial,Helvetica,sans-serif;font-size:25px;color:#f16445;text-align:center" >MOBILE APP SETTING</label></center>
  <div >
  <div class="page-region" >
  <div class="page-content content-wrapper clear-block ">
  		<form  autocomplete="off" action="save_mobile.php" accept-charset="UTF-8" method="post" enctype="multipart/form-data">

	<table width="100%">
	<tr>
   		<td width="50%">
       	<div class="form form-layout-simple clear-block" >
		
        		<fieldset class=" fieldset titled">
					<legend><span class="fieldset-title">API INFORMATION</span></legend>
					<div class="fieldset-content clear-block ">
					<input type="hidden" id="mobile_status" name="mobile_status" value="new" />
                    <div class="form-item form-item-labeled" id="edit-mail-wrapper">
                    <label style="color:red;">Note: If you don't know how to get API KEY follow this link:<a style="text-transform:none;" target="_blank" href="https://webkul.com/blog/generate-api-key-fcm-sender-id/">https://webkul.com/blog/generate-api-key-fcm-sender-id/</a></label>
                    <table >
                    	<tr>
                        	<td>
           						<label>API KEY: </label>
                                <input type="text" class="form-text required fluid" size="100" id="api_key" name="api_key">
                            </td>
                        </tr>
                    </table>	
				  	</div>
					</div>
				</fieldset>
		</div>
        <table  style="border:0;" width="100%" >
        	<tr style="background-color:#CCC" >


                <td align="right" style="height:40px;vertical-align:middle" colspan="2">
                <input value="Save" class="form-submit" type="submit">&nbsp;
                </td>
            </tr>
        </table>
        </td>
        </tr>
        </table>
        </form>
       </div>
    </div>
  </div>
</div>
</div>
<?php
	}
?>
<?php include('../main_content/footer.php'); ?> 
</body>
</html>