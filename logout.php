<?php
    // Database connection
    include('config/db.php');

    $user_id = $_COOKIE['user_id'];
    $token = $_COOKIE['token'];

    mysqli_report(MYSQLI_REPORT_ERROR);
    $stmt = $db->prepare("DELETE FROM `session` WHERE user_id=? and token =? LIMIT 1");
    $stmt->bind_param("ss", $user_id, $token);
    $stmt->execute();
    $result = $stmt->get_result();
    print($result);

    setcookie (session_id(), "", time() - 3600);
    session_destroy();
    session_write_close();

    print("Logged Out Successfully!")
?>