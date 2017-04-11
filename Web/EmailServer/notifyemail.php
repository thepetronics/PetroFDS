<?php

include_once 'class.phpmailer.php';

include_once 'class.pop3.php';

include_once 'class.smtp.php';

include_once '../app/themes/lib/system.lib.php';

$conn = PetroFDS::ConnectDB();

$sql = 'SELECT COUNT(*) as Total FROM `order_details` WHERE status=0';		  

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
$mail->From = 'Administrator';
//Set From name
$mail->FromName = "PetroFDS-AutomateEmailBOT DO NOT REPLY";


//Set AddAddress for whom you want to send emails with subjects
$mail->addAddress(PetroFDS::get_email_config('admin_email'), 'Administrator');
$mail->Subject = 'Notification for Pending Orders';

$mail->isHTML(true);

$mail->CharSet="UTF-8";

$body = 'This Email Send You To Notify That You Have '.$PendingOrders.' Pending Orders. Please Delivered/Decline Or Accept the order as soon as possible.<br/> 
<b>Regards,<br/> 
PetroFDS-AutomateEmailBot<br/>
Thanks</b>.
';

//Set MsgBody as HTML
$mail->msgHTML($body);

//Send Email
if(!$mail->send()) 

{
    echo "Mailer Error: " . $mail->ErrorInfo;
} 
else 

{
	$sql_getMobToken = 'SELECT * FROM mobile_token';
				
	$stmt_getMobToken = $conn->prepare($sql_getMobToken);
	
	$stmt_getMobToken->execute();
	
	$rows_getMobToken = $stmt_getMobToken->fetchAll(PDO::FETCH_ASSOC);
	
	if($rows_getMobToken){
	
		foreach($rows_getMobToken as $row_getMobToken){
			PetroFDS::SendMobileNotification($row_getMobToken['token'],'You Have '.$PendingOrders.' Pending Orders.');		
		}
	}
    echo 'Success';
}
}