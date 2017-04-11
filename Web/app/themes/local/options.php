<?php 

	session_start();	

	include_once '../lib/system.lib.php';

	$conn = PetroFDS::ConnectDB();

	PetroFDS::SetTimeZone(); 

if(PetroFDS::getWebsiteStatus() == 'Success'){

?>

<div class="modal-header">

  <button type="button" class="close" data-dismiss="modal">&times;</button>

  <h1 class="modal-title">Customise the Product</h1>

</div>

<div class="modal-body selectwidthauto" style="overflow: visible;">

<?php

	$sql_product = "SELECT * FROM `menus` WHERE id='".$_GET['id']."'";

	foreach((array)PetroFDS::getCustomQuery($sql_product) as $row_product){

			$price = $row_product['price'];
			
			$required_options = $row_product['required_options'];

?>

<table>

	<tr>

        <td>

            <table>

                <tr>

                    <td>

                    	<?php

						if(isset($_GET['title']) && $_GET['title']!='undefined')

						{ 

						$sql_custom = 'SELECT * FROM `menu_custom_option` WHERE menu_id = '.$_GET['id'].' AND id = '.$_GET['title'].'';


						foreach((array)PetroFDS::getCustomQuery($sql_custom) as $row_custom){

						?>

                        <h2><?php echo htmlentities($row_custom['title']).' '.$row_product['name'] ?></h2>

                        <?php

						}

						}else{

						?>

                        <h2><?php echo $row_product['name'] ?></h2>

                        <?php

						}

						?>

                    </td>

                </tr>

                <tr>

                    <td>

                        <h4><?php echo $row_product['description'] ?></h4>

                    </td>

                </tr>

            </table>

        </td>

    </tr>

</table>    

<br /><div class="divider"></div>

<form class="form-horizontal type-choose-one"> 

<?php

	}

$sizeof=1;

$s = 0;

$sql_notype = 'SELECT * FROM `menu_option_type_no` WHERE menu_id = '.$_GET['id'].' AND deleted=0';


foreach((array)PetroFDS::getCustomQuery($sql_notype) as $row_notype){

	if($s % 2 == 0){

		echo '<div class="row-fluid">';

	}

	echo '<div class="control-group dyn-optionset-div-1 span6" data-idx="1" data-i="0"><input type="hidden" id="'.$_GET['id'].'option_notype_title'.$sizeof.'" value="'.$row_notype['id'].'"><label class="col-sm-4"><strong>'.$row_notype['name'].'</strong></label>';

	echo '<div class="controls col-sm-8"><select ide="not_added" onchange="set_price_normal_options(this,\''.PetroFDS::get_currency().'\',\''.$_GET['id'].'\')" name="option_notype" id="'.$_GET['id'].'option_notype'.$sizeof.'" class="selectpicker top5 widthauto" data-style="btn-info">';

	echo '<option value="" price="0.00"></option>';

	$sql_notype1 = "SELECT op.id as op_id, op.title as op_title, op.option_id as op_option_id, op.price as op_price, o.id as o_id, o.title as o_title, 

									o.option_id as o_option_id FROM `option` o 

									LEFT JOIN `option_menu` op ON o.option_id=op.option_id

									WHERE o.id='".$row_notype['option_id']."'";


	foreach((array)PetroFDS::getCustomQuery($sql_notype1) as $row_notype1){

		if(isset($row_notype1['op_price']) && $row_notype1['op_price']!='0'){
			echo '

				<option id="'.$row_notype['id'].'" price="'.PetroFDS::Float_To_Decimal($row_notype1['op_price']).'" value="'.$row_notype1['op_id'].'">'.$row_notype1['op_title'].' ('.PetroFDS::get_currency().PetroFDS::Float_To_Decimal($row_notype1['op_price']).')</option>

			';
		}else if(isset($row_notype1['op_price']) && $row_notype1['op_price']=='0'){
			echo '

				<option id="'.$row_notype['id'].'" price="0.00" value="'.$row_notype1['op_id'].'">'.$row_notype1['op_title'].'</option>

			';
		}
	}

	echo '</select></div></div><br/><br/>';

	if($s % 2 != 0){

		echo '</div>';

	}

	$sizeof++;

	$s++;

}

?>

</form>

<?php

	$i = 1;

	$j = 1;

	$k = 1;

	if(isset($row_product['options_with_type'], $row_custom['option_with_type']) && $row_product['options_with_type']!='' && $row_custom['option_with_type']!=''){

		$sql_title = 'SELECT * FROM `option_type` WHERE id IN ('.$row_product['options_with_type'].') AND status=1

					  UNION

					  SELECT * FROM `option_type` WHERE id IN ('.$row_custom['option_with_type'].') AND status=1';

	}else if(isset($row_product['options_with_type']) && $row_product['options_with_type']!=''){

		$sql_title = 'SELECT * FROM `option_type` WHERE id IN ('.$row_product['options_with_type'].') AND status=1';

	}else if(isset($row_custom['option_with_type']) && $row_custom['option_with_type']!=''){

		$sql_title = 'SELECT * FROM `option_type` WHERE id IN ('.$row_custom['option_with_type'].') AND status=1';

	}

	 	

	if(isset($sql_title)){


	foreach((array)PetroFDS::getCustomQuery($sql_title) as $row_title){

?>

</div>

<div id="border-model-body"><div id="border-inner-content">

<?php	

			$sql_1='SELECT * FROM `option` WHERE type_id="'.$row_title['id'].'" AND status=1';

			$check=0;

			foreach((array)PetroFDS::getCustomQuery($sql_1) as $row_2){	

			if($row_2['is_yes_no']=='1'){

				echo '<label class="col-sm-4"><strong>'.$row_2['title'].'</strong></label><div class="controls col-sm-8">';

				if(PetroFDS::Float_To_Decimal($row_2['price_option'])=='0.00'){

					echo '

					<select ide="not_added" data-width="60px" id="'.$_GET['id'].'select_yesno'.$j.'" onchange="set_price_yes_no(this,\''.PetroFDS::get_currency().'\',\''.PetroFDS::Float_To_Decimal($row_2['price_option']).'\',\''.$_GET['id'].'\')" class="selectpicker" style="height:20px" data-style="btn-info">

					<option value="0">No</option>

					<option value="'.$row_2['id'].'">Yes</option>

					</select><br/>';

				}else{

					echo '

					<select ide="not_added" data-width="60px" id="'.$_GET['id'].'select_yesno'.$j.'" onchange="set_price_yes_no(this,\''.PetroFDS::get_currency().'\',\''.PetroFDS::Float_To_Decimal($row_2['price_option']).'\',\''.$_GET['id'].'\')" class="selectpicker" style="height:20px" data-style="btn-info">

					<option value="0">No</option>

					<option value="'.$row_2['id'].'">Yes</option>

					</select><kbd style="margin-left:5px; background:transparent; color:#000;">'.PetroFDS::get_currency().PetroFDS::Float_To_Decimal($row_2['price_option']).'</kbd><br/>';

				}

				echo '</div><br/><br/>';

				$j++;

			}else{

				echo '<label class="col-sm-4" style="margin-top:15px;margin-bottom:15px;"><strong>'.$row_2['title'].'</strong></label>';

				if($row_2['input_type']=='dropdown'){

					echo '<div class="controls col-sm-8" style="margin-top:15px;margin-bottom:15px;">'.PetroFDS::Start_Dropdown($k,$_GET['id'],'first');
				

						$sql_3_dropdown = "SELECT * FROM `option_menu` WHERE option_id='".$row_2['option_id']."' AND deleted=0";

						foreach((array)PetroFDS::getCustomQuery($sql_3_dropdown) as $row_3){

							echo PetroFDS::Dropdown_Option($row_3['id'],$row_3['children'],$row_3['title'],PetroFDS::Float_To_Decimal($row_3['price']));

						}

						

					echo PetroFDS::End_Dropdown($row_3['price'],$k).'</div><br/><br/>';

					$k++;

				}else if($row_2['input_type']=='checkbox'){

					echo '<div class="controls col-sm-8" style="margin-top:15px;margin-bottom:15px;"><table id="check'.$i.'" class="col-sm-12"><tr>';

					$sql_3_checkbox = "SELECT * FROM `option_menu` WHERE option_id='".$row_2['option_id']."' AND deleted=0";

					foreach((array)PetroFDS::getCustomQuery($sql_3_checkbox) as $row_3){

						if ($k % 2 != 0) {

						echo '</tr><tr><td>'.PetroFDS::Checkbox($k,$_GET['id'],$row_3['title'],PetroFDS::Float_To_Decimal($row_3['price']),$row_3['id']).'</td>';

						}else{

						echo '<td>'.PetroFDS::Checkbox($k,$_GET['id'],$row_3['title'],PetroFDS::Float_To_Decimal($row_3['price']),$row_3['id']).'</td>';

						}

						$k++;

					}

					echo '</tr></table></div>';

				}

				

			}

			$i++;

			}
?>
</div>
</div>

<?php

	}

	}

?>

<div class="modal-footer">

<?php

if(isset($_GET['price']) && $_GET['price']!="undefined"){

?>

  <h4 style="float:left">Total: <?php echo PetroFDS::get_currency() ?><span id="price<?php echo $_GET['id'] ?>"><?php echo PetroFDS::Float_To_Decimal($_GET['price']); ?></span></h4><label id="extra<?php echo $_GET['id'] ?>" style="float:left; line-height:40px;"></label>

<?php

}else{

?>

  <h4 style="float:left">Total: <?php echo PetroFDS::get_currency() ?><span id="price<?php echo $_GET['id'] ?>"><?php echo PetroFDS::Float_To_Decimal($price); ?></span></h4><label id="extra<?php echo $_GET['id'] ?>" style="float:left; line-height:40px;"></label>

<?php

}

?>

  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

  <?php

if(isset($_GET['title']) && $_GET['title']!="undefined"){

  if(isset($sizeof) && $sizeof!=0){

  ?>

  <button type="button" class="btn btn-success" onclick="addtocart_withoptions('add',<?php echo $_GET['id'] ?>,<?php echo $_GET['title'] ?>,<?php echo $i ?>,<?php echo $j ?>,<?php echo $k ?>,<?php echo $sizeof ?>,<?php echo $required_options ?>)" id="add_crt" name="add_crt">Add to Order</button>

  <?php

  }else{

  ?>

  <button type="button" class="btn btn-success" onclick="addtocart_withoptions('add',<?php echo $_GET['id'] ?>,<?php echo $_GET['title'] ?>,<?php echo $i ?>,<?php echo $j ?>,<?php echo $k ?>,0,<?php echo $required_options ?>)" id="add_crt" name="add_crt">Add to Order</button>

  <?php

  }

}else{

  if(isset($sizeof) && $sizeof!=0){

  ?>

  <button type="button" class="btn btn-success" onclick="addtocart_withoptions('add','<?php echo $_GET['id'] ?>',null,<?php echo $i ?>,<?php echo $j ?>,<?php echo $k ?>,<?php echo $sizeof ?>,<?php echo $required_options ?>)" id="add_crt" name="add_crt">Add to Order</button>

  <?php


  }else{

  ?>

  <button type="button" class="btn btn-success" onclick="addtocart_withoptions('add','<?php echo $_GET['id'] ?>',null,<?php echo $i ?>,<?php echo $j ?>,<?php echo $k ?>,0,<?php echo $required_options ?>)" id="add_crt" name="add_crt">Add to Order</button>

  <?php

  }

}

?>

</div>
<?php

}else{

?>

<div class="modal-header">

  <button type="button" class="close" data-dismiss="modal">&times;</button>

  <h4 class="modal-title" style="color:#F00">Your are about to order on closed time: </h4>

</div>

<div class="modal-body selectwidthauto" style="overflow: visible;">

<label class="bigboldtext">Order Timings:</label>

<table border="1" width="100%" style="text-align:center;" cellpadding="10">

<tr><td>Days</td>

<td>Open Time</td>

<td>Close Time </td></tr>

<?php

foreach(PetroFDS::get_days_config() as $value){

	echo '<tr><td>

	'.$value['days'].'

	</td><td>

	'.PetroFDS::ftime($value['website_open'],12).'

	</td><td>

	'.PetroFDS::ftime($value['website_close'],12).'

	</td></tr>';

}

?>

</tr>

</table>

</div>

<div class="modal-footer">

<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

</div>

<?php

}

?>