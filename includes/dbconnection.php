<?php
date_default_timezone_set('Asia/Manila');
// DB credentials.
define('DB_HOST', '153.92.15.30');
define('DB_USER', 'u894050821_prmsu');
define('DB_PASS', '@Di4$AY|');
define('DB_NAME', 'u894050821_prmsu');
//require_once 'admin/vendors/select2-bootstrap-theme/i.php';
try {
  $dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
  exit("Error: " . $e->getMessage());
}
?>