<?php 

	include('../auth_admin.php'); 
	
	if($_SESSION['ROLE_ID']!=0){
		if($permission['orders']==0){
			die("You don't have permission to access please contact administrator.");
		}
	}

	require_once('../../app/themes/lib/system.lib.php');
	$conn = PetroFDS::ConnectDB();
		
	$stmt_orders = $conn->prepare("SELECT * FROM `orders`");

	$stmt_orders->execute();

	$rows_orders = $stmt_orders->fetchAll(PDO::FETCH_ASSOC);
	
	$stmt_order_details = $conn->prepare("SELECT * FROM `order_details`");

	$stmt_order_details->execute();

	$rows_order_details = $stmt_order_details->fetchAll(PDO::FETCH_ASSOC);

?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<HTML>

<head>
  <meta content="text/html; charset=UTF-8" http-equiv="content-type">
  
  <link rel="stylesheet" type="text/css" href="../css/layout.css" />
  <link rel="stylesheet" type="text/css" href="../css/layout-responsive.css" />
  <link href="../tabletheme/scripts/DataTables/media/css/jquery.dataTables.css" rel="stylesheet">
  <link href="../tabletheme/scripts/DataTables/media/css/TableTools.css" rel="stylesheet">
  <link rel="stylesheet/less" href="../tabletheme/less/style.less" />
  
  <title>PetroFDS | Orders</title>
</head>


<body>

<?php  include('../main_content/header_admin.php'); ?>
<br />
<br />
<div id="content-area">
<table id="petrofds" class="table table-striped table-bordered table-primary table-condensed">
    	<thead>
			<tr>
				<th width="10%">Order ID</th>
                <th width="10%">Created By</th>
                <th width="10%">Payment Method</th>
                <th width="10%">About Order</th>
                <th width="10%">Ordered Date/Time</th>
                <th width="10%">Status</th>
                <th width="10%">Change Status</th>
                <th width="10%">Print</th>
			</tr>
    	</thead>
        <tfoot>
            <tr>
                <th>Order ID</th>
                <th>Created By</th>
                <th>Payment Method</th>
                <th>About Order</th>
                <th>Ordered Date/Time</th>
                <th>Status</th>
                <th>Manage Status</th>
                <th>Print</th>
            </tr>
        </tfoot>
        <tbody>
<?php
if($rows_order_details){
	foreach($rows_order_details as $row){
?>
		<tr>
            	<td>
 					<?php echo $row['id'] ?>	               
                </td>
                <td>
 					<?php 
					$stmt_user = $conn->prepare("SELECT * FROM `users` WHERE id=".$row['user_id']."");

					$stmt_user->execute();

					$rows_user = $stmt_user->fetchAll(PDO::FETCH_ASSOC);
					
					if($rows_user){
						foreach($rows_user as $user){
							echo $user['firstname']." ".$user['lastname'];
						}
					}
					?>	    	               
                </td>
				<td>
 					<?php echo $row['payment_method'] ?>               
                </td>
				<td>
 					<?php echo $row['about_order'] ?>               
                </td>
				<td>
 					<?php echo $row['date_created'] ?>               
                </td>
                <td>
                	<?php 
					if($row['status'] == '0'){
						echo '<label style="color:#E000FF">PENDING</label>';
					}elseif($row['status'] == '1'){
						echo '<label style="color:#0207FF">ACCEPTED</label>';
					}elseif($row['status'] == '2'){
						echo '<label style="color:#9F6">DELIVERED</label>';
					}elseif($row['status'] == '3'){
						echo '<label style="color:#F00">DECLINE</label>';
					}
					?>
                </td>
                <td>
                	<?php 
					if($row['status'] == '0'){
					?>
                    <a href="change_order?order_id=<?php echo $row['id'] ?>&status=<?php echo $row['status'] ?>" style="text-decoration:none; color:#0207FF; font-weight:bold;">ACCEPT <span style="color:#000;">/</span> DECLINE</a>
                    <?php
					}elseif($row['status'] == '1'){
						echo '<label style="color:#FC7C7F">STATUS LOCKED</label>';
					}elseif($row['status'] == '2'){
						echo '<label style="color:#FC7C7F">STATUS LOCKED</label>';
					}elseif($row['status'] == '3'){
						echo '<label style="color:#FC7C7F">STATUS LOCKED</label>';
					}
					?>
                </td>
                <td>
                <a target="_blank" style="text-decoration:none;" href="print_order?order_id=<?php echo $row['id'] ?>"><img src="../images/main/reports.png" /></a>
                </td>
            </tr>   
<?php
	}
}
?>
		</tbody>
</table>
</div>
<?php include('../main_content/footer.php'); ?> 

<script src="../tabletheme/scripts/jquery-1.8.2.min.js"></script>
<script src="../tabletheme/scripts/less-1.3.3.min.js"></script>
<script src="../tabletheme/scripts/table.js"></script>
<script src="../tabletheme/scripts/jquery.cookie.js"></script>
<script src="../tabletheme/scripts/themer.js"></script>
<script src="../tabletheme/scripts/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="../js/petrojs-1.0.0.min.js"></script>
<script src="../tabletheme/scripts/DataTables/media/js/jquery.dataTables.js"></script>
<script src="../tabletheme/scripts/DataTables/media/js/DT_bootstrap.js"></script>
<script src="../tabletheme/scripts/DataTables/media/js/TableTools.js"></script>
</body>
</html>