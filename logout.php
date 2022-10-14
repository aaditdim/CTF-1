<?php
    // Database connection
    include('config/db.php');

    $user_id = $_COOKIE['user_id'];
    $token = $_COOKIE['token'];

    $session_delete_query = "DELETE FROM `session` WHERE user_id='$user_id' and token = '$token' LIMIT 1";
    $result = mysqli_query($db, $session_delete_query);

    setcookie (session_id(), "", time() - 3600);
    session_destroy();
    session_write_close();

    print("Logged Out Successfully!")
?>