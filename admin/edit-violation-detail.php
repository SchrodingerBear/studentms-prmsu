<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Check if 'editid' is set in the URL
if (isset($_GET['editid'])) {
  $editid = intval($_GET['editid']); // Get the edit ID from the URL

  // Prepare and execute the select query
  $query = "SELECT * FROM violations WHERE id = :editid";
  $stmt = $dbh->prepare($query);
  $stmt->bindParam(':editid', $editid, PDO::PARAM_INT);
  $stmt->execute();
  $violation = $stmt->fetch(PDO::FETCH_ASSOC);

  // Check if the violation exists
  if (!$violation) {
    echo "Violation not found.";
    exit;
  }
} else {
  echo "Invalid ID.";
  exit;
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
  // Fetch form data
  $student_id = $_POST['student_id'];
  $violation_date = $_POST['violation_date'];
  $violation_type = $_POST['violation_type'];
  $description = $_POST['description'];
  $Sanction = $_POST['Sanction'];
  $penalty = $_POST['penalty'];

  // Prepare and execute the update query
  $updateQuery = "UPDATE tblviolations SET student_id = :student_id, violation_date = :violation_date, violation_type = :violation_type, description = :description, Sanction = :Sanction, penalty = :penalty WHERE id = :editid";
  $updateStmt = $dbh->prepare($updateQuery);
  $updateStmt->bindParam(':student_id', $student_id);
  $updateStmt->bindParam(':violation_date', $violation_date);
  $updateStmt->bindParam(':violation_type', $violation_type);
  $updateStmt->bindParam(':description', $description);
  $updateStmt->bindParam(':Sanction', $Sanction);
  $updateStmt->bindParam(':penalty', $penalty);
  $updateStmt->bindParam(':editid', $editid, PDO::PARAM_INT);

  try {
    if ($updateStmt->execute() && $updateStmt->rowCount() > 0) {
      // Success toast if rows were affected
      echo "
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
            <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
            <div class='toast-container position-fixed top-0 start-50 translate-middle-x p-3'>
                <div id='updateSuccessToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' style='background-color: #1c82e6; color: white;'>
                    <div class='toast-body'>
                        Violation has been successfully updated.
                    </div>
                </div>
            </div>
            <script>
                var updateSuccessToast = new bootstrap.Toast(document.getElementById('updateSuccessToast'));
                updateSuccessToast.show();
            </script>
            ";
    }
  } catch (PDOException $e) {
    // Error toast for database error
    echo "
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
        <div class='toast-container position-fixed top-0 start-50 translate-middle-x p-3'>
            <div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' style='background-color: #e63946; color: white;'>
                <div class='toast-body'>
                    Error: " . $e->getMessage() . "
                </div>
            </div>
        </div>
        <script>
            var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
            errorToast.show();
        </script>
        ";
  }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="icon" href="../images/logo.png" type="image/png">
  <title>STUDENT HANDBOOK ASSISTANCE |Update Students</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="vendors/select2/select2.min.css">
  <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php include_once('includes/header.php'); ?>
    <!-- Include header here -->
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php include_once('includes/sidebar.php'); ?>
      <!-- Include sidebar here -->
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper" style="background-color: #c71d68;">
          <div class="page-header">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php"></a></li>
                <li class="" aria-current="page"></li>
              </ol>
            </nav>
          </div>
          <div class="row">
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title" style="text-align: center;">Update Offense</h4>
                  <form class="forms-sample" method="post">
                    <div hidden class="form-group">
                      <label for="student_id">Student ID (Leave to 0 for template)</label>
                      <input type="text" name="student_id" class="form-control"
                        value="<?php echo htmlspecialchars($violation['student_id']); ?>" required>
                    </div>
                    <div hidden class="form-group">
                      <label for="violation_date">Violation Date</label>
                      <input type="date" name="violation_date" class="form-control"
                        value="<?php echo htmlspecialchars($violation['violation_date']); ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="violation_type">Violation Type</label>

                      <input type="text" name="violation_type" class="form-control custom-input" required
                        style="border: 1px solid #acb7c2;"
                        value="<?php echo htmlspecialchars($violation['violation_type']); ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="description">Description</label>
                      <textarea name="description" class="form-control custom-input" required
                        style="border: 1px solid #acb7c2; outline: none;"><?php echo htmlspecialchars($violation['description']); ?></textarea>
                    </div>
                    <div class="form-group">
                      <label for="Sanction">Sanction</label>
                      <select name="Sanction" class="form-control custom-input" required
                        style="border: 1px solid #acb7c2; outline: none;">
                        <option value="" disabled selected hidden>Select sanction</option> <!-- Placeholder -->
                        <option value="1" <?php echo ($violation['Sanction'] == '1') ? 'selected' : ''; ?>>1st Offense
                        </option>
                        <option value="2" <?php echo ($violation['Sanction'] == '2') ? 'selected' : ''; ?>>2nd Offense
                        </option>
                        <option value="3" <?php echo ($violation['Sanction'] == '3') ? 'selected' : ''; ?>>3rd Offense
                        </option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="penalty">Penalty</label>
                      <textarea id="penalty" name="penalty" class="form-control custom-input" required
                        style="border: 1px solid #acb7c2; outline: none;"><?php echo htmlspecialchars($violation['penalty']); ?></textarea>


                      <div class="mt-4">
                        <button type="submit" class="custom-add-btn" name="submit">Update</button>
                      </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Include footer here -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="vendors/select2/select2.min.js"></script>
  <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page -->
  <script src="js/typeahead.js"></script>
  <script src="js/select2.js"></script>
  <!-- End custom js for this page -->


  <style>
    .custom-add-btn {
      background-color: #1c82e6;
      color: #fff;
      border: none;
      padding: 10px 50px;
      border-radius: 30px;
      font-weight: bold;
      font-size: 20px;
      transition: background-color 0.3s ease;
    }

    .custom-add-btn:hover {
      background-color: #155ba0;
      color: #fff;
      cursor: pointer;
    }
  </style>
</body>

</html>