<?php
// db_connect.inc

// Detect if running on Titan or local XAMPP
if (strpos($_SERVER['HTTP_HOST'], 'titan.csit.rmit.edu.au') !== false) {
    // Running on Titan
    $host = "titan.csit.rmit.edu.au";
    $user = "s3843976_jacob5";   
    $pass = "";  
    $dbname = "s3843976_jacob5";     
} else {
    // Running locally (XAMPP)
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "skillswap";
}

// Connect to MySQL
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
