<?php
	// Database connection
	include('config/db.php');

    $action = mysqli_real_escape_string($db, $_GET['action']);
    $amount = mysqli_real_escape_string($db, $_GET['amount']);

    $user_id = $_COOKIE['user_id'];
    $token = $_COOKIE['token'];

    mysqli_report(MYSQLI_REPORT_ERROR);
    $stmt = $db->prepare("SELECT * FROM session WHERE user_id=? and token=? LIMIT 1");
    $stmt->bind_param("ss", $user_id, $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $session_info = $result->fetch_assoc();
    $stmt->close();

    print($session_info);

    if(count($session_info)>0){
        if(time()>$session_info["expiry_time"]){
            print("Session Expired! Please Login again!");
        }
        
        else{
            $stmt = $db->prepare("SELECT balance FROM bank WHERE user_id=? LIMIT 1");
            $stmt->bind_param("s", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $balance = $result->fetch_assoc();
            $balance = $balance["balance"];
            $stmt->close();

            if ($action === "deposit") {
                $balance = $balance + $amount;

                $stmt = $db->prepare("UPDATE bank set balance='$balance' WHERE user_id=? LIMIT 1");
                $stmt->bind_param("s", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                print($balance);
            }
            elseif($action === "balance") {
                print($balance);
            }
            elseif($action === "close"){
                $stmt = $db->prepare("DELETE FROM bank WHERE user_id=? LIMIT 1");
                $stmt->bind_param("s", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
            }
            elseif($action === "withdraw"){
                if($amount>$balance){
                    print("Not enough balance");
                }
                else{
                    $balance = $balance - $amount;

                    $stmt = $db->prepare("UPDATE bank set balance='$balance' WHERE user_id=? LIMIT 1");
                    $stmt->bind_param("s", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();

                    print($balance);    
                }
            }
        }
    }
    else{
        print("Please Login again!");
    }  
?>