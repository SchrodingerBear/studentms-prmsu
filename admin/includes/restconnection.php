<?php 
date_default_timezone_set('Asia/Manila');
  // DB credentials.
define('DB_HOST','localhost');
define('DB_USER','u894050821_prmsu');
define('DB_PASS','@Di4$AY|');
define('DB_NAME','u894050821_prmsu');

  // Establish database connection.
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  // Check connection
  if ($conn->connect_error) {
      exit("Error: " . $conn->connect_error);
  }

  // Set character set to utf8
  $conn->set_charset("utf8");
?>