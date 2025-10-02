<?php
/* DB connection (local XAMPP by default) */
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'skillswap';   // the database you created in phpMyAdmin

$conn = @new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_error) {
  die('Database connection failed: ' . htmlspecialchars($conn->connect_error));
}
$conn->set_charset('utf8mb4');

/*
  When you deploy to Coreteaching + Jacob5 later, swap the values above to:
  $DB_HOST = 'jacob5.rmit.edu.au';
  $DB_USER = 'sXXXXXXX';   // your student user
  $DB_PASS = '********';
  $DB_NAME = 'sXXXXXXX';   // same as user on Jacob5
*/
