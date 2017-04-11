<?php 

include('../auth_admin.php');

if($_SESSION['ROLE_ID']!=0){

	if($permission['options']==0){

		die("You don't have permission to access please contact administrator.");

	}

} 

include('../../app/themes/lib/system.lib.php');
$conn = PetroFDS::ConnectDB();
?> 

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<HTML>



<head>

  <meta content="text/html; charset=UTF-8" http-equiv="content-type">

  

  <link rel="stylesheet" type="text/css" href="../css/layout.css" />

  <link rel="stylesheet" type="text/css" href="../css/layout-responsive.css" />

  

  <title>PetroFDS | Edit Option</title>

</head>





<body>



<?php  include('../main_content/header_admin.php'); ?> 



<?php


	$stmt = $conn->prepare("SELECT * FROM `option` WHERE id='".$_GET['id']."'");



	$stmt->execute();



	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	

	$stmt_2 = $conn->prepare("SELECT * FROM option_menu WHERE option_id='".$_GET['option_id']."' AND deleted=0");



	$stmt_2->execute();



	$rows_2 = $stmt_2->fetchAll(PDO::FETCH_ASSOC);

		

?>

<label>&nbsp;</label>

<center><label style="font-family:Arial,Helvetica,sans-serif;font-size:25px;color:#f16445;text-align:center" >EDIT OPTION</label></center>



  <div >

<?php

if($rows){

	foreach($rows as $row){

?>

  <div class="page-region" >

  <div class="page-content content-wrapper clear-block ">

  		<form AUTOCOMPLETE="off" action="option_edit.php" ACCEPT-CHARSET="UTF-8" method="post" id="option_form" name="option_form" enctype="multipart/form-data">

	<input type="hidden" name="id" id="id" value="<?php echo $_GET['id'] ?>" />

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

                    <td >

                    <label for="input_type">Input Type:</label>

                    </td>

                </tr>

              <tr>

              		<td>

                    	<label><?php echo $_GET['option_id'] ?></label>

                        <input type="hidden" name="option_id" id="option_id" value="<?php echo $_GET['option_id'] ?>" class='form-text required fluid' />

                    </td>

              		<td>

                    	<input type="text" name="title_first" id="title_first" required class='form-text required fluid' value="<?php echo $row['title'] ?>" />

                    </td>

                    <td>                        		
					<select name="opt_type_edit" id="opt_type_edit" required class='form-select'>
                    <option value=""></option>
					<?php

                    $stmt_3 = $conn->prepare("SELECT * FROM `option_type` WHERE status=1");



                    $stmt_3->execute();



                    $rows_3 = $stmt_3->fetchAll(PDO::FETCH_ASSOC);

                    

					if($rows_3){

						foreach($rows_3 as $row_3){
							if($row['type_id']==$row_3['id']){
								echo '<option selected="selected" value="'.$row_3['id'].'">'.$row_3['type'].'</option>';
							}else{
								echo '<option value="'.$row_3['id'].'">'.$row_3['type'].'</option>';
							}
						}

					}

					?>
					</select>
                    </td>

                    <td>

                    	

                        <?php

						if($row['input_type'] == 'dropdown'){

						?>

                        <select name="input_type" id="input_type" required class='form-select'>

                        <option value=""></option>

                        <option selected="selected" value="dropdown">Dropdown</option>

                        <option value="checkbox">Checkbox</option>

                        </select>

                        <?php	

						}else if($row['input_type'] == 'checkbox'){

						?>

                        <select name="input_type" id="input_type" required class='form-select'>

                        <option value=""></option>

                        <option value="dropdown">Dropdown</option>

                        <option selected="selected" value="checkbox">Checkbox</option>

                        </select>

                        <?php

						}

						?>

                    </td>

              </tr>

              

              <tr>

                    <td >

                    <label for="opt_yes_no">Is Yes And No:</label>

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

                    	<input type="hidden" value="1" name="sort_order_first" />

                    	<select name="is_yes_no" id="is_yes_no" onChange="check_yes_no(this)" required class='form-select'>

                        <option value=""></option>

                        <?php

						if($row['is_yes_no']=='1'){

						?>

                        	<option value="1" selected="selected">Yes</option>

                            <option value="0">No</option>

                        <?php

						}else{

						?>

                        	<option value="1">Yes</option>

                        	<option value="0" selected="selected">No</option>

                        <?php

						}

						?>

                        </select>

                    </td>

                     <td>

                    	<input type="text" name="price_option" value="<?php echo PetroFDS::Float_To_Decimal($row['price_option']) ?>" class='form-text required fluid' id="price_option" required="" />

                    </td>

                    <td>

                    	<select name="status" id="status" required class='form-select'>

                    	<?php

						echo PetroFDS::getSelect($row['status'],'Active','InActive')

						?>

                        </select>

                    </td>

              </tr>

           </table>

           <table>

            <tr>

            		<td width="10%">

                    <label id="opt_id">ID:</label>

                    </td>

                	<td width="22%">

                    <label id="opt_title">Title:</label>

                    </td>

                    <td width="22%">

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

<?php

	}

}

if($rows_2){

?>

	<table id="OptLine">

<?php

	$s=-1;

	foreach($rows_2 as $row_2){

		$s++;

?>

                <tr id="opt_line<?php echo $s ?>">

                	<td width="10%">

                    <input type="hidden" value="<?php echo $row_2['id'] ?>" name="opt_id[]" id="opt_id<?php echo $s ?>" />

                    <label><?php echo $row_2['id'] ?></label>

                    </td>

                	<td width="22%">

                    <input type="text" name="title[]" id="title<?php echo $s ?>" class='form-text required fluid' value="<?php echo $row_2['title'] ?>" />

                    </td>

                    <td width="22%">

                    <input type="text" name="price[]" id="price<?php echo $s ?>" class='form-text required fluid' value="<?php echo PetroFDS::Float_To_Decimal($row_2['price']) ?>" />

                    </td>

                    <td>

                    <input type="text" name="sort_order[]" id="sort_order<?php echo $s ?>" class='form-text required fluid' value="<?php echo $row_2['sort_order'] ?>" />

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

?>

	</table>

			<table>

           	<tr>

            	<td>

    			<input name="addOptLine" id="addOptLine" value="Add New Option" class="form-submit" type="button" onClick="insertOptLine(<?php echo $s+1 ?>)">

                </td>

            </tr>

           </table>

<?php

}else{

?>

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

                    <label for="opt_child">Children:</label>

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

<?php

}

?>

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

  

            	<input value="Edit" class="form-submit" type="submit" style="margin-right:5px;" />

            </td>

        </tr>

    </table>

		</form>

</div>

</div>

<?php include('../main_content/footer.php'); ?> 

<script type="text/javascript" src="../js/petrojs-1.0.0.min.js"></script>

<script type="text/javascript" src="../js/option.js"></script>

</body>

</html>