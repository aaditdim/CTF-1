<?php
	// Database connection
	include('config/db.php');

	function generateRandomString($length = 50) {
	    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}

	$username = mysqli_real_escape_string($db, $_GET['user']);
	$password = mysqli_real_escape_string($db, $_GET['pass']);

	if(empty($username) || empty($password)) {
		print("Please provide username and password");
	} else {
		mysqli_report(MYSQLI_REPORT_ERROR);
		$stmt = $db->prepare("SELECT * FROM bank WHERE user_id=? LIMIT 1");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$result = $stmt->get_result();

		if($result->num_rows > 0) {
			$user = $result->fetch_assoc();
			if(password_verify($password, $user["password"])) {

		                $token = generateRandomString();
		                $expiry = time() + 300;

				$stmt = $db->prepare("REPLACE INTO session (user_id, token, expiry_time) VALUES(?, ?, ?)");
				$stmt->bind_param("ssi", $username, $token, $expiry);
				$stmt->execute();

				#$insert_token = "REPLACE INTO `session` (`user_id`, `token`, `expiry_time`) VALUES('$username', '$token', '$expiry')";
		                #if(mysqli_query($db, $insert_token)) {
				#	error_log("New record created successfully");
				#} else {
				#	error_log("Error: " . $sql . "<br>" . mysqli_error($db));
				#}

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
