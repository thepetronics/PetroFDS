<?php

include_once 'class.phpmailer.php';

include_once 'class.pop3.php';

include_once 'class.smtp.php';

include_once '../app/themes/lib/system.lib.php';

$conn = PetroFDS::ConnectDB();

$sql = 'SELECT COUNT(*) as Total FROM `order_details` WHERE status=0 AND email_send=0 AND date_created < DATE_SUB(NOW(),INTERVAL 30 MINUTE)';		  

$stmt = $conn->prepare($sql);

$stmt->execute();

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if($rows){
	foreach($rows as $row){
		$PendingOrders = $row['Total'];
	}
	$mail = new PHPMailer;

	//Enable SMTP debugging. 
	
	$mail->SMTPDebug = false;                               
	
	//Set PHPMailer to use SMTP.
	
	$mail->isSMTP();            
	
	//Set SMTP host name                          
	
	$mail->Host = "localhost";
	
	//Set this to true if SMTP host requires authentication to send email
	
	$mail->SMTPAuth = true;                          
	
	//Provide username and password     
	
	$mail->Username = PetroFDS::get_email_config('info_email');                 

	$mail->Password = PetroFDS::Safe_Decrypt(PetroFDS::get_email_config('info_email_pass'),'info');                        
	
	//If SMTP requires TLS encryption then set it
	
	//$mail->SMTPSecure = "tls";                           
	
	//Set TCP port to connect to 
	
	//$mail->Port = 587;                                   
	
	//Set From
	$mail->From = PetroFDS::get_email_config('info_email');
	//Set From name
	$mail->FromName = "PetroFDS-AutomateEmailBot DO NOT REPLY";
	
	
	//Set AddAddress for whom you want to send emails with subjects
	$mail->addAddress(PetroFDS::get_email_config('admin_email'), 'Administrator');
	$mail->Subject = 'Notification for Pending Orders';
	
	$mail->isHTML(true);
	
	$mail->CharSet="UTF-8";
	
	$body = 'This Email Send You To Notify That You Have <b>'.$PendingOrders.'</b> Pending Orders. Which time is greater than 30 sharp minutes Please Delivered/Decline Or Accept the order as soon as possible.<br/> 
<b>Regards,<br/> 
PetroFDS-AutomateEmailBot<br/>
Thanks</b>.';
	
	//Set MsgBody as HTML
	$mail->msgHTML($body);
	
	//Send Email
	if(!$mail->send()) 
	
	{
		echo "Mailer Error: " . $mail->ErrorInfo;
	} 
	else 
	
	{
		echo 'Success';
	}
}

$sql_user = 'SELECT id, user_id, email_send, status FROM `order_details`';		  

$stmt_user = $conn->prepare($sql_user);

$stmt_user->execute();

$rows_user = $stmt_user->fetchAll(PDO::FETCH_ASSOC);

if($rows_user){
	foreach($rows_user as $row_user){
		$status = $row_user['status'];
		$email_send = $row_user['email_send'];
		if(isset($status,$email_send) && $status==0 && $email_send==''){
			$sql_get_user = 'SELECT * FROM `users` WHERE id="'.$row_user['user_id'].'"';		  

			$stmt_get_user = $conn->prepare($sql_get_user);
			
			$stmt_get_user->execute();
			
			$rows_get_user = $stmt_get_user->fetchAll(PDO::FETCH_ASSOC);
			
			if($rows_get_user){
				foreach($rows_get_user as $row_get_user){
				
					$mail = new PHPMailer;
		
					//Enable SMTP debugging. 
					
					$mail->SMTPDebug = false;                               
					
					//Set PHPMailer to use SMTP.
					
					$mail->isSMTP();            
					
					//Set SMTP host name                          
					
					$mail->Host = "localhost";
					
					//Set this to true if SMTP host requires authentication to send email
					
					$mail->SMTPAuth = true;                          
					
					//Provide username and password     
					
					$mail->Username = PetroFDS::get_email_config('info_email');                 

					$mail->Password = PetroFDS::Safe_Decrypt(PetroFDS::get_email_config('info_email_pass'),'info');                         
					
					//If SMTP requires TLS encryption then set it
					
					//$mail->SMTPSecure = "tls";                           
					
					//Set TCP port to connect to 
					
					//$mail->Port = 587;                                   
					
					//Set From
					$mail->From = PetroFDS::get_email_config('info_email');
					//Set From name
					$mail->FromName = "PetroFDS-AutomateEmailBot DO NOT REPLY";
					
					
					//Set AddAddress for whom you want to send emails with subjects
					$mail->addAddress($row_get_user['email'], $row_get_user['firstname'].' '.$row_get_user['lastname']);
					$mail->Subject = 'Notification About Order '.$row_user['id'];
					
					$mail->isHTML(true);
					
					$mail->CharSet="UTF-8";
					
					$body = 'This Email Send You To Notify That Your Order holds on Pending. After Sometime you received email for accepting or declining of order.<br/> 
				<b>Regards,<br/> 
				PetroFDS-AutomateEmailBot<br/>
				Thanks</b>.';
					
					//Set MsgBody as HTML
					$mail->msgHTML($body);
					
					//Send Email
					if(!$mail->send()) 
					
					{
						echo "Mailer Error: " . $mail->ErrorInfo;
					} 
					else 
					
					{
						$sql_update_email_status = 'UPDATE order_details SET email_send="ACCEPT/DECLINE" WHERE user_id="'.$row_get_user['id'].'" AND id="'.$row_user['id'].'" AND status=0';
						
						$update_email_status = $conn->prepare($sql_update_email_status);
			
						$update_email_status->execute();
					}
				}
			}
		}else if(isset($status,$email_send) && $status==1 && $email_send=='ACCEPT/DECLINE'){
			$sql_get_user = '
			SELECT `users`.id as id, `users`.email as email, `users`.firstname as firstname, `users`.lastname as lastname,`order_details`.order_time as order_time, `order_details`.id as order_detail_id FROM `users` LEFT JOIN `order_details` ON `users`.id = `order_details`.user_id WHERE `users`.id="'.$row_user['user_id'].'" AND `order_details`.id="'.$row_user['id'].'"
			';		  

			$stmt_get_user = $conn->prepare($sql_get_user);
			
			$stmt_get_user->execute();
			
			$rows_get_user = $stmt_get_user->fetchAll(PDO::FETCH_ASSOC);
			
			if($rows_get_user){
				foreach($rows_get_user as $row_get_user){
					
					
				
					$mail = new PHPMailer;
		
					//Enable SMTP debugging. 
					
					$mail->SMTPDebug = false;                               
					
					//Set PHPMailer to use SMTP.
					
					$mail->isSMTP();            
					
					//Set SMTP host name                          
					
					$mail->Host = "localhost";
					
					//Set this to true if SMTP host requires authentication to send email
					
					$mail->SMTPAuth = true;                          
					
					//Provide username and password     
					
					$mail->Username = PetroFDS::get_email_config('info_email');                 

					$mail->Password = PetroFDS::Safe_Decrypt(PetroFDS::get_email_config('info_email_pass'),'info');                           
					
					//If SMTP requires TLS encryption then set it
					
					//$mail->SMTPSecure = "tls";                           
					
					//Set TCP port to connect to 
					
					//$mail->Port = 587;                                   
					
					//Set From
					$mail->From = PetroFDS::get_email_config('info_email');
					//Set From name
					$mail->FromName = "PetroFDS-AutomateEmailBot DO NOT REPLY";
					
					
					//Set AddAddress for whom you want to send emails with subjects
					$mail->addAddress($row_get_user['email'], $row_get_user['firstname'].' '.$row_get_user['lastname']);
					$mail->Subject = 'Notification About Order '.$row_get_user['order_detail_id'];
					
					$mail->isHTML(true);
					
					$mail->CharSet="UTF-8";
					
					$body = 'This Email Send You To Notify That Your Order is being Accepted. After <b>'.$row_get_user['order_time'].'</b> minutes you received a delivery of your order.<br/> 
				<b>Regards,<br/> 
				PetroFDS-AutomateEmailBot<br/>
				Thanks</b>.';
					
					//Set MsgBody as HTML
					$mail->msgHTML($body);
					
					//Send Email
					if(!$mail->send()) 
					
					{
						echo "Mailer Error: " . $mail->ErrorInfo;
					} 
					else 
					{
						$sql_update_email_status = 'UPDATE order_details SET email_send="ACCEPT" WHERE user_id="'.$row_get_user['id'].'" AND email_send="ACCEPT/DECLINE" AND id="'.$row_get_user['order_detail_id'].'" AND status=1';
						
						$update_email_status = $conn->prepare($sql_update_email_status);
			
						$update_email_status->execute();
					}
				}
			}
		}else if(isset($status,$email_send) && $status==1 && $email_send=='DECLINE'){
			$sql_get_user = '
			SELECT `users`.id as id, `users`.email as email, `users`.firstname as firstname, `users`.lastname as lastname,`order_details`.order_time as order_time, `order_details`.id as order_detail_id FROM `users` LEFT JOIN `order_details` ON `users`.id = `order_details`.user_id WHERE `users`.id="'.$row_user['user_id'].'" AND `order_details`.id="'.$row_user['id'].'"
			';			  

			$stmt_get_user = $conn->prepare($sql_get_user);
			
			$stmt_get_user->execute();
			
			$rows_get_user = $stmt_get_user->fetchAll(PDO::FETCH_ASSOC);
			
			if($rows_get_user){
				foreach($rows_get_user as $row_get_user){
				
					$mail = new PHPMailer;
		
					//Enable SMTP debugging. 
					
					$mail->SMTPDebug = false;                               
					
					//Set PHPMailer to use SMTP.
					
					$mail->isSMTP();            
					
					//Set SMTP host name                          
					
					$mail->Host = "localhost";
					
					//Set this to true if SMTP host requires authentication to send email
					
					$mail->SMTPAuth = true;                          
					
					//Provide username and password     
					
					$mail->Username = PetroFDS::get_email_config('info_email');                 

					$mail->Password = PetroFDS::Safe_Decrypt(PetroFDS::get_email_config('info_email_pass'),'info');                           
					
					//If SMTP requires TLS encryption then set it
					
					//$mail->SMTPSecure = "tls";                           
					
					//Set TCP port to connect to 
					
					//$mail->Port = 587;                                   
					
					//Set From
					$mail->From = PetroFDS::get_email_config('info_email');
					//Set From name
					$mail->FromName = "PetroFDS-AutomateEmailBot DO NOT REPLY";
					
					
					//Set AddAddress for whom you want to send emails with subjects
					$mail->addAddress($row_get_user['email'], $row_get_user['firstname'].' '.$row_get_user['lastname']);
					$mail->Subject = 'Notification About Order '.$row_get_user['order_detail_id'];
					
					$mail->isHTML(true);
					
					$mail->CharSet="UTF-8";
					
					$body = 'This Email Send You To Notify That Your Order is being Accepted. After <b>'.$row_get_user['order_time'].'</b> minutes you received a delivery of your order.<br/> 
				<b>Regards,<br/> 
				PetroFDS-AutomateEmailBot<br/>
				Thanks</b>.';
					
					//Set MsgBody as HTML
					$mail->msgHTML($body);
					
					//Send Email
					if(!$mail->send()) 
					
					{
						echo "Mailer Error: " . $mail->ErrorInfo;
					} 
					else 
					
					{
						$sql_update_email_status = 'UPDATE order_details SET email_send="ACCEPT" WHERE user_id="'.$row_get_user['id'].'" AND email_send="DECLINE" AND id="'.$row_get_user['order_detail_id'].'" AND status=1';
						
						$update_email_status = $conn->prepare($sql_update_email_status);
			
						$update_email_status->execute();
					}
				}
			}
		}else if(isset($status,$email_send) && $status==3 && $email_send=='ACCEPT/DECLINE'){
			$sql_get_user = '
			SELECT `users`.id as id, `users`.email as email, `users`.firstname as firstname, `users`.lastname as lastname,`order_details`.decline_reason as decline_reason, `order_details`.id as order_detail_id FROM `users` LEFT JOIN `order_details` ON `users`.id = `order_details`.user_id WHERE `users`.id="'.$row_user['user_id'].'" AND `order_details`.id="'.$row_user['id'].'"
			';			  

			$stmt_get_user = $conn->prepare($sql_get_user);
			
			$stmt_get_user->execute();
			
			$rows_get_user = $stmt_get_user->fetchAll(PDO::FETCH_ASSOC);
			
			if($rows_get_user){
				foreach($rows_get_user as $row_get_user){
				
					$mail = new PHPMailer;
		
					//Enable SMTP debugging. 
					
					$mail->SMTPDebug = false;                               
					
					//Set PHPMailer to use SMTP.
					
					$mail->isSMTP();            
					
					//Set SMTP host name                          
					
					$mail->Host = "localhost";
					
					//Set this to true if SMTP host requires authentication to send email
					
					$mail->SMTPAuth = true;                          
					
					//Provide username and password     
					
					$mail->Username = PetroFDS::get_email_config('info_email');                 

					$mail->Password = PetroFDS::Safe_Decrypt(PetroFDS::get_email_config('info_email_pass'),'info');
					
					//If SMTP requires TLS encryption then set it
					
					//$mail->SMTPSecure = "tls";                           
					
					//Set TCP port to connect to 
					
					//$mail->Port = 587;                                   
					
					//Set From
					$mail->From = PetroFDS::get_email_config('info_email');
					//Set From name
					$mail->FromName = "PetroFDS-AutomateEmailBot DO NOT REPLY";
					
					
					//Set AddAddress for whom you want to send emails with subjects
					$mail->addAddress($row_get_user['email'], $row_get_user['firstname'].' '.$row_get_user['lastname']);
					$mail->Subject = 'Notification About Order '.$row_get_user['order_detail_id'];
					
					$mail->isHTML(true);
					
					$mail->CharSet="UTF-8";
					
					$body = 'This Email Send You To Notify That Your Order is being Declined. Reason: <b>'.$row_get_user['decline_reason'].'</b>.<br/> 
				<b>Regards,<br/> 
				PetroFDS-AutomateEmailBot<br/>
				Thanks</b>.';
					
					//Set MsgBody as HTML
					$mail->msgHTML($body);
					
					//Send Email
					if(!$mail->send()) 
					
					{
						echo "Mailer Error: " . $mail->ErrorInfo;
					} 
					else 
					
					{
						$sql_update_email_status = 'UPDATE order_details SET email_send="DECLINE" WHERE user_id="'.$row_get_user['id'].'" AND email_send="ACCEPT/DECLINE" AND id="'.$row_get_user['order_detail_id'].'" AND status=3';
						
						$update_email_status = $conn->prepare($sql_update_email_status);
			
						$update_email_status->execute();
					}
				}
			}
		}else if(isset($status,$email_send) && $status==3 && $email_send=='ACCEPT'){
			$sql_get_user = '
			SELECT `users`.id as id, `users`.email as email, `users`.firstname as firstname, `users`.lastname as lastname,`order_details`.decline_reason as decline_reason, `order_details`.id as order_detail_id FROM `users` LEFT JOIN `order_details` ON `users`.id = `order_details`.user_id WHERE `users`.id="'.$row_user['user_id'].'" AND `order_details`.id="'.$row_user['id'].'"
			';		  

			$stmt_get_user = $conn->prepare($sql_get_user);
			
			$stmt_get_user->execute();
			
			$rows_get_user = $stmt_get_user->fetchAll(PDO::FETCH_ASSOC);
			
			if($rows_get_user){
				foreach($rows_get_user as $row_get_user){
				
					$mail = new PHPMailer;
		
					//Enable SMTP debugging. 
					
					$mail->SMTPDebug = false;                               
					
					//Set PHPMailer to use SMTP.
					
					$mail->isSMTP();            
					
					//Set SMTP host name                          
					
					$mail->Host = "localhost";
					
					//Set this to true if SMTP host requires authentication to send email
					
					$mail->SMTPAuth = true;                          
					
					//Provide username and password     
					
					$mail->Username = PetroFDS::get_email_config('info_email');                 

					$mail->Password = PetroFDS::Safe_Decrypt(PetroFDS::get_email_config('info_email_pass'),'info');
					
					//If SMTP requires TLS encryption then set it
					
					//$mail->SMTPSecure = "tls";                           
					
					//Set TCP port to connect to 
					
					//$mail->Port = 587;                                   
					
					//Set From
					$mail->From = PetroFDS::get_email_config('info_email');
					//Set From name
					$mail->FromName = "PetroFDS-AutomateEmailBot DO NOT REPLY";
					
					
					//Set AddAddress for whom you want to send emails with subjects
					$mail->addAddress($row_get_user['email'], $row_get_user['firstname'].' '.$row_get_user['lastname']);
					$mail->Subject = 'Notification About Order '.$row_get_user['order_detail_id'];
					
					$mail->isHTML(true);
					
					$mail->CharSet="UTF-8";
					
					$body = 'This Email Send You To Notify That Your Order is being Declined. Reason: <b>'.$row_get_user['decline_reason'].'</b>.<br/> 
				<b>Regards,<br/> 
				PetroFDS-AutomateEmailBot<br/>
				Thanks</b>.';
					
					//Set MsgBody as HTML
					$mail->msgHTML($body);
					
					//Send Email
					if(!$mail->send()) 
					
					{
						echo "Mailer Error: " . $mail->ErrorInfo;
					} 
					else 
					
					{
						$sql_update_email_status = 'UPDATE order_details SET email_send="DECLINE" WHERE user_id="'.$row_get_user['id'].'" AND email_send="ACCEPT" AND id="'.$row_get_user['order_detail_id'].'" AND status=3';
						
						$update_email_status = $conn->prepare($sql_update_email_status);
			
						$update_email_status->execute();
					}
				}
			}
		}
	}
}