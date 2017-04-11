<?php 
include('../auth_admin.php');

if($_SESSION['ROLE_ID']!=0){

	if($permission['postcode']==0){

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

  

  <title>PetroFDS | Post Codes</title>

</head>





<body>



<?php  include('../main_content/header_admin.php'); ?> 

<label>&nbsp;</label>

<?php
$sql='SELECT * FROM `post_code` WHERE deleted=0';

$stmt = $conn->prepare($sql);



$stmt->execute();

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if($rows){

?>

<center><label style="font-family:Arial,Helvetica,sans-serif;font-size:25px;color:#f16445;text-align:center" >POST CODES</label></center>



  <div >

  <div class="page-region" >

  <div class="page-content content-wrapper clear-block ">

  		<form AUTOCOMPLETE="off" action="post_code_set.php" ACCEPT-CHARSET="UTF-8" method="post" id="save_coupon_code" name="save_coupon_code" enctype="multipart/form-data">

	<table>

		<tr>

        <td>

		<div class="form form-layout-simple clear-block">

        <table>

            <tr>

                <td>        

            <div class="form form-layout-simple clear-block">

            <fieldset class=" fieldset titled sindh" k8style="background-color:#9C3">

              <legend><span class="fieldset-title">SET POST CODE <span class="form-required" title="This field is required.">*</span></span></legend>

              <div class="fieldset-content clear-block ">

                    <div class="form-item form-item-labeled" id="edit-mail-wrapper">

                <table id="PostCodeLine">

                    <tr>

                        <td>

                        	<input type="hidden" name="cate_status" id="cate_status" value="edit" />

                            <label>Post Code:</label>

                        </td>

                        <td>

                        	<label>Price:</label>

                        </td>

                    </tr>

                <?php

				$s=-1;

				foreach($rows as $row){

					$s++;
				?>

                    <tr id="code_line<?php echo $s ?>">

                        <td>

                        	<input type="hidden" name="id[]" id="id" value="<?php echo $row['id'] ?>" />

                            <input type="text" name="postcode[]" id="postcode" value="<?php echo $row['postcode'] ?>" required class="form-text required fluid" />

                        </td>

                        <td>

                        	<input type="text" name="price[]" id="price" value="<?php echo PetroFDS::Float_To_Decimal($row['price']) ?>" required class="form-text required fluid" />

                        </td>

                        <td>

                        <?php

							$RMVBUTTON = "";

							$RMVBUTTON .= "<input type='hidden' id='code_deleted$s' name='code_deleted[]' value='0'/>";

							$RMVBUTTON .= "<input class='form-submit' type='button' value='Remove Row' onClick='markPostCodeLineDeleted($s)'/>";

							echo $RMVBUTTON;

						?>

                        </td>

                    </tr>

                <?php

				}
				
				?>
                </table>

                <table>

                	<tr>

                    	<td>

                        	<input name="addPostCodeLine" id="addPostCodeLine" value="Add New Row" class="form-submit" type="button" onClick="insertPostCodeLine(<?php echo $s+1 ?>)">

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

}else{

?>

<center><label style="font-family:Arial,Helvetica,sans-serif;font-size:25px;color:#f16445;text-align:center" >SYSTEM CONFIGURATION</label></center>



  <div >

  <div class="page-region" >

  <div class="page-content content-wrapper clear-block ">

  		<form AUTOCOMPLETE="off" action="post_code_set.php" ACCEPT-CHARSET="UTF-8" method="post" id="save_coupon_code" name="save_coupon_code" enctype="multipart/form-data">

	<table>

		<tr>

        <td>

		<div class="form form-layout-simple clear-block">

        <table>

            <tr>

                <td>        

            <div class="form form-layout-simple clear-block">

            <fieldset class=" fieldset titled sindh" style="background-color:#9C3">

              <legend><span class="fieldset-title">SET POST CODE <span class="form-required" title="This field is required.">*</span></span></legend>

              <div class="fieldset-content clear-block ">

                    <div class="form-item form-item-labeled" id="edit-mail-wrapper">

                <table id="PostCodeLine">

                    <tr>

                        <td>

                        	<input type="hidden" name="cate_status" id="cate_status" value="new" />

                            <label>Post Code: </label>

                        </td>

                        <td>

                        	<label>Price: </label>

                        </td>

                    </tr>

                    <tr>

                        

                    </tr>

                </table>

                <table>

                	<tr>

                    	<td>

                        	<input name="addPostCodeLine" id="addPostCodeLine" value="Add New Row" class="form-submit" type="button" onClick="insertPostCodeLine(0)">

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

<script type="text/javascript" src="../js/post_code.js"></script>

</body>

</html>