<?php
require_once('../../app/themes/lib/system.lib.php');
$conn = PetroFDS::ConnectDB();
$email = strip_tags(trim($_REQUEST['email']));
 
if(strlen($email) <= 0)
{
  echo json_encode(array('code'  =>  -1,
  'result'  =>  'Invalid email, please try again.'
  ));
  die;
}

$query = "SELECT * FROM users WHERE email='$email' ";
$stmt = $conn->prepare($query);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
if(!$rows)
{
  echo json_encode(array('code'  =>  1,
  'result'  =>  "Success,email $email is still available"
  ));
  die;
}
else
{
  echo  json_encode(array('code'  =>  0,
  'result'  =>  "Sorry but email $email is already taken."
  ));
  die;
}
die;
?>