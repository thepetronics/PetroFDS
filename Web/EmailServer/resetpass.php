<?php

include_once 'class.phpmailer.php';

include_once 'class.pop3.php';

include_once 'class.smtp.php';



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

$mail->Username = PetroFDS::get_email_config('admin_email');                 

$mail->Password = PetroFDS::Safe_Decrypt(PetroFDS::get_email_config('admin_email_pass'),'admin');                           

//If SMTP requires TLS encryption then set it

//$mail->SMTPSecure = "tls";                           

//Set TCP port to connect to 

//$mail->Port = 587;                                   

//Set From
$mail->From = PetroFDS::get_email_config('admin_email');
//Set From name
$mail->FromName = "PetroFDS";


//Set AddAddress for whom you want to send emails with subjects
$mail->addAddress($email, $row['firstname'].' '.$row['lastname']);
$mail->Subject = 'Password Changed Successfully of '.$row['firstname'].' '.$row['lastname'].'';

$mail->addAddress(PetroFDS::get_email_config('admin_email'), 'Administrator');

$mail->isHTML(true);

$mail->CharSet="UTF-8";

$body='<h1>Your New Password is 1234 Please changed it when you logged in next time.</h1>';

//Set MsgBody as HTML
$mail->msgHTML($body);

//Send Email
if(!$mail->send()) 

{
    echo "Mailer Error: " . $mail->ErrorInfo;
} 
else 
{
    echo "Password Changed, Please Check Your email for new passowrd";
}