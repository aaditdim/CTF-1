<?php
	// Database connection
	include('config/db.php');
	session_start();
	// $db = mysqli_connect('localhost', 'bank3db', 'BakeshopSequelHenceExpansionAptlyEverglade', 'users');


	function generateRandomString($length = 50) {
	    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}

	$username = mysqli_real_escape_string($db, $_GET['user']);
	$password = mysqli_real_escape_string($db, $_GET['pass']);

	if(empty($username) || empty($password)) {
		print("Please provide username and password");
	} else {
		print("cookie");
		print_r($_COOKIE);
		print("cookie print end here\n");
		
		#$stmt = $db->prepare("SELECT * FROM bank WHERE user_id=? LIMIT 1");
		#$stmt->bind_param("s", $username);
		#$stmt->execute();
		#$result = $stmt->get_result();

		$user_check_query = "SELECT * FROM bank WHERE user_id='$username' LIMIT 1";
		$result = mysqli_query($db, $user_check_query);
		$user = mysqli_fetch_assoc($result);
	
		if(count($user) > 0) { // valid user exist
		#if($result->num_rows > 0) {
			#$user = $result->fetch_assoc();
			if(password_verify($password, $user["password"])) {

		                $token = generateRandomString();
		                $expiry = time() + 300;
		                $insert_token = "INSERT INTO `session` (`user_id`, `token`, `expiry_time`) VALUES('$username', '$token', '$expiry')";
		                mysqli_query($db, $insert_token);
		                setcookie("user_id", $username);
		                setcookie("token", $token);
	
				error_log("Valid password", 0);
				print('You are now logged in <br>');
			} else {
			//TO DO: log this attemt as failed
				error_log("Invalid password", 0);
				print('Invaalid password\n');
			}
		} else {
			error_log("User doesn't exits", 0);
			print('User doesnt exists\n');
		}
	}
?>
