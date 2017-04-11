<?php 
	include('../auth_admin.php');
	require_once('../../app/themes/lib/system.lib.php');
	$conn = PetroFDS::ConnectDB();

	if($_POST['email_status'] == "new"){

	

		$stmt = $conn->prepare('INSERT INTO emails (admin_email, admin_email_pass, order_email, order_email_pass, info_email, info_email_pass)

		VALUES(:admin_email,:admin_email_pass,:order_email,:order_email_pass,:info_email,:info_email_pass)');

			

		$stmt->execute(array(

			':admin_email' => $_POST['admin_email'],
			
			':admin_email_pass' => PetroFDS::Safe_Encrypt($_POST['admin_email_pass'],'admin'),

			':order_email' => $_POST['order_email'],
			
			':order_email_pass' => PetroFDS::Safe_Encrypt($_POST['order_email_pass'],'order'),

			':info_email' => $_POST['info_email'],
			
			':info_email_pass' => PetroFDS::Safe_Encrypt($_POST['info_email_pass'],'info')

		));

		header('Location: emails');

	

	}else{
		
		if($_POST['admin_email_pass']=='' && $_POST['order_email_pass']=='' && $_POST['info_email_pass']==''){
			$stmt_2 = $conn->prepare('UPDATE `emails` SET admin_email=:admin_email,order_email=:order_email,info_email=:info_email WHERE id=:id');
	
						
	
			$stmt_2->execute(array(
	
				':admin_email' => $_POST['admin_email'],
	
				':order_email' => $_POST['order_email'],
	
				':info_email' => $_POST['info_email'],
				
				':id' => $_POST['id']
	
			));
		}else if($_POST['admin_email_pass']==''){
			$stmt_2 = $conn->prepare('UPDATE `emails` SET admin_email=:admin_email,order_email=:order_email,order_email_pass=:order_email_pass,info_email=:info_email,info_email_pass=:info_email_pass WHERE id=:id');
	
						
	
			$stmt_2->execute(array(
	
				':admin_email' => $_POST['admin_email'],
	
				':order_email' => $_POST['order_email'],
				
				':order_email_pass' => PetroFDS::Safe_Encrypt($_POST['order_email_pass'],'order'),
	
				':info_email' => $_POST['info_email'],
				
				':info_email_pass' => PetroFDS::Safe_Encrypt($_POST['info_email_pass'],'info'),
				
				':id' => $_POST['id']
	
			));
		}else if($_POST['order_email_pass']==''){
			$stmt_2 = $conn->prepare('UPDATE `emails` SET admin_email=:admin_email,admin_email_pass=:admin_email_pass,order_email=:order_email,info_email=:info_email,info_email_pass=:info_email_pass WHERE id=:id');
	
						
	
			$stmt_2->execute(array(
	
				':admin_email' => $_POST['admin_email'],
				
				':admin_email_pass' => PetroFDS::Safe_Encrypt($_POST['admin_email_pass'],'admin'),
	
				':order_email' => $_POST['order_email'],
	
				':info_email' => $_POST['info_email'],
				
				':info_email_pass' => PetroFDS::Safe_Encrypt($_POST['info_email_pass'],'info'),
				
				':id' => $_POST['id']
	
			));
		}else if($_POST['info_email_pass']==''){
			$stmt_2 = $conn->prepare('UPDATE `emails` SET admin_email=:admin_email,admin_email_pass=:admin_email_pass,order_email=:order_email,order_email_pass=:order_email_pass,info_email=:info_email WHERE id=:id');
	
						
	
			$stmt_2->execute(array(
	
				':admin_email' => $_POST['admin_email'],
				
				':admin_email_pass' => PetroFDS::Safe_Encrypt($_POST['admin_email_pass'],'admin'),
	
				':order_email' => $_POST['order_email'],
				
				':order_email_pass' => PetroFDS::Safe_Encrypt($_POST['order_email_pass'],'order'),
	
				':info_email' => $_POST['info_email'],
				
				':id' => $_POST['id']
	
			));
		}else{
			$stmt_2 = $conn->prepare('UPDATE `emails` SET admin_email=:admin_email,admin_email_pass=:admin_email_pass,order_email=:order_email,order_email_pass=:order_email_pass,info_email=:info_email,info_email_pass=:info_email_pass WHERE id=:id');
	
						
	
			$stmt_2->execute(array(
	
				':admin_email' => $_POST['admin_email'],
				
				':admin_email_pass' => PetroFDS::Safe_Encrypt($_POST['admin_email_pass'],'admin'),
	
				':order_email' => $_POST['order_email'],
				
				':order_email_pass' => PetroFDS::Safe_Encrypt($_POST['order_email_pass'],'order'),
	
				':info_email' => $_POST['info_email'],
				
				':info_email_pass' => PetroFDS::Safe_Encrypt($_POST['info_email_pass'],'info'),
				
				':id' => $_POST['id']
	
			));
		}
		

		header('Location: emails');

	}

?>