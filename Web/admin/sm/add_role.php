<?php 
include('../auth_admin.php'); 
if($_SESSION['ROLE_ID']!=0){
	die("You don't have permission to access please contact administrator.");
}
require_once('../../app/themes/lib/system.lib.php');
$conn = PetroFDS::ConnectDB();
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<HTML>

<head>
  <meta content="text/html; charset=UTF-8" http-equiv="content-type">

  <title>PetroFDS | Add Role</title>
</head>


<body>

<?php  include('../main_content/header_admin.php'); ?> 
<table class="sindh" cellpadding="0" cellspacing="0" style="background-image:url('')">
<tr>
	<td>
<label>&nbsp;</label>
<center><label style="font-family:Arial,Helvetica,sans-serif;font-size:25px;color:#f16445;text-align:center" >ADD ROLE</label></center>

    </td>
</tr>
<tr >
<td >
<div id="page"   style="left:0px; right: 0px; margin-left:90px; padding:0px;" >
	<div class="limiter clear-block">
  	  <div id="content" ><div class="page-region"  >
    	<div class="page-content content-wrapper clear-block" style="width:600px;"  >
        
        	<form  onsubmit='return false;' autocomplete="off" action="save_add_role.php" accept-charset="UTF-8" method="post" id="add_role_form" name="add_role_form" enctype="multipart/form-data">

			<div >
            	<div class="form form-layout-simple clear-block" >
		
        		<fieldset class=" fieldset titled">
					<legend><span class="fieldset-title">ROLE INFORMATION</span></legend>
					<div class="fieldset-content clear-block ">
					
                    <div class="form-item form-item-labeled" id="edit-mail-wrapper">
                    <table >
                    	<tr>
                        	<td width="216">
           						<label for="edit-mail">Role ID: </label>
		                        <label  style="color:#000;font-size:14px;font-weight:600" ></label>            

                            </td>
                            <td width="164">
           						<label for="edit-mail">Your IP: </label>
		                        <label  style="color:#000;font-size:14px;font-weight:600" ><?php echo $_SESSION['USER_IP'] ?></label>            
                            </td>
                            <td width="158">
           						<label for="edit-mail">Date Created: </label>
		                        <label  style="color:#000;font-size:14px;font-weight:600" ><?php echo date('d/m/Y') ?></label>            
                            </td>

                        </tr>
                        <tr>
                        	<td colspan="2">
                                <label for="edit-mail">Role Name: <span class="form-required" title="This field is required.">*</span> </label>
                                <input maxlength="64" style="width:380px" name="role_name" id="role_name"  class="form-text required fluid" type="text">

                            </td>
							<td>
           						<label for="edit-mail">Status: <span class="form-required" title="This field is required.">*</span> </label>
                                <select class="form-select" id="status" name="status"> 
                                <option value="1">Active</option>
                                <option value="0">In-Active</option>
                                 </select>

                            
                            </td>                        
                            
                        </tr>
						<tr>
                        	<td colspan="3">
                                <label for="edit-mail">Description: </label>                            	
                                <textarea name="description" id="description" class="form-required" cols="86" rows="6"></textarea>
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
<script>
function form_submit()
{
	if(document.getElementById('role_name').value=="")
		alert("Please enter Role Name");
	else
	{
		document.add_role_form.submit();
	}
}
</script>
<?php include('../main_content/footer.php'); ?> 

</body>
</html>