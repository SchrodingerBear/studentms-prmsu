<?php

date_default_timezone_set('Asia/Manila');
// DB credentials.
define('DB_HOST', '153.92.15.30');
define('DB_USER', 'u894050821_prmsu');
define('DB_PASS', '@Di4$AY|');
define('DB_NAME', 'u894050821_prmsu');
// Establish database connection.
try {
  $dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

  // Remove students not reading for over an hour
  $removeLastSeen = "UPDATE tblstudent SET isReading = false WHERE last_seen < NOW() - INTERVAL 1 HOUR";
  $q = $dbh->prepare($removeLastSeen);
  $q->execute();

} catch (PDOException $e) {
  exit("Error: " . $e->getMessage());
}


function updateIsReading($studentId, $status)
{
  global $dbh;
  try {
    // Set timezone
    date_default_timezone_set('Asia/Manila');

    // Get current timestamp in PHP
    $currentTimestamp = date('Y-m-d H:i:s');

    // Update query using the PHP-generated timestamp
    $sql = "UPDATE tblstudent SET isReading = :status, last_seen = :lastSeen WHERE ID = :studentId";
    $query = $dbh->prepare($sql);

    // Bind the parameters
    $query->bindParam(':status', $status, PDO::PARAM_BOOL);
    $query->bindParam(':studentId', $studentId, PDO::PARAM_INT);
    $query->bindParam(':lastSeen', $currentTimestamp); // bind the PHP timestamp

    // Execute the query
    $query->execute();

  } catch (PDOException $e) {
    return "Error: " . $e->getMessage();
  }
}

?>