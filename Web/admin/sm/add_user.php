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
<script language="javascript" type="text/javascript" src="../js/user_profile.js"></script>
  <title>PetroFDS | Add User</title>
</head>


<body>

<?php  include('../main_content/header_admin.php'); ?> 

<?php
	
	$stmt = $conn->prepare("SELECT * FROM `roles` WHERE status=1");

	$stmt->execute();

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<script type="text/javascript">
  //function to create ajax object
  function pullAjax(){
    var a;
    try{
      a=new XMLHttpRequest()
    }
    catch(b)
    {
      try
      {
        a=new ActiveXObject("Msxml2.XMLHTTP")
      }catch(b)
      {
        try
        {
          a=new ActiveXObject("Microsoft.XMLHTTP")
        }
        catch(b)
        {
          alert("Your browser broke!");return false
        }
      }
    }
    return a;
  }
 
  function validate()
  {
    site_root = '';
    var x = document.getElementById('username');
    var msg = document.getElementById('msg');
    user = x.value;
    code = '';
    message = '';
    obj=pullAjax();
    obj.onreadystatechange=function()
    {
      if(obj.readyState==4)
      {
        eval("result = "+obj.responseText);
        code = result['code'];
        message = result['result'];
 
        if(code <=0)
        {
          x.style.border = "1px solid red";
          msg.style.color = "red";
        }
        else
        {
          x.style.border = "1px solid #000";
          msg.style.color = "green";
        }
        msg.innerHTML = message;
      }
    }

    obj.open("GET",site_root+"validate.php?username="+user,true);
    obj.send(null);
  }
</script>

<table class="sindh" cellpadding="0" cellspacing="0" style="background-image:url('')">
<tr>
	<td>
<label>&nbsp;</label>
<center><label style="font-family:Arial,Helvetica,sans-serif;font-size:25px;color:#f16445;text-align:center" >ADD USER</label></center>

    </td>
</tr>
<tr >
<td >
<div id="page"   style="left:0px; right: 0px; margin-left:90px; padding:0px;" >
	<div class="limiter clear-block">
  	  <div id="content" ><div class="page-region"  >
    	<div class="page-content content-wrapper clear-block" style="width:600px;"  >
        
        	<form  onsubmit='return false;' autocomplete="off" action="save_add_user.php" accept-charset="UTF-8" method="post" id="add_user_form" name="add_user_form" enctype="multipart/form-data">

			<div >
            	<div class="form form-layout-simple clear-block" >
		
        		<fieldset class=" fieldset titled">
					<legend><span class="fieldset-title">USER INFORMATION</span></legend>
					<div class="fieldset-content clear-block ">
					
                    <div class="form-item form-item-labeled" id="edit-mail-wrapper">
                    <table >
                    	<tr>
                        	<td width="216">
           						<label for="edit-mail">Username: <span class="form-required" title="This field is required.">*</span></label>
                                <input maxlength="64" style="width:200px" name="username" id="username"  class="form-text required fluid" type="text">
								<div id="msg"></div>
                            </td>
                            <td width="164">
           						<label for="edit-mail">&nbsp;</label>                            
				                <input name="user_chk" id="user_chk" value="Check Availability" class="form-submit"  onClick="validate();" type="button">&nbsp;
                            </td>
                            <td width="158">
           						<label for="edit-mail">Date Created: </label>
		                        <label  style="color:#000;font-size:14px;font-weight:600" ><?php echo date('d/m/Y') ?></label>            
                            </td>

                        </tr>
                        <tr>
                        	<td colspan="2">
                                <label for="edit-mail">Password: <span class="form-required" title="This field is required.">*</span> </label>
                                <input maxlength="64" style="width:200px" name="password" id="password"  class="form-text required fluid" type="password">

                            </td>
                            <td>
           						<label for="edit-mail">Your IP: </label>
		                        <label  style="color:#000;font-size:14px;font-weight:600" ><?php echo $_SESSION['USER_IP'] ?></label>                                        
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
                                <input maxlength="64" style="width:250px" name="first_name" id="first_name" value=""  class="form-text required fluid" type="text">

                            </td>
                            <td width="253">
           						<label for="edit-mail">Last Name: <span class="form-required" title="This field is required.">*</span></label>
                                <input maxlength="64" style="width:250px" name="last_name" id="last_name" value=""  class="form-text required fluid" type="text">
                            </td>

                        </tr>
                        <tr>
                        	<td>
           						<label for="edit-mail">Email: <span class="form-required" title="This field is required.">*</span> </label>
                                <input  style="width:250px" name="email" id="email" value=""  class="form-text required fluid" type="text">

                            </td>
                            <td>
           						<label for="edit-mail">Status: <span class="form-required" title="This field is required.">*</span> </label>
                                <select required class="form-select" id="status" name="status"> 
                                <option value="1">Active</option>
                                <option value="0">InActive</option>
                                 </select>
                            </td>  
                        </tr>
                        <tr>
                        	<td>
           						<label for="edit-mail">Role: <span class="form-required" title="This field is required.">*</span> </label>
                                <select  class="form-select" id="role_id" name="role_id"> 
                                <option value=""></option>
                                <?php
								if($rows){
									foreach($rows as $row){
								?>
                                	<option value="<?php echo $row['role_id'] ?>"><?php echo $row['role_name'] ?></option>
                                <?php
									}
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
<script>
function form_submit()
{
	if(document.getElementById('username').value=="")
		alert("Please enter User Name");
	else if(document.getElementById('password').value=="")
		alert("Please enter Password");
	else if(document.getElementById('first_name').value=="")
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
		document.add_user_form.submit();
	}
}
</script>
<?php include('../main_content/footer.php'); ?> 

</body>
</html>