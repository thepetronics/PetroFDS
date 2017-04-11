<?php 

	session_start();
	
	include_once '../../app/themes/lib/system.lib.php';
	
	$conn = PetroFDS::ConnectDB();

	if(isset($_POST['method']) && $_POST['method']=='register'){

		$stmt = $conn->prepare('INSERT INTO `users` (firstname, lastname, email, password, contact_no, add_1, add_2, city, post_code, status, date_created)

		VALUES(:firstname,:lastname,:email,:password,:contact_no,:add_1,:add_2,:city,:post_code,:status,:date_created)');			

		$stmt->execute(array(

			':firstname' => $_POST['firstname'],

			':lastname' => $_POST['lastname'],

			':email' => $_POST['email'],

			':password' => md5($_POST['password']),

			':contact_no' => $_POST['contact_no'],

			':add_1' => $_POST['add_1'],

			':add_2' => $_POST['add_2'],

			':city' => $_POST['city'],

			':post_code' => $_POST['post_code'],

			':status' => 1,

			':date_created' => date('Y-m-d H:i:s a'),

		));	

		header('Location: ../../success_register?success=true');

		

	}else{
		if(isset($_POST['password']) && $_POST['password']!=''){
			$stmt = $conn->prepare('UPDATE `users` SET firstname=:firstname, lastname=:lastname, email=:email, password=:password, contact_no=:contact_no, add_1=:add_1, add_2=:add_2, city=:city, post_code=:post_code, date_modified=:date_modified WHERE id=:id');			
	
			$stmt->execute(array(
	
				':firstname' => $_POST['firstname'],
	
				':lastname' => $_POST['lastname'],
	
				':email' => $_POST['email'],
	
				':password' => md5($_POST['password']),
	
				':contact_no' => $_POST['contact_no'],
	
				':add_1' => $_POST['add_1'],
	
				':add_2' => $_POST['add_2'],
	
				':city' => $_POST['city'],
	
				':post_code' => $_POST['post_code'],
	
				':date_modified' => date('Y-m-d H:i:s a'),
				
				':id' => $_POST['id'],
	
			));	

		}else{
			$stmt = $conn->prepare('UPDATE `users` SET firstname=:firstname, lastname=:lastname, email=:email, contact_no=:contact_no, add_1=:add_1, add_2=:add_2, city=:city, post_code=:post_code, date_modified=:date_modified WHERE id=:id');			
	
			$stmt->execute(array(
	
				':firstname' => $_POST['firstname'],
	
				':lastname' => $_POST['lastname'],
	
				':email' => $_POST['email'],
	
				':contact_no' => $_POST['contact_no'],
	
				':add_1' => $_POST['add_1'],
	
				':add_2' => $_POST['add_2'],
	
				':city' => $_POST['city'],
	
				':post_code' => $_POST['post_code'],
	
				':date_modified' => date('Y-m-d H:i:s a'),
				
				':id' => $_POST['id'],
	
			));
		}
		header('Location: ../../editprofile?success=true');
	}