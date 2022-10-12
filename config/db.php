<?php 
    // Enable us to use Headers
    ob_start();

    $hostname = "localhost";
    $username = "bank3db";
    $password = "BakeshopSequelHenceExpansionAptlyEverglade";
    $dbname = "users";

    $db = mysqli_connect($hostname, $username, $password, $dbname) or die("Database connection not established.")
?>