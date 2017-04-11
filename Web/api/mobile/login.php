<?php



//load and connect to MySQL database stuff

require_once('../../app/themes/lib/system.lib.php');
$conn=PetroFDS::ConnectDB();



if (!empty($_POST)) {

    //gets user's info based off of a username.

    $query = " 

            SELECT 

                *

            FROM admin 

            WHERE 

                username = :username 

			AND

	        password = :password

        ";

    

    $query_params = array(

        ':username' => $_POST['username'],

		':password' => md5(''.$_POST['password'].'')

    );

    

    try {

        $stmt   = $conn->prepare($query);

        $result = $stmt->execute($query_params);

    }

    catch (PDOException $ex) {

        // For testing, you could use a die and message. 

        //die("Failed to run query: " . $ex->getMessage());

        

        //or just use this use this one to product JSON data:

        $response["success"] = 0;

        $response["message"] = "Database Error1. Please Try Again!";

        die(json_encode($response));

        

    }

    

    //This will be the variable to determine whether or not the user's information is correct.

    //we initialize it as false.

    $validated_info = false;

    

    //fetching all the rows from the query

    $row = $stmt->fetch();

    if ($row) {

        //if we encrypted the password, we would unencrypt it here, but in our case we just

        //compare the two passwords

        if (md5(''.$_POST['password'].'') === $row['password']) {

            $login_ok = true;

        }

		

    

    

    // If the user logged in successfully, then we send them to the private members-only page 

    // Otherwise, we display a login failed message and show the login form again 

    if ($login_ok) {

        $response["success"] = 1;

        $response["message"] = "Login successful!";

        $response["id"] = $row['id'];

		$response["firstname"] = $row['firstname'];

		$response["lastname"] = $row['lastname'];

		$response["email"] = $row['email'];

		$response["username"] = $_POST['username'];
		
		/** Start Token Information **/
		$sql_checkdevice = "SELECT * FROM mobile_token WHERE device_id='".$_POST['device_id']."'";
		
		$stmt_checkdevice   = $conn->prepare($sql_checkdevice);
		
		$stmt_checkdevice->execute();
		
		if($stmt_checkdevice->rowCount() > 0){
			$mobilequery = "UPDATE `mobile_token` SET `token`='".$_POST['token']."' WHERE device_id='".$_POST['device_id']."'";
		
			$stmt_mobile   = $conn->prepare($mobilequery);
		
			$result_mobile = $stmt_mobile->execute();
		}else{
			$mobilequery = "INSERT INTO `mobile_token`(`token`,`device_id`) VALUES ('".$_POST['token']."','".$_POST['device_id']."')";
		
			$stmt_mobile   = $conn->prepare($mobilequery);
		
			$result_mobile = $stmt_mobile->execute();
		}
		/** END Token Information **/
	}

        die(json_encode($response));

    } else {

        $response["success"] = 0;

        $response["message"] = "Invalid Credentials!";

        die(json_encode($response));

    }

} else {

?>

		<h1>Login</h1> 

		<form action="login.php" method="post"> 

		    Username:<br /> 

		    <input type="text" name="username" placeholder="username" /> 

		    <br /><br /> 

		    Password:<br /> 

		    <input type="password" name="password" placeholder="password" value="" /> 

		    <br /><br /> 

		    <input type="submit" value="Login" /> 

		</form> 

		<a href="register.php">Register</a>

	<?php

}



?> 

