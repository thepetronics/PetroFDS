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

  <title>PetroFDS | Setups Emails</title>
</head>


<body>

<?php  include('../main_content/header_admin.php'); ?> 

<?php
$qry_email="SELECT * FROM emails";

$stmt_email = $conn->prepare($qry_email);

$stmt_email->execute();

$rows_email = $stmt_email->fetchAll(PDO::FETCH_ASSOC);

if($rows_email){
	foreach($rows_email as $row_email){
?>
<label>&nbsp;</label>
<center><label style="font-family:Arial,Helvetica,sans-serif;font-size:25px;color:#f16445;text-align:center" >SETUP EMAILS</label></center>
  <div >
  <div class="page-region" >
  <div class="page-content content-wrapper clear-block ">
  		<form  autocomplete="off" action="save_emails.php" accept-charset="UTF-8" method="post" enctype="multipart/form-data">

	<table width="100%">
	<tr>
   		<td width="50%">
       	<div class="form form-layout-simple clear-block" >
		
        		<fieldset class=" fieldset titled">
					<legend><span class="fieldset-title">EMAILS INFORMATION</span></legend>
					<div class="fieldset-content clear-block ">
					<input type="hidden" id="id" name="id" value="<?php echo $row_email['id'] ?>" />
                    <input type="hidden" id="email_status" name="email_status" value="edit" />
                    <div class="form-item form-item-labeled" id="edit-mail-wrapper">
                    <label style="color:red;">Note: If you don't want any of the password to be changed please leave the field blank</label>
                    <table >
                    	<tr>
                        	<td>
           						<label>ADMINISTRATOR EMAIL:</label>
                                <input type="text" class="form-text required fluid" id="admin_email" name="admin_email" value="<?php echo $row_email['admin_email'] ?>">
                            </td>
                            <td>
           						<label>ORDERS EMAIL:</label>
		                        <input type="text" class="form-text required fluid" id="order_email" name="order_email" value="<?php echo $row_email['order_email'] ?>">
                            </td>
                            <td>
           						<label>INFORMATION EMAIL:</label>
		                        <input type="text" class="form-text required fluid" id="info_email" name="info_email" value="<?php echo $row_email['info_email'] ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>ADMINISTRATOR EMAIL PASSWORD: </label>
                                <input type="password" class="form-text required fluid" id="admin_email_pass" name="admin_email_pass" value="">
                            </td>
                            <td>
                                <label>ORDERS EMAIL PASSWORD: </label>
                                <input type="password" class="form-text required fluid" id="order_email_pass" name="order_email_pass" value="">
                            </td>
                            <td>
                                <label>INFORMATION EMAIL PASSWORD: </label>
                                <input type="password" class="form-text required fluid" id="info_email_pass" name="info_email_pass" value="">
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
<center><label style="font-family:Arial,Helvetica,sans-serif;font-size:25px;color:#f16445;text-align:center" >SETUP EMAILS</label></center>
  <div >
  <div class="page-region" >
  <div class="page-content content-wrapper clear-block ">
  		<form  autocomplete="off" action="save_emails.php" accept-charset="UTF-8" method="post" enctype="multipart/form-data">

	<table width="100%">
	<tr>
   		<td width="50%">
       	<div class="form form-layout-simple clear-block" >
		
        		<fieldset class=" fieldset titled">
					<legend><span class="fieldset-title">EMAILS INFORMATION</span></legend>
					<div class="fieldset-content clear-block ">
					<input type="hidden" id="email_status" name="email_status" value="new" />
                    <div class="form-item form-item-labeled" id="edit-mail-wrapper">
                    <table >
                    	<tr>
                        	<td>
           						<label>ADMINISTRATOR EMAIL: </label>
                                <input type="text" class="form-text required fluid" id="admin_email" name="admin_email">
                            </td>
                            <td>
           						<label>ORDERS EMAIL: </label>
		                        <input type="text" class="form-text required fluid" id="order_email" name="order_email">
                            </td>
                            <td>
           						<label>INFORMATION EMAIL: </label>
		                        <input type="text" class="form-text required fluid" id="info_email" name="info_email">     
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>ADMINISTRATOR EMAIL PASSWORD: </label>
                                <input type="password" class="form-text required fluid" id="admin_email_pass" name="admin_email_pass">
                            </td>
                            <td>
                                <label>ORDERS EMAIL PASSWORD: </label>
                                <input type="password" class="form-text required fluid" id="order_email_pass" name="order_email_pass">           
                            </td>
                            <td>
                                <label>INFORMATION EMAIL PASSWORD: </label>      
                                <input type="password" class="form-text required fluid" id="info_email_pass" name="info_email_pass">
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