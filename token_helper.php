<?php

	include('config/db.php');

	function ($user_id, $token) {
		$errors = array();
		$user_verify_query = "SELECT * FROM session WHERE user_id='$username' token='$token' and LIMIT 1";
		$result = mysqli_query($db, $user_verify_query);
		$user = mysqli_fetch_assoc($result);

		if(count($user) > 0) {
			if(time() > $user['expiry_time']) {
				array_push($errors, "Session expired, Please login again");
			}
		} else {
			array_push($errors, "User not logged in, Please login");
		}
		return $errors;
	}
	
?>