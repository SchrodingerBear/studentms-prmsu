<?php 
date_default_timezone_set('Asia/Manila');
  // DB credentials.
  define('DB_HOST', 'localhost');
  define('DB_USER', 'root');
  define('DB_PASS', '');
  define('DB_NAME', 'studentmsdb');

  // Establish database connection.
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  // Check connection
  if ($conn->connect_error) {
      exit("Error: " . $conn->connect_error);
  }

  // Set character set to utf8
  $conn->set_charset("utf8");
?>