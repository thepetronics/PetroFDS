<?php 
include('../auth_admin.php'); 
if($_SESSION['ROLE_ID']!=0){
	if($permission['user_management']==0){
		die("You don't have permission to access please contact administrator.");
	}
}
require_once('../../app/themes/lib/system.lib.php');
$conn = PetroFDS::ConnectDB();
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<HTML>

<head>
  <meta content="text/html; charset=UTF-8" http-equiv="content-type">

  <title>PetroFDS | Edit Frontend User</title>
</head>


<body>

<?php  include('../main_content/header_admin.php'); ?> 

<?php
	
	$u_id = $_GET['id'];
	
	$stmt = $conn->prepare("SELECT * FROM `users` WHERE id='".$u_id."'");

	$stmt->execute();

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
if($rows){
	foreach($rows as $row){
?>
<table class="sindh" cellpadding="0" cellspacing="0" style="background-image:url('')">
<tr>
	<td>
<label>&nbsp;</label>
<center><label style="font-family:Arial,Helvetica,sans-serif;font-size:25px;color:#f16445;text-align:center" >EDIT FRONTEND USER</label></center>

    </td>
</tr>
<tr >
<td >
<div id="page"   style="left:0px; right: 0px; margin-left:90px; padding:0px;" >
	<div class="limiter clear-block">
  	  <div id="content" ><div class="page-region"  >
    	<div class="page-content content-wrapper clear-block" style="width:600px;"  >
        
        	<form  onsubmit='return false;' autocomplete="off" action="save_edit_user_frontend.php" accept-charset="UTF-8" method="post" id="edit_user_form" name="edit_user_form" enctype="multipart/form-data">
				<input type="hidden" id="main_id" name="main_id" value="<?php echo $u_id ?>" />
  				<input type="hidden" id="email" name="email" value="<?php echo $row['email'] ?>" />
			<div >
            	<div class="form form-layout-simple clear-block" >
		
        		<fieldset class=" fieldset titled">
					<legend><span class="fieldset-title">USER INFORMATION</span></legend>
					<div class="fieldset-content clear-block ">
					
                    <div class="form-item form-item-labeled" id="edit-mail-wrapper">
                    <table >
                    	<tr>
                        	<td width="216">
           						<label for="edit-mail">Email: </label>
		                        <label  style="color:#000;font-size:14px;font-weight:600" ><?php echo $row['email'] ?></label>            
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
           						<label for="edit-mail">Contact No: <span class="form-required" title="This field is required.">*</span> </label>
                                <input  style="width:250px" name="contact_no" id="contact_no" value="<?php echo $row['contact_no'] ?>"  class="form-text required fluid" type="number">
                            </td>
                            <td>
                            	<label for="edit-mail">Post Code: <span class="form-required" title="This field is required.">*</span> </label>
                                <input  style="width:250px" name="post_code" id="post_code" value="<?php echo $row['post_code'] ?>"  class="form-text required fluid" type="text">
                            </td>
                        </tr>
                        <tr>
                        	<td>
                            	<label for="edit-mail">Address 1: <span class="form-required" title="This field is required.">*</span> </label>
                                <input  style="width:250px" name="add_1" id="add_1" value="<?php echo $row['add_1'] ?>"  class="form-text required fluid" type="text">
                            </td>
                            <td>
                            	<label for="edit-mail">Address 2: </label>
                                <input  style="width:250px" name="add_2" id="add_2" value="<?php echo $row['add_2'] ?>"  class="form-text required fluid" type="text">
                            </td>  
                        </tr>
                        <tr>
                        	<td>
           						<label for="edit-mail">City: <span class="form-required" title="This field is required.">*</span> </label>
                                <input  style="width:250px" name="city" id="city" value="<?php echo $row['city'] ?>"  class="form-text required fluid" type="text">
                            </td>
                            <td>
           						<label for="edit-mail">Status: <span class="form-required" title="This field is required.">*</span> </label>
                                <select class="form-select" id="status" name="status"> 
                                <?php
								$status_arry = array(
									'1' => 'Active',										
									'0' => 'In-Active'																														
								);
								foreach ($status_arry as $v=>&$k)
								{
									if ($v == $row['status'])
											echo ("<OPTION VALUE='$v' SELECTED>".$k."</OPTION>");
									else
										echo ("<OPTION VALUE='$v'>".$k."</OPTION>");
								}
								
								?>
                                 </select>
                            </td>  
                        </tr>
                    </table>
				  	</div>
					</div>
				</fieldset>

		<table  style="border:0;" width="100%" >
        	<tr style="background-color:#CCC" >


                <td align="right" style="height:40px;vertical-align:middle" colspan="2">
                <input name="b1" id="b1" value="Save" class="form-submit"  onClick="form_submit()" type="button">&nbsp;

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





</table>
<?php
	}
}
?>
<script>
function form_submit()
{
	if(document.getElementById('first_name').value=="")
		alert("Please enter First Name");
	else if(document.getElementById('last_name').value=="")
		alert("Please enter Last Name");
	else if(document.getElementById('contact_no').value=="")
		alert("Please enter Contact no");
	else if(document.getElementById('post_code').value=="")
		alert("Please enter post code");
	else if(document.getElementById('add_1').value=="")
		alert("Please enter Address 1");
	else if(document.getElementById('city').value=="")
		alert("Please enter city");
	else
	{
		document.edit_user_form.submit();
	}
}
</script>
<?php include('../main_content/footer.php'); ?> 

</body>
</html>