<?php 

	include('../auth_admin.php'); 
	
	if($_SESSION['ROLE_ID']!=0){
		die("You don't have permission to access please contact administrator.");
	}

	require_once('../../app/themes/lib/system.lib.php');
	$conn = PetroFDS::ConnectDB();
		
	$stmt = $conn->prepare("SELECT role_id, role_name, description, date_created, date_modified, created_by, last_modified_by, status
						  FROM roles");

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
  
  <title>PetroFDS | Roles</title>
</head>


<body>

<?php  include('../main_content/header_admin.php'); ?>
<br />
<br /> 
<a href="add_role" style="float:right; text-decoration:none;"><input type="button" class="form-submit" value="Add New Role" /></a>
<br />
<br />
<div id="content-area">
<table id="petrofds" class="table table-striped table-bordered table-primary table-condensed">
    	<thead>
			<tr>
				<th>ID</th>
                <th>Role Name</th>
                <th>Description</th>
                <th>Date Created</th>
                <th>Date Modified</th>
                <th>Created By</th>
                <th>Last Modified By</th>
                <th>Status</th>
			</tr>
    	</thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Role Name</th>
                <th>Description</th>
                <th>Date Created</th>
                <th>Date Modified</th>
                <th>Created By</th>
                <th>Last Modified By</th>
                <th>Status</th>
            </tr>
        </tfoot>
        <tbody>
<?php
if($rows){
	foreach($rows as $row){
?>
		<tr>
            	<td><a href="edit_role?status=edit&main_id=<?php echo $row['role_id'] ?>" style="text-decoration:none;">
 					<?php echo $row['role_id'] ?>	               
                </a></td>
                <td><a href="edit_role?status=edit&main_id=<?php echo $row['role_id'] ?>" style="text-decoration:none;">
 					<?php echo $row['role_name'] ?>               
                </a></td>
				<td><a href="edit_role?status=edit&main_id=<?php echo $row['role_id'] ?>" style="text-decoration:none;">
 					<?php echo $row['description'] ?>               
                </a></td>
				<td><a href="edit_role?status=edit&main_id=<?php echo $row['role_id'] ?>" style="text-decoration:none;">
 					<?php echo $row['date_created'] ?>	               
                </a></td>
				<td><a href="edit_role?status=edit&main_id=<?php echo $row['role_id'] ?>" style="text-decoration:none;">
 					<?php echo $row['date_modified'] ?>               
                </a></td>
				<td><a href="edit_role?status=edit&main_id=<?php echo $row['role_id'] ?>" style="text-decoration:none;">
 					<?php 
					$stmt_created_by = $conn->prepare("SELECT firstname, lastname FROM admin WHERE id=".$row['created_by']."");

					$stmt_created_by->execute();

					$rows_created_by = $stmt_created_by->fetchAll(PDO::FETCH_ASSOC);
					if($rows_created_by){
						foreach($rows_created_by as $row_created_by){
							echo $row_created_by['firstname']." ".$row_created_by['lastname'];
						}
					}
					?>               
                </a></td>
                <td><a href="edit_role?status=edit&main_id=<?php echo $row['role_id'] ?>" style="text-decoration:none;">
                	<?php 
					$stmt_created_by = $conn->prepare("SELECT firstname, lastname FROM admin WHERE id=".$row['last_modified_by']."");

					$stmt_created_by->execute();

					$rows_created_by = $stmt_created_by->fetchAll(PDO::FETCH_ASSOC);
					if($rows_created_by){
						foreach($rows_created_by as $row_created_by){
							echo $row_created_by['firstname']." ".$row_created_by['lastname'];
						}
					}
					?>
                </a></td>
                <td><a href="edit_role?status=edit&id=<?php echo $row['role_id'] ?>" style="text-decoration:none;">
                	<?php 
					if($row['status']=='1'){
						echo '<label style="color:#9F6">Active</label>';
					}else if($row['status']=='0'){
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