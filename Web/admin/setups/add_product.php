<?php 
include('../auth_admin.php'); 
if($_SESSION['ROLE_ID']!=0){
	if($permission['product']==0){
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
  
  <title>PetroFDS | Add New Product</title>
</head>


<body>

<?php  include('../main_content/header_admin.php'); ?> 
<label>&nbsp;</label>
<center><label style="font-family:Arial,Helvetica,sans-serif;font-size:25px;color:#f16445;text-align:center" >ADD NEW PRODUCT</label></center>

  <div >
  <div class="page-region" >
  <div class="page-content content-wrapper clear-block ">
  		<form AUTOCOMPLETE="off" action="save_product.php" ACCEPT-CHARSET="UTF-8" method="post" id="save_category" name="save_category" enctype="multipart/form-data">
	<table>
		<tr>
        <td>
		<div class="form form-layout-simple clear-block">
        <table>
            <tr>
                <td>        
            <div class="form form-layout-simple clear-block">
            <fieldset class=" fieldset titled sindh" style="background-color:#9C3">
              <legend><span class="fieldset-title">MENU DETAILS <span class="form-required" title="This field is required.">*</span></span></legend>
              <div class="fieldset-content clear-block ">
                    <div class="form-item form-item-labeled" id="edit-mail-wrapper">
                <table>
                    <tr>
                        <td width="10%">
                        	<input type="hidden" name="cate_status" id="cate_status" value="new" />
                            <label style="line-height:5.5em;">ID:</label>
                        </td>
                        <td width="30%">
                            <label>Name: </label> <input type="text" name="name_menu" id="name_menu" required class="form-text required fluid" />
                        </td>
                        <td width="30%">
                        	<label>Status: </label> <select class="form-select" name="status_menu" required><option value=""></option><option value="1">Active</option><option value="0">Inactive</option></select>
                        </td>
                        <td width="30%">
                        	<label>Select Category: </label> <select class="form-select" name="cate_menu" id="cate_menu"><option value=""></option><option value="1">Active</option><option value="0">Inactive</option></select>
                        </td>
                    </tr>
                </table>
                <table>
                	<tr>
                    	<td>
                    		<label>Description</label> <textarea name="description" id="description" rows="10" class="span12"></textarea>
                        </td>
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
                <div class="form form-layout-simple clear-block">
            <fieldset class=" fieldset titled sindh" style="background-color:#9C3">
              <legend><span class="fieldset-title">PRICE AND IMAGES<span class="form-required" title="This field is required.">*</span></span></legend>
              <div class="fieldset-content clear-block ">
                    <div class="form-item form-item-labeled" id="edit-mail-wrapper">
                <table>
                    <tr>
                        <td>
                            <label>Price: </label> <input type="text" name="price_menu" id="price_menu" required class="form-text required fluid" />
                        </td>
                        <td>
                        	<label>Featured Product: </label> <select class="form-select" name="featured_menu" required><option value=""></option><option value="1">Yes</option><option value="0">No</option></select>
                        </td>
                        <td>
                        	<label>Required Options: </label> <select class="form-select" name="required_options" required><option value=""></option><option value="1">Yes</option><option value="0">No</option></select>
                        </td>
                    </tr>
                </table>
                <table>
                	<tr>
                    	<td>
                            <label>Upload Product Image: </label>
                            <table>
                            <tr>
                            <td width="7%">
                            <div id="btnupload" class="fileUpload form-submit">
                            <span>BROWSE</span>
                            <input name="image" id="uploadBtn" type="file" class="upload" />
                            
                            </div>
                            </td>
                            <td width="91%">
                            <label id="uploadFile">
                            CHOOSE FILE
                            </label>
                            </td>
                            </tr>
                            </table>
                        </td>
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
                <div class="form form-layout-simple clear-block">
            <fieldset class=" fieldset titled sindh" style="background-color:#9C3">
              <legend><span class="fieldset-title">CUSTOM OPTIONS<span class="form-required" title="This field is required.">*</span></span></legend>
              <div class="fieldset-content clear-block ">
                    <div class="form-item form-item-labeled" id="edit-mail-wrapper">
                <table id="Opt_custom_Line">
                    <tr>
                        <td width="20%">
                        	<label>Title:</label>
                        </td>
                        <td width="20%">
                        	<label>Price:</label>
                        </td>
                        <td width="20%">
                        	<label>Custom Options:</label>
                        </td>
                    </tr>
                </table>
                <table>
                	<tr>
                    	<td>
                        	<input name="CustomLine" id="CustomLine" value="Add New Row" class="form-submit" type="button" onClick="insertCustomLine(0)">
                        </td>
                    </tr>
                </table>
                </div>
                </div>
            </fieldset>
            </div>
                </td>
            </tr>
            <tr>
            <tr>
            	<td>
                <div class="form form-layout-simple clear-block">
            <fieldset class=" fieldset titled sindh" style="background-color:#9C3">
              <legend><span class="fieldset-title">CUSTOM OPTIONS WITH TYPE<span class="form-required" title="This field is required.">*</span></span></legend>
              <div class="fieldset-content clear-block ">
                    <div class="form-item form-item-labeled" id="edit-mail-wrapper">
                <table>
                    <tr>
                        <td>
                        	<label>Select Options:</label>
                        </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td>
                        	<?php
							$i = 0;
							
                        	$stmt = $conn->prepare("SELECT * FROM `option_type` WHERE status=1");

                            $stmt->execute();
                        
                            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            
                            if($rows){
                                foreach($rows as $row){
									$i++;
									$HTML = '';
									$HTML .= '<input type="hidden" id="option'.$i.'" value="0" />';
									$HTML .= '<label class="checkbox" style="margin-left:20px;"><input type="checkbox" name="option_check[]" id="option_check'.$i.'" value="0" onclick="check_click(\''.$i.'\',\'option\',\''.$row['id'].'\')" />'.$row['type'].'</label>';
									echo $HTML;
								}
							}
							?>
                        </td>
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
                <div class="form form-layout-simple clear-block">
            <fieldset class=" fieldset titled sindh" style="background-color:#9C3">
              <legend><span class="fieldset-title">CUSTOM OPTIONS WITH NO TYPE<span class="form-required" title="This field is required.">*</span></span></legend>
              <div class="fieldset-content clear-block ">
                    <div class="form-item form-item-labeled" id="edit-mail-wrapper">
                <table>
                    <tr>
                        <td>
                        	<label></label>
                        </td>
                    </tr>
                </table>
                <table id="Opt_menu_Line">
                    <tr>
                    	
                    </tr>
                </table>
                <table>
                	<tr>
                    	<td>
                        	<input name="addOptLine" id="addOptLine" value="Add New Row" class="form-submit" type="button" onClick="insertMenuOptLine(0)">
                        </td>
                    </tr>
                </table>
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

                <input type="submit" class="form-submit" value="Save" style="margin-right:5px;" />
                </td>
            </tr>
        </table>
        </div>
    </td>
    </tr>
    </table>
		</form>
	</div>
</div>
</div>

<?php include('../main_content/footer.php'); ?> 
</body>
<script type="text/javascript" src="../js/petrojs-1.0.0.min.js"></script>
<script type="text/javascript" src="../js/menu_option.js"></script>
</html>