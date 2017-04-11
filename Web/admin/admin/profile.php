<?php 
include('../auth_admin.php'); 
require_once('../../app/themes/lib/system.lib.php');
$conn = PetroFDS::ConnectDB();
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<HTML>

<head>
  <meta content="text/html; charset=UTF-8" http-equiv="content-type">

  <title>PetroFDS | User Profile</title>
</head>


<body>

<?php  include('../main_content/header_admin.php'); ?> 

<?php

	$u_id = $_SESSION['SESS_USER_ID'];

	$stmt = $conn->prepare("SELECT * FROM `admin` WHERE id='".$u_id."'");

	$stmt->execute();

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<table cellpadding="0" cellspacing="0" style="background-image:url('')">
<tr>
	<td>
<label>&nbsp;</label>
<center><label style="font-family:Arial,Helvetica,sans-serif;font-size:25px;color:#f16445;text-align:center" >PROFILE</label></center>

    </td>
</tr>
<?php
if($rows){
	foreach($rows as $row){
?>
<tr >
<td >
<div id="page"   style="left:0px; right: 0px; margin-left:90px; padding:0px;" >
	<div class="limiter clear-block">
  	  <div id="content" ><div class="page-region"  >
    	<div class="page-content content-wrapper clear-block" style="width:600px;"  >
        
        	<form AUTOCOMPLETE="off" action="save_profile.php" ACCEPT-CHARSET="UTF-8" method="post" id="profile_form" name="profile_form" enctype="multipart/form-data">

			<div >
            	<div class="form form-layout-simple clear-block" >
		
        		<fieldset class=" fieldset titled">
					<legend><span class="fieldset-title">USER INFORMATION</span></legend>
					<div class="fieldset-content clear-block ">
					
                    <div class="form-item form-item-labeled" id="edit-mail-wrapper">
                    <table >
                    	<tr>
                        	<td width="216">
           						<label for="edit-mail">Username: </label>
		                        <label  style="color:#000;font-size:14px;font-weight:600" ><?php echo $_SESSION['SESS_USERNAME'] ?></label>            
                            </td>
                            <td width="164">
           						<label for="edit-mail">Your IP: </label>
		                        <label  style="color:#000;font-size:14px;font-weight:600" ><?php echo $_SESSION['USER_IP'] ?></label>            
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="3">
                                <label for="edit-mail">Password: </label>
                                <input maxlength="64" style="width:200px" name="password" id="password"  class="form-text required fluid" type="password">      <span style="font-size:10px">If you do not want to change your password, leave this field blank</span>
                            </td>
                        </tr>
                    </table>
				  	</div>
					</div>
				</fieldset>


        		<fieldset class=" fieldset titled">
					<legend><span class="fieldset-title">PERSONAL INFORMATION</span></legend>
					<div class="fieldset-content clear-block ">
					
                    <div class="form-item form-item-labeled" id="edit-mail-wrapper">
                    <table >
                        <tr>
                        	<td>
           						<label for="edit-mail">First Name: </label>
                                <input maxlength="64" style="width:250px" name="first_name" id="first_name" value="<?php echo $row['firstname'] ?>"  class="form-text required fluid" type="text">

                            </td>
                            <td width="253">
           						<label for="edit-mail">Last Name: <span class="form-required" title="This field is required.">*</span></label>
                                <input maxlength="64" style="width:250px" name="last_name" id="last_name" value="<?php echo $row['lastname'] ?>"  class="form-text required fluid" type="text">
                            </td>

                        </tr>
                        <tr>
                        	<td>
           						<label for="edit-mail">E-Mail: <span class="form-required" title="This field is required.">*</span> </label>
                                <input maxlength="150" style="width:250px" name="email" id="email" value="<?php echo $row['email'] ?>"  class="form-text required fluid" type="text">

                            </td>

                        </tr>

                    </table>
				  	</div>
					</div>
				</fieldset>

		<table  style="border:1px solid #CCC;" width="100%" >
        	<tr>


                <td align="right" style="height:40px;vertical-align:middle" colspan="2">
                <input name="b1" id="b1" value="Save" class="form-submit"  type="submit">&nbsp;

                </td>
            </tr>
        </table>

                
                </div>
			</div>
			</form>
       </div>
    </div>
  </div>
</div>
</div>
</td>
</tr>
<?php
	}
}
?>




</table>
<?php include('../main_content/footer.php'); ?> 

</body>
</html>