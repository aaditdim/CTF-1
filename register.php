<?php
session_start();

// initializing variables
$username = "";
$errors = array();

// connect to the database
$db = mysqli_connect('localhost', 'bank3db', 'BakeshopSequelHenceExpansionAptlyEverglade', 'users');
if($db){
      print("Connection Established Successfully");
   }else{
      print("Connection Failed ");
   }
//print_r($_GET);
// receive all input values from the form
$username = mysqli_real_escape_string($db, $_GET['username']);
$password_1 = mysqli_real_escape_string($db, $_GET['password']);

// form validation: ensure that the form is correctly filled ...
// by adding (array_push()) corresponding error unto $errors array
if (empty($username)) { array_push($errors, "Username is required"); }
if (empty($password_1)) { array_push($errors, "Password is required"); }

// first check the database to make sure 
// a user does not already exist with the same username and/or email
$user_check_query = "SELECT * FROM bank WHERE user_id='$username' LIMIT 1";
$result = mysqli_query($db, $user_check_query);
$user = mysqli_fetch_assoc($result);

if ($user) { // if user exists
if ($user['username'] === $username) {
    array_push($errors, "Username already exists");
}
}
// Finally, register user if there are no errors in the form
if (count($errors) == 0) {
    $password = sha1($password_1);//encrypt the password before saving in the database

    $query = "INSERT INTO `bank` (`user_id`, `password`) 
                VALUES('$username', '$password');";
    mysqli_query($db, $query);

    $user_check_query = "SELECT * FROM bank";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    print_r($user);

    $_SESSION['username'] = $username;
    $_SESSION['success'] = "You are now logged in";
    print('Registered successfully!');
} else {
    print 'Unsuccesfull! Try again';
    print_r($errors);
}
?>