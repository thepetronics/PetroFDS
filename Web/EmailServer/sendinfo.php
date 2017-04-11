<?php

include_once 'class.phpmailer.php';

include_once 'class.pop3.php';

include_once 'class.smtp.php';

include_once '../app/themes/lib/system.lib.php';

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
$mail->FromName = "PetroFDS-Email-BOT";

$mail->addAddress(PetroFDS::get_email_config('admin_email'), 'Administrator');
$mail->Subject = $_POST['subject'];

//Address to which recipient will reply
$mail->addReplyTo($_POST['email'], $_POST['name']);

$mail->isHTML(true);

$mail->CharSet="UTF-8";

$body = $_POST['message'];

//Set MsgBody as HTML
$mail->msgHTML($body);

//Send Email
if(!$mail->send()) 

{

    echo "Mailer Error: " . $mail->ErrorInfo;

} 

else 

{
	header('Location:../contact?Success=true');
}