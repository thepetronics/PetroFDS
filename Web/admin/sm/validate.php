<?php
require_once('../../app/themes/lib/system.lib.php');
$conn = PetroFDS::ConnectDB();
$user = strip_tags(trim($_REQUEST['username']));
 
if(strlen($user) <= 0)
{
  echo json_encode(array('code'  =>  -1,
  'result'  =>  'Invalid username, please try again.'
  ));
  die;
}

$query = "SELECT * FROM admin WHERE username='$user' ";
$stmt = $conn->prepare($query);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
if(!$rows)
{
  echo json_encode(array('code'  =>  1,
  'result'  =>  "Success,username $user is still available"
  ));
  die;
}
else
{
  echo  json_encode(array('code'  =>  0,
  'result'  =>  "Sorry but username $user is already taken."
  ));
  die;
}
die;
?>