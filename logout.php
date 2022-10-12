<?php
	// Database connection
	include('config/db.php');

    print_r($_COOKIE['user_id']);
    print_r($_COOKIE['token']);
    $user_id = $_COOKIE['user_id'];
    $token = $_COOKIE['token'];

    $session_delete_query = "DELETE FROM `session` WHERE user_id='$username' and token = '$token' LIMIT 1";
	$result = mysqli_query($db, $user_check_query);

	setcookie (session_id(), "", time() - 3600);
    print_r($_COOKIE);
    session_destroy();
    session_write_close();

    print("Logged Out Successfully!")
?>
