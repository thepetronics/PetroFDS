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

  <title>PetroFDS | Add Permission</title>
</head>


<body>

<?php  include('../main_content/header_admin.php'); ?> 

<?php

	$qry_role="SELECT * FROM roles WHERE STATUS='1' ORDER BY role_name";
	
	$stmt_role = $conn->prepare($qry_role);

	$stmt_role->execute();

	$rows_role = $stmt_role->fetchAll(PDO::FETCH_ASSOC);
	if($_POST){
	$r_id = $_POST['role_id'];

	$qry_perm="SELECT * FROM permissions WHERE role_id='$r_id'";
	
	$stmt_perm = $conn->prepare($qry_perm);

	$stmt_perm->execute();

	$rows_perm = $stmt_perm->fetchAll(PDO::FETCH_ASSOC);	
	}
?>
<label>&nbsp;</label>
<center><label style="font-family:Arial,Helvetica,sans-serif;font-size:25px;color:#f16445;text-align:center" >ADD PERMISSION</label></center>
  <div >
  <div class="page-region" >
  <div class="page-content content-wrapper clear-block ">
  		<form  onsubmit='return false;' autocomplete="off" action="save_add_permission.php" accept-charset="UTF-8" method="post" id="add_perm_form" name="add_perm_form" enctype="multipart/form-data">

	<table width="100%">
	<tr>
   		<td width="50%">
       	<div class="form form-layout-simple clear-block" >
		
        		<fieldset class=" fieldset titled">
					<legend><span class="fieldset-title">PERMISSION INFORMATION</span></legend>
					<div class="fieldset-content clear-block ">
					
                    <div class="form-item form-item-labeled" id="edit-mail-wrapper">
                    <table >
                    	<tr>
                        	<td width="216">
           						<label>Permission ID: </label>
                                <?php
                                if(isset($rows_perm)){
	  							foreach($rows_perm as $row_perm){
								?>
		                        <label id="perm_id" style="color:#000;font-size:14px;font-weight:600" ><?php echo $row_perm['permission_id'] ?></label>     
                                <input type="hidden" id="permission_id" name="permission_id" value="<?php echo $row_perm['permission_id'] ?>" />       
                                <?php
								}
								}else{
								?>
                                <label id="perm_id" style="color:#000;font-size:14px;font-weight:600" ></label>
                                <?php
								}
								?>
                            </td>
                            <td width="164">
           						<label>Your IP: </label>
		                        <label  style="color:#000;font-size:14px;font-weight:600" ><?php echo $_SESSION['USER_IP'] ?></label>            
                            </td>
                            <td width="158">
           						<label>Date Created: </label>
		                        <label  style="color:#000;font-size:14px;font-weight:600" ><?php echo date('d/m/Y') ?></label>            
                            </td>

                        </tr>
                        <tr>
                        	<td colspan="3">

                                <label for="edit-mail">Select Role: <span class="form-required" title="This field is required.">*</span> </label>

                                <SELECT id='role_id' name='role_id' class="form-select" onChange="role_get()"> 
                                <?php
									
									echo ("<option value='' SELECTED></option>");		
									if(isset($rows_role)){
									foreach($rows_role as $row_role){
										if(isset($r_id)){
										if ($row_role['role_id']==$r_id)
											echo ("<option value='".$row_role['role_id']."' selected='selected'>".$row_role['role_name']."</option>");
										else
											echo ("<option value='".$row_role['role_id']."'>".$row_role['role_name']."</option>");
										}else{
											echo ("<option value='".$row_role['role_id']."'>".$row_role['role_name']."</option>");
										}
									}
									}
								
								?>
                                </SELECT>

                            </td>
                        </tr>
                    </table>	
				  	</div>
					</div>
				</fieldset>
			</div>
		<?php
  		if(isset($rows_perm)){
	  	foreach($rows_perm as $row_perm){
  		?>
			<?php
			if ($r_id !="")
			{
			?>
            
 
            <div class="form form-layout-simple clear-block">
            <fieldset class=" fieldset titled sindh" style="background-color:#9C3">
              <legend><span class="fieldset-title">PERMISSIONS FOR SYSTEM TOOLS</span></legend>
              <div class="fieldset-content clear-block ">
                    <div class="form-item form-item-labeled" id="edit-mail-wrapper">
                <table >	
                    <tr>
                        <td>
                         <label><input name="user_management" id="user_management" value="1" <?php if($row_perm['user_management']==1) echo "checked" ?> class="form-text required fluid" type="checkbox"> User Management</label>
                        </td>
                        <td>
                         <label><input name="system_config" id="system_config" value="1" <?php if($row_perm['system_config']==1) echo "checked" ?> class="form-text required fluid" type="checkbox"> System Configuration</label>
                        </td>
    					<td>
                         <label><input name="email_setups" id="email_setups" value="1" <?php if($row_perm['email_setups']==1) echo "checked" ?> class="form-text required fluid" type="checkbox"> Email Setups</label>
                        </td>
                    </tr>
                    <tr>
                    	<td>
                         <label><input name="roles_management" id="roles_management" value="1" <?php if($row_perm['roles_management']==1) echo "checked" ?> class="form-text required fluid" type="checkbox"> Roles Management</label>
                        </td>
                    	<td>
                         <label><input name="frontend_user_management" id="frontend_user_management" value="1" <?php if($row_perm['frontend_user_management']==1) echo "checked" ?> class="form-text required fluid" type="checkbox"> Frontend User Management</label>
                        </td>
                        <td>
                         <label><input name="mobile_setups" id="mobile_setups" value="1" <?php if($row_perm['mobile_setups']==1) echo "checked" ?> class="form-text required fluid" type="checkbox"> Mobile App Setting</label>
                        </td>
                    </tr>
                    <tr><td><p></td>
                    </tr>
                </table>
                </div>
                </div>
            </fieldset>
            </div>
           
            
            <?php
			}
			?>
            </td>



           <?php 
		   if ($r_id !="")
		   {
		    ?>
	       <td width="50%">

		<div class="form form-layout-simple clear-block">
		<fieldset class=" fieldset titled sindh" style="background-color:#9C3">
	      <legend><span class="fieldset-title">PERMISSIONS</span></legend>
    	  <div class="fieldset-content clear-block ">
                <div class="form-item form-item-labeled" id="edit-mail-wrapper">
			<table >	
                <tr>
                	
                    <td>
                    <label for="edit-mail" style="color:#00F">Permission = For Products</label>
                    <label><input name="category" id="category" value="1" <?php if($row_perm['category']==1) echo "checked" ?> class="form-text required fluid" type="checkbox"> Category</label>
                    </td>
                    <td>
                    <label for="edit-mail" style="color:#00F">&nbsp;</label>
                    <label><input name="product" id="product" value="1" <?php if($row_perm['product']==1) echo "checked" ?> class="form-text required fluid" type="checkbox"> Product</label>
                    </td>

                </tr>
				<tr><td><p></td>
                </tr>
                <tr>
                    <td>                    
                     <label for="edit-mail" style="color:#00F">Permission = For Options</label>
                     <label><input name="options" id="options" value="1" <?php if($row_perm['options']==1) echo "checked" ?>  class="form-text required fluid" type="checkbox"> Options</label>
                    </td>
                    <td>    
                     <label for="edit-mail" style="color:#00F">&nbsp;</label>                                 
                     <label><input name="optiontype" id="optiontype" value="1" <?php if($row_perm['optiontype']==1) echo "checked" ?> class="form-text required fluid" type="checkbox"> Option Type</label>
                    </td>
                    
                </tr>
				<tr><td><p></td>
                </tr>
                <tr>
                    <td>
                     <label for="edit-mail" style="color:#00F">Permission = For Order</label>
                     <label><input name="orders" id="orders" value="1" <?php if($row_perm['orders']==1) echo "checked" ?> class="form-text required fluid" type="checkbox"> Orders</label>
                    </td>
                    <td>
                    <label for="edit-mail" style="color:#00F">&nbsp;</label>
                    <label><input name="loyaltypoint" id="loyaltypoint" value="1" <?php if($row_perm['loyaltypoint']==1) echo "checked" ?> class="form-text required fluid" type="checkbox"> Loyalty Point</label>
                    </td>
                </tr>
                <tr>
                	<td>
                     <label><input name="couponcode" id="couponcode" value="1" <?php if($row_perm['couponcode']==1) echo "checked" ?> class="form-text required fluid" type="checkbox"> Coupon Code</label>
                    </td>
                </tr>
                <tr>
                    <td>
           			<label for="edit-mail" style="color:#00F">Permission = For Delivery</label>                    
                    <label><input name="postcode" id="postcode" value="1" <?php if($row_perm['postcode']==1) echo "checked" ?> class="form-text required fluid" type="checkbox"> Post Code</label>
                    </td>
                </tr>
				<tr><td><p></td>
                </tr>
            </table>
			</div>
            </div>
		</fieldset>
	    </div>
		</td>

           </tr>
            <tr>
            	<td>

                </td>
            </tr>
 

            <?php  } ?>
           </table>
           <?php 
		   if ($r_id !="")
		   {
		    ?>

		<table  style="border:0;" width="100%" >
        	<tr style="background-color:#CCC" >


                <td align="right" style="height:40px;vertical-align:middle" colspan="2">
                <input name="b1" id="b1" value="Save" class="form-submit"  onClick="form_submit()" type="button">&nbsp;

                </td>
            </tr>
        </table>

		<?php } ?>                
                </div>
			</div>
			</form>
<?php
	  }
  }
?>
       </div>
    </div>
  </div>
</div>
</div>
<script>
function role_get()
{
	document.forms['add_perm_form'].action='add_permission';
	document.forms['add_perm_form'].submit();
}
function form_submit()
{
	document.forms['add_perm_form'].submit();
}
</script>
<?php include('../main_content/footer.php'); ?> 

</body>
</html>