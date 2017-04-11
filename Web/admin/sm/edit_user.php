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

  <title>PetroFDS | Edit User</title>
</head>


<body>

<?php  include('../main_content/header_admin.php'); ?> 

<?php
	
	$u_id = $_GET['id'];
	
	$stmt = $conn->prepare("SELECT * FROM `admin` WHERE id='".$u_id."'");

	$stmt->execute();

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	$stmt_role = $conn->prepare("SELECT * FROM `roles` WHERE status=1");

	$stmt_role->execute();

	$rows_role = $stmt_role->fetchAll(PDO::FETCH_ASSOC);
	
if($rows){
	foreach($rows as $row){
?>
<table class="sindh" cellpadding="0" cellspacing="0" style="background-image:url('')">
<tr>
	<td>
<label>&nbsp;</label>
<center><label style="font-family:Arial,Helvetica,sans-serif;font-size:25px;color:#f16445;text-align:center" >EDIT USER</label></center>

    </td>
</tr>
<tr >
<td >
<div id="page"   style="left:0px; right: 0px; margin-left:90px; padding:0px;" >
	<div class="limiter clear-block">
  	  <div id="content" ><div class="page-region"  >
    	<div class="page-content content-wrapper clear-block" style="width:600px;"  >
        
        	<form  onsubmit='return false;' autocomplete="off" action="save_edit_user.php" accept-charset="UTF-8" method="post" id="edit_user_form" name="edit_user_form" enctype="multipart/form-data">
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
           						<label for="edit-mail">Username: </label>
		                        <label  style="color:#000;font-size:14px;font-weight:600" ><?php echo $row['username'] ?></label>            
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
           						<label for="edit-mail">Email: <span class="form-required" title="This field is required.">*</span> </label>
                                <input maxlength="150" style="width:250px" name="email" id="email" value="<?php echo $row['email'] ?>"  class="form-text required fluid" type="text">

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
                        <tr>
                        	<td>
           						<label for="edit-mail">Role: <span class="form-required" title="This field is required.">*</span> </label>
                                <?php
								if($row['role_id']==0){
								?>
                                <label  style="color:#000;font-size:14px;font-weight:600" >ADMIN <span style="font-size:8px">No User Able to Change the ADMIN Role.</span></label>
                                <?php
								}else{
								?>
                                <select  class="form-select" id="role_id" name="role_id"> 
                                <option value=""></option>
                                <?php
								if($rows_role){
									foreach($rows_role as $row_role){
										if ($row_role['role_id'] == $row['role_id'])
											echo ("<OPTION VALUE='".$row_role['role_id']."' SELECTED>".$row_role['role_name']."</OPTION>");
										else
											echo ("<OPTION VALUE='".$row_role['role_id']."'>".$row_role['role_name']."</OPTION>");
									}
								}
								?>
                                </select>
                                <?php
								}
								?>
                            </td>  
                        </tr>
						<tr> 
                        	<td width="158">
           						<label for="edit-mail">Last Login: </label>
		                        <label style="color:#000;font-size:14px;font-weight:600" ><?php echo $row['last_login'] ?></label>            
                            </td>
                            <td width="158">
           						<label for="edit-mail">Last IP: </label>
		                        <label style="color:#000;font-size:14px;font-weight:600" ><?php echo $row['last_ip'] ?></label>            
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
	else if(document.getElementById('role_id').value=="")
		alert("Please Select User Role");
	else if(document.getElementById('email').value=="")
		alert("Please enter E-mail");
	else if ( /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.getElementById('email').value) === false ) 
		alert("Invalid E-mail Address! Please re-enter.");
	else
	{
		document.edit_user_form.submit();
	}
}
</script>
<?php include('../main_content/footer.php'); ?> 

</body>
</html>