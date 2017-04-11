<?php 
include('../auth_admin.php'); 
if($_SESSION['ROLE_ID']!=0){
	if($permission['loyaltypoint']==0){
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
  
  <title>PetroFDS | Loyalty Points</title>
</head>


<body>

<?php  include('../main_content/header_admin.php'); ?> 
<label>&nbsp;</label>
<?php
$sql='SELECT * FROM `loyalty_points`';
$stmt = $conn->prepare($sql);

$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
if($rows){
	foreach($rows as $row){
?>
<center><label style="font-family:Arial,Helvetica,sans-serif;font-size:25px;color:#f16445;text-align:center" >EDIT LOYALTY POINTS</label></center>

  <div >
  <div class="page-region" >
  <div class="page-content content-wrapper clear-block ">
  		<form AUTOCOMPLETE="off" action="loyalty_set.php" ACCEPT-CHARSET="UTF-8" method="post" id="save_coupon_code" name="save_coupon_code" enctype="multipart/form-data" onSubmit="return validateForm()">
	<table>
		<tr>
        <td>
		<div class="form form-layout-simple clear-block">
        <table>
            <tr>
                <td>        
            <div class="form form-layout-simple clear-block">
            <fieldset class=" fieldset titled sindh" style="background-color:#9C3">
              <legend><span class="fieldset-title">LOYALTY POINTS DETAILS <span class="form-required" title="This field is required.">*</span></span></legend>
              <div class="fieldset-content clear-block ">
                    <div class="form-item form-item-labeled" id="edit-mail-wrapper">
                <table>
                    <tr>
                        <td>
                        	<input type="hidden" name="cate_status" id="cate_status" value="edit" />
                            <input type="hidden" name="id" id="id" value="<?php echo $row['id'] ?>" />
                            <label>ID: <?php echo $row['id'] ?></label>
                        </td>
                    </tr>
                    <tr>
                        <td width="30%">
                            <label>Loyalty Margin: </label> <input type="text" name="margin" id="margin" value="<?php echo $row['loyalty_margin'] ?>" required class="form-text required fluid" />
                        </td>
                        <td width="30%">
                            <label>Loyalty Percent: </label> <input type="text" name="percent" id="percent" value="<?php echo $row['loyalty_percent'] ?>" required class="form-text required fluid" />
                        </td>
                        <td>
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
}else{
?>
<center><label style="font-family:Arial,Helvetica,sans-serif;font-size:25px;color:#f16445;text-align:center" >ADD NEW LOYALTY POINTS</label></center>

  <div >
  <div class="page-region" >
  <div class="page-content content-wrapper clear-block ">
  		<form AUTOCOMPLETE="off" action="loyalty_set.php" ACCEPT-CHARSET="UTF-8" method="post" id="save_coupon_code" name="save_coupon_code" enctype="multipart/form-data">
	<table>
		<tr>
        <td>
		<div class="form form-layout-simple clear-block">
        <table>
            <tr>
                <td>        
            <div class="form form-layout-simple clear-block">
            <fieldset class=" fieldset titled sindh" style="background-color:#9C3">
              <legend><span class="fieldset-title">LOYALTY POINTS DETAILS <span class="form-required" title="This field is required.">*</span></span></legend>
              <div class="fieldset-content clear-block ">
                    <div class="form-item form-item-labeled" id="edit-mail-wrapper">
                <table>
                    <tr>
                        <td>
                        	<input type="hidden" name="cate_status" id="cate_status" value="new" />
                            <label>ID: </label>
                        </td>
                    </tr>
                    <tr>
                        <td width="30%">
                            <label>Loyalty Margin: </label> <input type="text" name="margin" id="margin" required class="form-text required fluid" />
                        </td>
                        <td width="30%">
                            <label>Loyalty Percent: </label> <input type="text" name="percent" id="percent" required class="form-text required fluid" />
                        </td>
                        <td>
                        	<label>Status: </label> <select class="form-select" name="status" required><option value=""></option><option value="1">Active</option><option value="0">Inactive</option></select>
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
<?php
}
?>
<?php include('../main_content/footer.php'); ?>
<script type="text/javascript" src="../js/upload.js"></script>
</body>
</html>