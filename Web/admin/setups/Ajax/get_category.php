<?php 

	include('../../auth_admin.php'); 

	require_once('../../../app/themes/lib/system.lib.php');
	$conn = PetroFDS::ConnectDB();
	
	$product_id = $_GET['product_id'];
		
	if(isset($product_id)){	
		$stmt = $conn->prepare("SELECT * FROM `menus` WHERE id='".$product_id."'");
	
		$stmt->execute();
	
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		if($rows){
			foreach($rows as $row){
				$stmt_2 = $conn->prepare("SELECT * FROM `category` WHERE id='".$row['category_id']."'");
			
				$stmt_2->execute();
			
				$rows_2 = $stmt_2->fetchAll(PDO::FETCH_ASSOC);
			
				echo '<OPTION value=""></OPTION>';
				if($rows_2){
					foreach($rows_2 as $row_2){
						$stmt_3 = $conn->prepare("SELECT * FROM `category`");
			
						$stmt_3->execute();
					
						$rows_3 = $stmt_3->fetchAll(PDO::FETCH_ASSOC);
						
						if($rows_3){
							foreach($rows_3 as $row_3){
								if($row_2['id']==$row_3['id']){
									echo '<OPTION value="'.$row_3['id'].'" selected="selected">'.$row_3['name'].'</OPTION>';
								}else{
									echo '<OPTION value="'.$row_3['id'].'">'.$row_3['name'].'</OPTION>';
								}
							}
						}
					}
				}
			}
		}
	}else{
		$stmt = $conn->prepare("SELECT * FROM `category`");
	
		$stmt->execute();
	
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
		echo '<OPTION value=""></OPTION>';
		if($rows){
			foreach($rows as $row){
				echo '<OPTION value="'.$row['id'].'">'.$row['name'].'</OPTION>';	
			}
		}
	}