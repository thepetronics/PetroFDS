<?php 
include('../auth_admin.php'); 
if($_SESSION['ROLE_ID']!=0){
	if($permission['options']==0){
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
  
  <link rel="stylesheet" type="text/css" href="../css/layout.css" />
  <link rel="stylesheet" type="text/css" href="../css/layout-responsive.css" />
  
  <title>PetroFDS | Add New Option</title>
</head>


<body>

<?php  include('../main_content/header_admin.php'); ?> 
<label>&nbsp;</label>
<center><label style="font-family:Arial,Helvetica,sans-serif;font-size:25px;color:#f16445;text-align:center" >ADD NEW OPTION</label></center>

  <div >
  <div class="page-region" >
  <div class="page-content content-wrapper clear-block ">
  		<form AUTOCOMPLETE="off" action="save_option.php" onSubmit="return validateForm()" ACCEPT-CHARSET="UTF-8" method="post" id="option_form" name="option_form" enctype="multipart/form-data">

	<table width="100%">
       <tr>
       		<td width="50%">
		<div class="form form-layout-simple clear-block">
		<fieldset class=" fieldset titled sindh" style="background-color:#9C3">
	      <legend><span class="fieldset-title" id='adp_title'>CUSTOM OPTIONS</span></legend>
    	  <div class="fieldset-content clear-block ">
                <div class="form-item form-item-labeled" id="edit-mail-wrapper">
            <table>
                <tr>
                	<td >
                    <label id="opt_id">Option ID:</label>
                    </td>
                    <td >
                    <label id="opt_title">Title:</label>
                    </td>
                    <td >
                    <label for="opt_type">Type:</label>
                    </td>
                    <td>
                    <label for="input_type">Input Type:</label>
                    </td>
                </tr>
              <tr>
              		<td>
                    	<label><?php echo uniqid() ?></label>
                        <input type="hidden" name="option_id" id="option_id" value="<?php echo uniqid() ?>" class='form-text required fluid' />
                    </td>
              		<td>
                    	<input type="text" name="title_first" id="title_first" required class='form-text required fluid' />
                    </td>
                    <td>
                    	<select name="opt_type" id="opt_type" class='form-select' onChange="opt_type_change()"></select>
                        <label id="opt_type_validate" style="color:#F00"></label>
                    </td>
                    <td>
                    	<select name="input_type" id="input_type" required class='form-select'>
                        <option value=""></option>
                        <option value="dropdown">Dropdown</option>
                        <option value="checkbox">Checkbox</option>
                        </select>
                    </td>
              </tr>
              
              <tr>
                    <td >
                    <label for="opt_yes_no">Is Yes/No:</label>
                    </td>
                    <td >
                    <label for="opt_price">Price:</label>
                    </td>
                    <td >
                    <label for="opt_status">Status:</label>
                    </td>
                    <td >
                        <label for="edit-mail">&nbsp;</label>
                    </td>
              </tr>
              
              <tr>
                    <td>
                    	<select name="is_yes_no" id="is_yes_no" onChange="is_yes_no_check(this)" required class='form-select'>
                        <option value=""></option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                        </select>
                    </td>
                    <td>
                    	<input type="text" value="0" name="price_option" class='form-text required fluid' id="price_option" required="" />
                    </td>
                    <td>
                    	<select name="status" id="status" required class='form-select'>
                        <option value=""></option>
                        <option value="1">Active</option>
                        <option value="0">InActive</option>
                        </select>
                    </td>
              </tr>
           </table>
           <div style="display:none;" id="option_val_line">
			<table id="OptLine">
                <tr>
                	<td >
                    <label id="opt_title">Title:</label>
                    </td>
                    <td >
                    <label for="opt_price">Price:</label>
                    </td>
                    <td >
                    <label for="opt_sort">Sort:</label>
                    </td>
	                <td >
	                    <label for="edit-mail">&nbsp;</label>
                    </td>
              	</tr>
           </table>
           <table>
           	<tr>
            	<td>
    			<input name="addOptLine" id="addOptLine" value="Add New Option" class="form-submit" type="button" onClick="insertOptLine(0)">
                </td>
            </tr>
           </table>
           </div>
			</div>
            </div>
		</fieldset>
	    </div>
            </td>
      </tr>
   </table>

    <table  style="border:1px solid #CCC;" width="100%" >
        <tr>
  
            <td align="right" style="height:40px;vertical-align:middle" colspan="2">
  
            	<input value="Save" class="form-submit" type="submit" style="margin-right:5px;" />
            </td>
        </tr>
    </table>
		</form>
</div>
</div>

<?php include('../main_content/footer.php'); ?> 
<script type="text/javascript" src="../js/petrojs-1.0.0.min.js"></script>
<script type="text/javascript" src="../js/option.js"></script>
<script type="text/javascript">
function validateForm(){
	var x=document.forms["option_form"]["is_yes_no"].value;
	if (x==null || x=="")
	  {
	  	$petrojs('#opt_type_validate').html('Please Select a value from a dropdown');
		setTimeout(function() {
			$petrojs('#opt_type_validate').html('');
		}, 5000);
	  	return false;
	  }
}
</script>
</body>
</html>