<?php

include_once 'class.phpmailer.php';

include_once 'class.pop3.php';

include_once 'class.smtp.php';

$mail = new PHPMailer;



//Enable SMTP debugging. 

//$mail->SMTPDebug = 3;                               

//Set PHPMailer to use SMTP.

$mail->isSMTP();            

//Set SMTP host name                          

$mail->Host = "localhost";

//Set this to true if SMTP host requires authentication to send email

$mail->SMTPAuth = true;                          

//Provide username and password     

$mail->Username = PetroFDS::get_email_config('admin_email');                 

$mail->Password = PetroFDS::Safe_Decrypt(PetroFDS::get_email_config('admin_email_pass'),'admin');                           

//If SMTP requires TLS encryption then set it

//$mail->SMTPSecure = "tls";                           

//Set TCP port to connect to 

//$mail->Port = 587;                                   

//Set From
$mail->From = PetroFDS::get_email_config('admin_email');
//Set From name
$mail->FromName = "PetroFDS-Orderdetail-BOT";


//Set AddAddress for whom you want to send emails with subjects
if(isset($_SESSION['LOGIN_USER_ID'])){
	$mail->addAddress($_SESSION['LOGIN_USER_EMAIL'], $_SESSION['LOGIN_USER_FULLNAME']);
	$mail->Subject = 'Order # '.$order_detail_id.' of '.$_SESSION['LOGIN_USER_FULLNAME'].'';
}else{
	$mail->addAddress($row_user['email'], $row_user['firstname'].' '.$row_user['lastname']);
	$mail->Subject = 'Order # '.$order_detail_id.' of '.$row_user['firstname'].' '.$row_user['lastname'].'';
}
$mail->addAddress(PetroFDS::get_email_config('order_email'), 'Administrator');

ob_start();
include('../../admin/Orders/email_order.php');
$body = ob_get_clean();

//Set MsgBody as HTML
$mail->msgHTML($body);

$mail->isHTML(true);

$mail->CharSet="UTF-8";

//Send Email
if(!$mail->send()) 

{

    echo "Mailer Error: " . $mail->ErrorInfo;

} 

else 

{
	PetroFDS::EmptySessionCart($_SERVER['REMOTE_ADDR']);
}