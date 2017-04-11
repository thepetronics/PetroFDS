<?php 

include('../auth_admin.php'); 

if($_SESSION['ROLE_ID']!=0){

	if($permission['system_config']==0){

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

  

  <title>PetroFDS | System Configuration</title>

</head>





<body>



<?php  include('../main_content/header_admin.php'); ?> 

<label>&nbsp;</label>

<?php
$sql='SELECT * FROM `system_config` WHERE status=1';

$stmt = $conn->prepare($sql);



$stmt->execute();

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if($rows){

	foreach($rows as $row){

?>

<center><label style="font-family:Arial,Helvetica,sans-serif;font-size:25px;color:#f16445;text-align:center" >EDIT SYSTEM CONFIGURATION</label></center>



  <div >

  <div class="page-region" >

  <div class="page-content content-wrapper clear-block ">

  		<form AUTOCOMPLETE="off" action="system_config_set.php" ACCEPT-CHARSET="UTF-8" method="post" id="save_coupon_code" name="save_coupon_code" enctype="multipart/form-data" onSubmit="return validateForm()">

	<table>

		<tr>

        <td>

		<div class="form form-layout-simple clear-block">

        <table>

            <tr>

                <td>        

            <div class="form form-layout-simple clear-block">

            <fieldset class=" fieldset titled sindh" style="background-color:#9C3">

              <legend><span class="fieldset-title">SYSTEM CONFIGURATION <span class="form-required" title="This field is required.">*</span></span></legend>

              <div class="fieldset-content clear-block ">

                    <div class="form-item form-item-labeled" id="edit-mail-wrapper">

                <table id="DaysLine_row">

                    <tr>

                        <td>

                        	<input type="hidden" name="cate_status" id="cate_status" value="edit" />

                            <input type="hidden" name="id" id="id" value="<?php echo $row['id'] ?>" />

                            <label>ID: <?php echo $row['id'] ?></label>

                        </td>

                    </tr>

                    <tr>

                        <td width="20%">

                            <label>Website Title: </label> <input type="text" name="web_title" id="web_title" value="<?php echo $row['website_title'] ?>" required class="form-text required fluid" />

                        </td>

                        <td width="20%">

                            <label>Website Path: </label> <input type="text" name="web_path" id="web_path" value="<?php echo $row['website_path'] ?>" required class="form-text required fluid" />

                        </td>

                        <td width="20%">

                            <label>Website Currency: </label> <input type="text" name="web_currency" id="web_currency" value="<?php echo $row['website_currency'] ?>" required class="form-text required fluid" />

                        </td>

                        <td width="10%">

                        	<?php echo '<label style="color:#00F">Old = '.$row['country_region'].'</label>'; ?>

                            <div id="zone">

                            </div>

    					</td>

                    </tr>

                    <tr>

                        <td width="20%">

                            <label>Store Postcode: </label> <input type="text" name="store_postcode" id="store_postcode" value="<?php echo $row['store_postcode'] ?>" required class="form-text required fluid" />

                        </td>

                        <td width="20%">

                        	<label>Status: </label> 

                            <?php

							if($row['status'] == '1'){

							?>

                           	<select required class="form-select" name="status"><option value=""></option><option value="1" selected="selected">Active</option><option value="0">Inactive</option></select>

                            <?php

							}else{

							?>

                            <select required class="form-select" name="status"><option value=""></option><option value="1">Active</option><option value="0" selected="selected">Inactive</option></select>

                            <?php

							}

							?>

                        </td>

                        <td width="20%">

                            <label>Discount: </label> <input type="text" name="price_discount" id="price_discount" value="<?php echo $row['price_discount'] ?>" required class="form-text required fluid" />

                        </td>

                    </tr>

                    <tr>

                    	<td>

                        	<label>Days: </label>

                        </td>

                        <td>

                        	<label>Website Open Time: </label>

                        </td>

                        <td>

                        	<label>Website Close Time: </label>

                        </td>

                        <td>

                        	<label>Total Hours: </label>

                        </td>

                    </tr>

<?php

$s=-1;

$sql_1='SELECT * FROM `website_open_close` WHERE system_config_id='.$row['id'].' AND deleted=0';

$stmt_1 = $conn->prepare($sql_1);



$stmt_1->execute();

$rows_1 = $stmt_1->fetchAll(PDO::FETCH_ASSOC);

if($rows_1){

	foreach($rows_1 as $row_1){

		$s++;

?>

                    <tr id="days_line<?php echo $s ?>">

                        <td>

                        	<input type="hidden" name="system_config_id[]" id="system_config_id" value="<?php echo $row['id'] ?>" />

                        	<input type="hidden" value="<?php echo $row_1['id'] ?>" name="line_id[]" id="line_id" />

                            <input type="text" name="days[]" id="days" value="<?php echo $row_1['days'] ?>" required class="form-text required fluid" />

                        </td>

                        <td>

                            <input type="text" name="open_time[]" value="<?php echo $row_1['website_open'] ?>" id="open_time" required class="form-text required fluid" placeholder="hours:minutes:seconds" />

                        </td>

                        <td>

                            <input type="text" name="close_time[]" value="<?php echo $row_1['website_close'] ?>" id="close_time" required class="form-text required fluid" placeholder="hours:minutes:seconds" />

                        </td>

                        <td>

                            <input type="text" name="total_hours[]" id="total_hours" value="<?php echo $row_1['total_hours'] ?>" required class="form-text required fluid" />

                        </td>

                        <td>

                        <?php

							$RMVBUTTON = "";

							$RMVBUTTON .= "<input type='hidden' id='opt_deleted$s' name='opt_deleted[]' value='0'/>";

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

                        	<input name="DaysLine" id="DaysLine" value="Add New Row" class="form-submit" type="button" onClick="insertDaysLine(<?php echo $s+1 ?>)">

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

				<td>

                	<div class="form-item form-item-labeled">

                    	<label id="note-bottom">if there is no discount on product so leave the field blank or enter 0.<br/>Total Hours is used to count the hours between open time and close time.<br/>Time are in 24 hours format.</label>

                    </div>

                </td>

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

<?php

	}

}else{

?>

<center><label style="font-family:Arial,Helvetica,sans-serif;font-size:25px;color:#f16445;text-align:center" >SYSTEM CONFIGURATION</label></center>



  <div >

  <div class="page-region" >

  <div class="page-content content-wrapper clear-block ">

  		<form AUTOCOMPLETE="off" action="system_config_set.php" ACCEPT-CHARSET="UTF-8" method="post" id="save_coupon_code" name="save_coupon_code" enctype="multipart/form-data">

	<table>

		<tr>

        <td>

		<div class="form form-layout-simple clear-block">

        <table>

            <tr>

                <td>        

            <div class="form form-layout-simple clear-block">

            <fieldset class=" fieldset titled sindh" style="background-color:#9C3">

              <legend><span class="fieldset-title">SYSTEM CONFIGURATION <span class="form-required" title="This field is required.">*</span></span></legend>

              <div class="fieldset-content clear-block ">

                    <div class="form-item form-item-labeled" id="edit-mail-wrapper">

                <table id="DaysLine_row">

                    <tr>

                        <td>

                        	<input type="hidden" name="cate_status" id="cate_status" value="new" />

                            <label>ID: </label>

                        </td>

                    </tr>

                    <tr>

                        <td>

                            <label>Website Title: </label> <input type="text" name="web_title" id="web_title" required class="form-text required fluid" />

                        </td>

                        <td>

                            <label>Website Path: </label> <input type="text" name="web_path" id="web_path" required class="form-text required fluid" />

                        </td>

                        <td>

                            <label>Website Currency: </label> <input type="text" name="web_currency" id="web_currency" required class="form-text required fluid" />

                        </td>

                        <td>

                        	<?php echo '<label style="color:#00F">Old = '.$row['country_region'].'</label>'; ?>

                            <div id="zone">

                            </div>

    					</td>

                    </tr>

                    <tr>

                        <td width="20%">

                            <label>Store Postcode: </label> <input type="text" name="store_postcode" id="store_postcode" required class="form-text required fluid" />

                        </td>

                        <td>

                        	<label>Status: </label> <select class="form-select" name="status" required><option value=""></option><option value="1">Active</option><option value="0">Inactive</option></select>

                        </td>

                        <td>

                            <label>Discount: </label> <input type="text" name="price_discount" id="price_discount" required class="form-text required fluid" />

                        </td>

                    </tr>

                    <tr>

                    	<td>

                        	<label>Days: </label>

                        </td>

                        <td>

                        	<label>Website Open Time: </label>

                        </td>

                        <td>

                        	<label>Website Close Time: </label>

                        </td>

                        <td>

                        	<label>Total Hours: </label>

                        </td>

                    </tr>

                    <tr>

                        <td>

                            <input type="text" name="days[]" id="days" required class="form-text required fluid" />

                        </td>

                        <td>

                            <input type="text" name="open_time[]" id="open_time" required class="form-text required fluid" placeholder="hours:minutes:seconds" />

                        </td>

                        <td>

                            <input type="text" name="close_time[]" id="close_time" required class="form-text required fluid" placeholder="hours:minutes:seconds" />

                        </td>

                        <td>

                            <input type="text" name="total_hours[]" id="total_hours" required class="form-text required fluid" />

                        </td>

                    </tr>

                </table>

                <table>

                	<tr>

                    	<td>

                        	<input name="DaysLine" id="DaysLine" value="Add New Row" class="form-submit" type="button" onClick="insertDaysLine(0)">

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

				<td>

                	<div class="form-item form-item-labeled">

                    	<label id="note-bottom">if there is no discount on product so leave the field blank or enter 0.<br/>Total Hours is used to count the hours between open time and close time.<br/>Time are in 24 hours format.</label>

                    </div>

                </td>

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

<?php

}

?>

<?php include('../main_content/footer.php'); ?>

<script type="text/javascript" src="../js/petrojs-1.0.0.min.js"></script>

<script type="text/javascript" src="../js/system_config.js"></script>

</body>

</html>