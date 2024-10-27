<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $student_id = $_POST['student_id']; // Get the student ID from the form
    $violation_date = $_POST['violation_date'];
    $violation_type = $_POST['violation_type'];
    $description = $_POST['description'];
    $Sanction = $_POST['Sanction'];
    $penalty = $_POST['penalty'];

    // Insert the violation directly without checking for existing ones
    $sql = "INSERT INTO tblviolations (student_id, violation_date, violation_type, description, Sanction, penalty) 
            VALUES (:student_id, :violation_date, :violation_type, :description, :Sanction, :penalty)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
    $query->bindParam(':violation_date', $violation_date, PDO::PARAM_STR);
    $query->bindParam(':violation_type', $violation_type, PDO::PARAM_STR);
    $query->bindParam(':description', $description, PDO::PARAM_STR);
    $query->bindParam(':Sanction', $Sanction, PDO::PARAM_INT);
    $query->bindParam(':penalty', $penalty, PDO::PARAM_STR);

    $query->execute();

    $LastInsertId = $dbh->lastInsertId();
    if ($LastInsertId > 0) {
      // Toast notification for successful addition
      echo "
      <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
      <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
      <div class='toast-container position-fixed top-0 start-50 translate-middle-x p-3'>
          <div id='offenseAddedToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' style='background-color: #1c82e6; color: white;'>
              <div class='toast-body'>
                  Offense has been successfully added.
              </div>
          </div>
      </div>
      <script>
          var offenseAddedToast = new bootstrap.Toast(document.getElementById('offenseAddedToast'));
          offenseAddedToast.show();
      </script>
      ";
    } else {
      echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
  }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="icon" href="../images/logo.png" type="image/png">
  <title>STUDENT HANDBOOK ASSISTANCE | Manage Violations</title>
  <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/select2/select2.min.css">
  <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
  <div class="container-scroller">
    <?php include_once('includes/header.php'); ?>
    <div class="container-fluid page-body-wrapper">
      <?php include_once('includes/sidebar.php'); ?>
      <div class="main-panel">
        <div class="content-wrapper"style="background-color: #c71d68;">>
          <div class="page-header">
            
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                
              </ol>
            </nav>
          </div>
          <div class="row">
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title" style="text-align: center;">Add Offense</h4>
                  <form class="forms-sample" method="post">
                    <div hidden class="form-group">
                      <label for="student_id">Student ID</label>
                      <select name="student_id" class="form-control select2" style="width:100%" required='true'>
                        <?php
                        // Fetching existing students
                        $sql = "SELECT id, StudentName FROM tblstudent";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        if ($query->rowCount() > 0) {
                          foreach ($results as $result) {
                            echo "<option value='" . htmlentities($result->id) . "'>" . htmlentities($result->StudentName) . " : " . htmlentities($result->id) . "</option>";
                          }
                        }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="violation_date">Violation Date</label>
                      <input type="date" name="violation_date" class="form-control custom-input" required style="border: 1px solid #acb7c2; outline: none;">
                    </div>
                    <div class="form-group">
                      <label for="violation_type">Violation Type</label>
                      <select name="violation_type" class="form-control select2" style="width:100%" required='true'>
                        <?php
                        // Fetching existing violation types
                        $sql = "SELECT DISTINCT violation_type FROM tblviolations";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        if ($query->rowCount() > 0) {
                          foreach ($results as $result) {
                            echo "<option value='" . htmlentities($result->violation_type) . "'>" . htmlentities($result->violation_type) . "</option>";
                          }
                        }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="description">Offense</label>
                      <select name="description" class="form-control select2" style="width:100%" required='true'>
                        <option value="">Select Offense</option>
                        <?php
                        // Fetching existing offenses
                        $sql = "SELECT DISTINCT description FROM tblviolations";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        if ($query->rowCount() > 0) {
                          foreach ($results as $result) {
                            echo "<option value='" . htmlentities($result->description) . "'>" . htmlentities($result->description) . "</option>";
                          }
                        }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="sanction">Sanction</label>
                      <select name="Sanction" class="form-control select2" style="width:100%" required='true'>
                        <option value="">Select Sanction</option>
                        <option value="1">1st Offense </option>
                        <option value="2">2nd Offense </option>
                        <option value="3">3rd Offense </option>
                      </select>
                    </div>


                    <div class="form-group">
                      <label for="penalty">Penalty</label>
                      <textarea id="penalty" name="penalty" class="form-control custom-input" required style="border: 1px solid #acb7c2; outline: none;"></textarea>
                    </div>

                   <button type="submit" class="custom-add-btn" name="submit">Add</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <?php include_once('includes/footer.php'); ?>

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

  <script>
    $(document).ready(function () {



      $('.select2').select2({
        tags: true,
        theme: 'bootstrap',
        createTag: function (params) {
          var term = $.trim(params.term);
          if (term === '') {
            return null;
          }

          return {
            id: term,
            text: term,
          };
        }
      });

      // Prevent automatic saving on space
      $(document).on('keypress', 'select[name="Sanction"], select[name="description"]', function (e) {
        if (e.which === 13) { // Check if Enter key is pressed
          e.preventDefault(); // Prevent the default form submission
          // I-save ang input o gawing available ito sa database
        }
      });
    });
  </script>
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
.custom-input,
.form-control {
    margin-bottom: 15px; /* Maglagay ng espasyo sa ibaba ng bawat input */
    padding: 10px; /* Magdagdag ng padding sa loob ng input fields */
    border: 1px solid #acb7c2; /* Panatilihin ang border */
    outline: none; /* Tanggalin ang default outline */
    border-radius: 5px; /* Magdagdag ng rounding sa mga sulok ng input */
}

</style>
</body>

</html>