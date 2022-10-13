<?php
	// Database connection
	include('config/db.php');

    $action = mysqli_real_escape_string($db, $_GET['action']);
    $amount = mysqli_real_escape_string($db, $_GET['amount']);

    $user_id = $_COOKIE['user_id'];
    $token = $_COOKIE['token'];

    $user_check_query = "SELECT * FROM session WHERE user_id='$user_id' and token='$token' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $session_info = mysqli_fetch_assoc($result);

    if(count($session_info)>0){
        if(time()>$session_info["expiry_time"]){
            print("Session Expired! Please Login again!");
        }
        
        else{
            $user_check_query = "SELECT balance FROM bank WHERE user_id='$user_id' LIMIT 1";
            $result = mysqli_query($db, $user_check_query);
            $balance = mysqli_fetch_assoc($result);
            $balance = $balance["balance"];
            if ($action === "deposit") {
                $balance = $balance + $amount;
                $user_check_query = "UPDATE bank set balance='$balance' WHERE user_id='$user_id' LIMIT 1";
                $result = mysqli_query($db, $user_check_query);
                print($balance);
            }
            elseif($action === "balance") {
                print($balance);
            }
            elseif($action === "close"){
                $user_check_query = "DELETE FROM bank WHERE user_id='$user_id' LIMIT 1";
                $result = mysqli_query($db, $user_check_query);
            }
            elseif($action === "withdraw"){
                if($amount>$balance){
                    print("Not enough balance");
                }
                else{
                    $balance = $balance - $amount;
                    $user_check_query = "UPDATE bank set balance='$balance' WHERE user_id='$user_id' LIMIT 1";
                    $result = mysqli_query($db, $user_check_query);
                    print($balance);    
                }
            }
        }
    }
    else{
        print("Please Login again!");
    }  
?>