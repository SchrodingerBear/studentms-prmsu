<?php
include('../includes/restconnection.php');

  $student_id = $_POST['student_id'];
  $violation_date = $_POST['violation_date'];
  $violation_type = $_POST['violation_type'];
  $description = $_POST['description'];
  $Sanction = $_POST['Sanction'];
  $penalty = $_POST['penalty'];


  // Insert the new violation
  $stmt = $conn->prepare("INSERT INTO violations (student_id, violation_date, violation_type, description, Sanction, penalty) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt -> bind_param("isssis", $student_id, $violation_date, $violation_type, $description, $Sanction, $penalty);
  
  if ($stmt->execute()) {
      $response = [
          'status' => 'success',
          'message' => 'Violation has been added.',
      ];
  } else {
      $response = [
          'status' => 'error',
          'message' => 'Something went wrong. Please try again.',
      ];
  }
  

  // Close the statement and connection
  $stmt->close();
  $conn->close();

  // Return JSON response
  echo json_encode($response);
  exit();
?>