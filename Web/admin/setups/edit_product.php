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
  
  <title>PetroFDS | Edit Product</title>
</head>


<body>

<?php  include('../main_content/header_admin.php'); ?> 

<?php

	$menu_id = $_GET['id'];

	$stmt = $conn->prepare("SELECT * FROM `menus` WHERE id=".$menu_id."");

	$stmt->execute();

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
?>
<label>&nbsp;</label>
<center><label style="font-family:Arial,Helvetica,sans-serif;font-size:25px;color:#f16445;text-align:center" >EDIT PRODUCT</label></center>

  <div >
<?php
if($rows){
	foreach($rows as $row){
?>
  <div class="page-region" >
  <div class="page-content content-wrapper clear-block ">
  		<form AUTOCOMPLETE="off" action="save_edit_product.php" ACCEPT-CHARSET="UTF-8" method="post" id="save_category" name="save_category" enctype="multipart/form-data">
	<table>
		<tr>
        <td>
		<div class="form form-layout-simple clear-block">
        <table>
            <tr>
                <td>        
            <div class="form form-layout-simple clear-block">
            <fieldset class=" fieldset titled" style="background-color:#9C3">
              <legend><span class="fieldset-title">MENU DETAILS <span class="form-required" title="This field is required.">*</span></span></legend>
              <div class="fieldset-content clear-block ">
                    <div class="form-item form-item-labeled" id="edit-mail-wrapper">
                <table>
                    <tr>
                        <td width="10%">
                        	<input type="hidden" name="cate_status" id="cate_status" value="new" />
                            <input type="hidden" name="id" id="id" value="<?php echo $menu_id ?>" />
                            <label style="line-height:5.5em;">ID: <?php echo $row['id'] ?></label>
                        </td>
                        <td width="30%">
                            <label>Name: </label> <input type="text" name="name_menu" id="name_menu" required class="form-text required fluid" value="<?php echo $row['name'] ?>" />
                        </td>
                        <td width="30%">
                        	<label>Status: </label> <select class="form-select" name="status_menu" required>
                            <?php 
							echo PetroFDS::getSelect($row['status'],'Active','InActive'); 
							?>
                            </select>
                        </td>
                        <td width="30%">
                        	<label>Select Category: </label> <select class="form-select" name="cate_menu" id="cate_menu">
                            <?php 
							//echo PetroFDS::getSelect($row['status'],'Active','InActive'); 
							?>
                            </select>
                        </td>
                    </tr>
                </table>
                <table>
                	<tr>
                    	<td>
                    		<label>Description</label> <textarea name="description" id="description" rows="10" class="span12"><?php echo $row['description'] ?></textarea>
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
            <fieldset class=" fieldset titled" style="background-color:#9C3">
              <legend><span class="fieldset-title">PRICE AND IMAGES<span class="form-required" title="This field is required.">*</span></span></legend>
              <div class="fieldset-content clear-block ">
                    <div class="form-item form-item-labeled" id="edit-mail-wrapper">
                <table>
                    <tr>
                        <td>
                            <label>Price: </label> <input type="text" name="price_menu" id="price_menu" required class="form-text required fluid" value="<?php echo PetroFDS::Float_To_Decimal($row['price']) ?>" />
                        </td>
                        <td>
                        	<label>Featured Product: </label> <select class="form-select" name="featured_menu" required>
                            <?php 
							echo PetroFDS::getSelect($row['featured_product'],'Yes','No'); 
							?>
                            </select>
                        </td>
                        <td>
                        	<label>Required Options: </label> <select class="form-select" name="required_options" required>
                            <?php 
							echo PetroFDS::getSelect($row['required_options'],'Yes','No'); 
							?>
                            </select>
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
                            <?php  
							if($row['image'] != ''){
								echo $row['image'];
							}else{
							?>
                            CHOOSE FILE
                            <?php
							}
							?>
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
                <?php
				$z = -1;
				$sql_custom = 'SELECT * FROM `menu_custom_option` WHERE menu_id='.$row['id'].' AND deleted=0';
				
				$stmt_custom = $conn->prepare($sql_custom);

				$stmt_custom->execute();
			
				$rows_custom = $stmt_custom->fetchAll(PDO::FETCH_ASSOC);
				if($rows_custom){
						foreach($rows_custom as $row_custom){
							$z++;
				?>
                    <tr id="custom_line<?php echo $z ?>">
                        <td>
                        	<input type="hidden" value="<?php echo $row_custom['id'] ?>" name="custom_id[]" id="custom_id<?php echo $z ?>">
                        	<input type="text" class="form-text required fluid" name="title[]" id="title<?php echo $z ?>" value="<?php echo htmlentities($row_custom['title']) ?>" />
                        </td>
                        <td>
                        	<input type="text" class="form-text required fluid" name="price[]" id="price<?php echo $z ?>" value="<?php echo htmlentities($row_custom['price']) ?>" />
                        </td>
                        <td>
                        	<input type="hidden" value="<?php echo $row_custom['option_with_type'] ?>" name="option_cust[]" id="option_cust<?php echo $z ?>" />
                        	<?php
							$option_id = '';
							$option_id = explode(',',$row_custom['option_with_type']);
							$i = 0;
							
							$sql_cus = '
								SELECT * 
								FROM 
								(
									SELECT id, type FROM `option_type`
									WHERE 
									id IN ('.$row['id'].') AND status=1
									UNION
									SELECT id, type FROM `option_type` WHERE status=1  
								) `option_type` GROUP BY id
							';
							
							$stmt_cus = $conn->prepare($sql_cus);

							$stmt_cus->execute();
						
							$rows_cus = $stmt_cus->fetchAll(PDO::FETCH_ASSOC);
							if($rows_cus){
									foreach($rows_cus as $row_cus){
									$i++;
									if(in_array($row_cus['id'], $option_id)){
									$HTML = '';
									$HTML .= '<input type="hidden" id="option_custom_'.$i.'_'.$z.'" value="'.$row_cus['id'].'" name="option_custom_'.$i.'_'.$z.'[]" />';
									$HTML .= '<label class="checkbox" style="margin-left:20px;"><input type="checkbox" checked="checked" name="option_custom_check[]" id="option_custom_check_'.$i.'_'.$z.'" value="0" onclick="check_click_custom(\''.$z.'\',\''.$i.'\',\'option_custom\',\''.$row_cus['id'].'\')" />'.$row_cus['type'].'</label>';
									echo $HTML;
									}else{
									$HTML = '';
									$HTML .= '<input type="hidden" id="option_custom_'.$i.'_'.$z.'" value="0" />';
									$HTML .= '<label class="checkbox" style="margin-left:20px;"><input type="checkbox" name="option_custom_check[]" id="option_custom_check_'.$i.'_'.$z.'" value="0" onclick="check_click_custom(\''.$z.'\',\''.$i.'\',\'option_custom\',\''.$row_cus['id'].'\')" />'.$row_cus['type'].'</label>';
									echo $HTML;
									}
									}
							}
							?>
                        </td>
                        <td>
                        	<?php
							$RMVBUTTON = "";
							$RMVBUTTON .= "<input type='hidden' id='opt_deleted$z' name='opt_deleted[]' value='0'/>";
							$RMVBUTTON .= "<input class='form-submit' type='button' value='Remove Row' onClick='markCustomLineDeleted($z)'/>";
							echo $RMVBUTTON;
							?>
                        </td>
                    </tr>
                <?php
						}
				}
				?>
                </table>
                <table>
                	<tr>
                    	<td>
                        	<input name="CustomLine" id="CustomLine" value="Add New Row" class="form-submit" type="button" onClick="insertCustomLine(<?php echo $z+1 ?>)">
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
            <fieldset class=" fieldset titled" style="background-color:#9C3">
              <legend><span class="fieldset-title">CUSTOM OPTIONS WITH TYPE<span class="form-required" title="This field is required.">*</span></span></legend>
              <div class="fieldset-content clear-block ">
                    <div class="form-item form-item-labeled" id="edit-mail-wrapper">
                <table>

                    <tr>
                        <td>
                        	<label>Select Options</label>
                        </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td>
                        	<?php
							$option_id = '';
							$option_id = explode(',',$row['options_with_type']);
							$i = 0;
							
							$sql_2 = '
								SELECT * 
								FROM 
								(
									SELECT id, type FROM `option_type`
									WHERE 
									id IN ('.$row['id'].') AND status=1
									UNION
									SELECT id, type FROM `option_type` WHERE status=1  
								) `option_type` GROUP BY id
							';
							
							$stmt_2 = $conn->prepare($sql_2);

							$stmt_2->execute();
						
							$rows_2 = $stmt_2->fetchAll(PDO::FETCH_ASSOC);
							if($rows_2){
									foreach($rows_2 as $row_2){
									$i++;
									if(in_array($row_2['id'], $option_id)){
									$HTML = '';
									$HTML .= '<input type="hidden" id="option'.$i.'" value="'.$row_2['id'].'" name="option[]" />';
									$HTML .= '<label class="checkbox" style="margin-left:20px;"><input type="checkbox" checked="checked" name="option_check[]" id="option_check'.$i.'" value="0" onclick="check_click(\''.$i.'\',\'option\',\''.$row_2['id'].'\')" />'.$row_2['type'].'</label>';
									echo $HTML;
									}else{
									$HTML = '';
									$HTML .= '<input type="hidden" id="option'.$i.'" value="0" />';
									$HTML .= '<label class="checkbox" style="margin-left:20px;"><input type="checkbox" name="option_check[]" id="option_check'.$i.'" value="0" onclick="check_click(\''.$i.'\',\'option\',\''.$row_2['id'].'\')" />'.$row_2['type'].'</label>';
									echo $HTML;
									}
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
				<?php
					$s=-1;
                    $stmt_o = $conn->prepare("SELECT * FROM `menu_option_type_no` WHERE deleted=0 AND menu_id='".$menu_id."'");

                    $stmt_o->execute();
                
                    $rows_o = $stmt_o->fetchAll(PDO::FETCH_ASSOC);
                    
                    if($rows_o){
                        foreach($rows_o as $row_o){
							$s++;
                        ?>
                        <tr id="opt_menu_line<?php echo $s ?>">
                    	<td>
                        	<input type="hidden" value="<?php echo $row_o['id'] ?>" name="line_id[]" id="line_id" />
                        	<input type="text" name="name[]" value="<?php echo htmlentities($row_o['name']) ?>" id="name" class="form-text required fluid" />
                        </td>
                        <td>
                        	<?php
							$HTML = '';
							$HTML .= '<select name="option_no_type[]" id="option_no_type'.$s.'" class="form-select">';
							$HTML .= '<option value=""></option>';
							
                        	$stmt = $conn->prepare("SELECT * FROM `option` WHERE status=1 AND is_yes_no=0 AND type_id=0");

                            $stmt->execute();
                        
                            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            
                            if($rows){
                                foreach($rows as $row){
									if($row_o['option_id'] == $row['id']){
										$HTML .= '<option selected="selected" value="'.$row['id'].'">'.$row['title'].'</option>';
									}else{
										$HTML .= '<option value="'.$row['id'].'">'.$row['title'].'</option>';
									}
								}
							}
							$HTML .= '</select>';
							echo $HTML;
							?>
                        </td>
                        <td>
                        	<?php
							$RMVBUTTON = "";
							$RMVBUTTON .= "<input type='hidden' id='opt_menu_deleted$s' name='opt_menu_deleted[]' value='0'/>";
							$RMVBUTTON .= "<input class='form-submit' type='button' value='Remove Row' onClick='markOptLineDeleted($s)'/>";
							echo $RMVBUTTON;
							?>
                        </td>
                    	</tr>
                        <?php
                        }
                    }
                ?>
                </table>
                <table>
                	<tr>
                    	<td>
                        	<input name="addOptLine" id="addOptLine" value="Add New Row" class="form-submit" type="button" onClick="insertMenuOptLine(<?php echo $s+1 ?>)">
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

                <input type="submit" class="form-submit" value="Edit" style="margin-right:5px;" />
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
<?php
	}
}
?>
<?php include('../main_content/footer.php'); ?> 
</body>
<script type="text/javascript" src="../js/petrojs-1.0.0.min.js"></script>
<script type="text/javascript" src="../js/menu_option_edit.js"></script>
</html>