<?php 
include('../auth_admin.php'); 
if($_SESSION['ROLE_ID']!=0){
	die("You don't have permission to access please contact administrator.");
}
require_once('../../app/themes/lib/system.lib.php');
$conn = PetroFDS::ConnectDB();
$order_id = $_GET['order_id'];
$status = $_GET['status'];
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<HTML>

<head>
  <meta content="text/html; charset=UTF-8" http-equiv="content-type">

  <title>PetroFDS | Change Order</title>
</head>


<body class="sindh" >

<?php  include('../main_content/header_admin.php'); ?> 
<table class="sindh" cellpadding="0" cellspacing="0" style="background-image:url('')">
<tr>
	<td>
<label>&nbsp;</label>
<center><label style="font-family:Arial,Helvetica,sans-serif;font-size:25px;color:#f16445;text-align:center" >Change Order</label></center>

    </td>
</tr>
<tr >
<td >
<div id="page"   style="left:0px; right: 0px; margin-left:90px; padding:0px;" >
	<div class="limiter clear-block">
  	  <div id="content" ><div class="page-region"  >
    	<div class="page-content content-wrapper clear-block" style="width:600px;"  >
        
        	<form  onsubmit='return false;' autocomplete="off" action="#" accept-charset="UTF-8" method="post" id="change_order_form" name="change_order_form" enctype="multipart/form-data">

			<div >
            	<div class="form form-layout-simple clear-block" >
		
        		<fieldset class=" fieldset titled">
					<legend><span class="fieldset-title">CHANGE ORDER</span></legend>
					<div class="fieldset-content clear-block ">
					
                    <div class="form-item form-item-labeled" id="edit-mail-wrapper">
                    <table >
                    	<tr>
                        	<td width="216">
           						<label for="edit-mail">Order ID: </label>
		                        <label  style="color:#000;font-size:14px;font-weight:600" ><?php echo $order_id ?></label>            

                            </td>
                            <td width="164">
           						<label for="edit-mail">Your IP: </label>
		                        <label  style="color:#000;font-size:14px;font-weight:600" ><?php echo $_SESSION['USER_IP'] ?></label>            
                            </td>
                            <td width="158">
           						<label for="edit-mail">Status: </label>    
                                <?php 
								if($status == '0'){
									echo '<label style="color:#E000FF">PENDING</label>';
								}elseif($status == '1'){
									echo '<label style="color:#0207FF">ACCEPTED</label>';
								}elseif($status == '2'){
									echo '<label style="color:#9F6">DELIVERED</label>';
								}elseif($status == '3'){
									echo '<label style="color:#F00">DECLINE</label>';
								}
								?>
                            </td>
                        </tr>
                        <tr>
							<td>
           						<label for="edit-mail">Status: <span class="form-required" title="This field is required.">*</span> </label>
                                <select class="form-select" id="status" name="status">
                                <option value=""></option> 
                                <option value="1">Accept</option>
                                <option value="3">Decline</option>
                                 </select>                            
                            </td>   
                            <td>
                            	<label for="edit-mail">Order Time: </label>
                                <select class="form-select" id="order_time" name="order_time">
                                <option value=""></option>
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                                <option value="50">50</option>
                                <option value="60">60</option>
                                <option value="70">70</option>
                                <option value="80">80</option>
                                <option value="90">90</option>
                                <option value="100">100</option>
                                <option value="110">110</option>
                                <option value="120">120</option>
                                </select>
                            </td>                     
                        </tr>
						<tr>
                        	<td colspan="3">
                                <label for="edit-mail">Decline Reason: </label>                            	
                                <textarea name="decline_reason" id="decline_reason" class="form-required" cols="86" rows="6"></textarea>
                            </td>
                        </tr>
                    </table>
				  	</div>
					</div>
				</fieldset>


		<table  style="border:0;" width="100%" >
        	<tr style="background-color:#CCC" >


                <td align="right" style="height:40px;vertical-align:middle" colspan="2">
                <input name="b1" id="b1" value="Save" class="form-submit" onClick="sendOrderStatus(<?php echo $order_id ?>)" type="button">&nbsp;

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
<script src="order.js"></script>
<?php include('../main_content/footer.php'); ?> 
</body>
</html>