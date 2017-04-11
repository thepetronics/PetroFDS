<?php 

	include('../auth_admin.php'); 
	
	if($_SESSION['ROLE_ID']!=0){
		if($permission['category']==0){
			die("You don't have permission to access please contact administrator.");
		}
	}

	require_once('../../app/themes/lib/system.lib.php');
	$conn = PetroFDS::ConnectDB();
		
	$stmt = $conn->prepare("SELECT * FROM category");

	$stmt->execute();

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
  
  <title>PetroFDS | Categories</title>
</head>


<body>

<?php  include('../main_content/header_admin.php'); ?>
<br />
<br /> 
<a href="set_category?status=new" style="float:right; text-decoration:none;"><input type="button" class="form-submit" value="Add New Category" /></a>
<br />
<br />
<div id="content-area">
<table id="petrofds" class="table table-striped table-bordered table-primary table-condensed">
    	<thead>
			<tr>
				<th width="10%">ID</th>
                <th width="10%">Category</th>
                <th width="10%">Created By</th>
                <th width="10%">Date Created</th>
                <th width="10%">Date Modified</th>
                <th width="10%">Status</th>
			</tr>
    	</thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Created By</th>
                <th>Date Created</th>
                <th>Date Modified</th>
                <th>Status</th>
            </tr>
        </tfoot>
        <tbody>
<?php
if($rows){
	foreach($rows as $row){
?>
		<tr>
            	<td><a href="set_category?status=edit&id=<?php echo $row['id'] ?>" style="text-decoration:none;">
 					<?php echo $row['id'] ?>	               
                </a></td>
				<td><a href="set_category?status=edit&id=<?php echo $row['id'] ?>" style="text-decoration:none;">
 					<?php echo $row['name'] ?>               
                </a></td>
				<td><a href="set_category?status=edit&id=<?php echo $row['id'] ?>" style="text-decoration:none;">
 					<?php 
					$stmt_user = $conn->prepare("SELECT * FROM admin WHERE id=".$row['created_by']."");

					$stmt_user->execute();

					$rows_user = $stmt_user->fetchAll(PDO::FETCH_ASSOC);
					
					if($rows_user){
						foreach($rows_user as $user){
							echo $user['firstname']." ".$user['lastname'];
						}
					}
					?>	               
                </a></td>
				<td><a href="set_category?status=edit&id=<?php echo $row['id'] ?>" style="text-decoration:none;">
 					<?php echo $row['date_created'] ?>               
                </a></td>
				<td><a href="set_category?status=edit&id=<?php echo $row['id'] ?>" style="text-decoration:none;">
 					<?php echo $row['date_modified'] ?>               
                </a></td>
                <td><a href="set_category?status=edit&id=<?php echo $row['id'] ?>" style="text-decoration:none;">
                	<?php 
					if($row['status'] == '1'){
						echo '<label style="color:#9F6">Active</label>';
					}else{
						echo '<label style="color:#F00">InActive</label>';
					}
					?>
                </a></td>
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