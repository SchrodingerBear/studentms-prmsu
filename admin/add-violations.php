<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $student_id = $_POST['student_id'];
    $violation_date = $_POST['violation_date'];
    $violation_type = $_POST['violation_type'];
    $description = $_POST['description'];
    $Sanction = $_POST['Sanction'];
    $penalty = $_POST['penalty'];

    // Check for existing violations for the same student and date
    $ret = "SELECT * FROM tblviolations WHERE student_id = :student_id AND violation_date = :violation_date";
    $query = $dbh->prepare($ret);
    $query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
    $query->bindParam(':violation_date', $violation_date, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() == 0) {
      $sql = "INSERT INTO tblviolations (student_id, violation_date, violation_type, description, Sanction, penalty) 
                    VALUES (:student_id, :violation_date, :violation_type, :description, :Sanction, :penalty)";
      $query = $dbh->prepare($sql);
      $query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
      $query->bindParam(':violation_date', $violation_date, PDO::PARAM_STR);
      $query->bindParam(':violation_type', $violation_type, PDO::PARAM_STR);
      $query->bindParam(':description', $description, PDO::PARAM_STR);
      $query->bindParam(':Sanction', $Sanction, PDO::PARAM_INT);
      $query->bindParam(':penalty', $penalty, PDO::PARAM_STR);

      if ($query->execute()) {
        // If successfully inserted
        echo json_encode([
          'status' => 'success',
          'message' => 'Violation has been added.'
        ]);
      } else {
        // If there was an error during insertion
        echo json_encode([
          'status' => 'error',
          'message' => 'Something went wrong. Please try again.'
        ]);
      }
    } else {
      // If violation already exists
      echo json_encode([
        'status' => 'error',
        'message' => 'Violation already exists for the same student and date.'
      ]);
    }
    exit(); // End script after sending JSON response
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
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js'
    integrity='sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=='
    crossorigin='anonymous' referrerpolicy='no-referrer'></script>
</head>

<body>
  <div class="container-scroller">
    <?php include_once('includes/header.php'); ?>
    <div class="container-fluid page-body-wrapper">
      <?php include_once('includes/sidebar.php'); ?>
      <div class="main-panel">
        <div class="content-wrapper" style="background-color: #c71d68;">
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
                  <h4 class="card-title" style="text-align: center;">Add Student Violations</h4>
                  <form id="add-violation-form" class="forms-sample">
                    <div class="form-group">
                      <label for="student_id">Student Name</label>
                      <select name="student_id" class="form-control custom-input" required
                        style="border: 1px solid #acb7c2; outline: none;">
                        <?php
                        $sql = "SELECT id, StudentName FROM tblstudent";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        if ($query->rowCount() > 0) {
                          foreach ($results as $result) {
                            echo "<option value='" . htmlentities($result->id) . "'>" . htmlentities($result->StudentName) . "</option>";
                          }
                        }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="violation_date">Violation Date</label>
                      <input type="date" name="violation_date" class="form-control custom-input" required
                        style="border: 1px solid #acb7c2; outline: none;">
                    </div>
                    <div class="form-group">
                      <label for="violation_type">Violation Type</label>
                      <select name="violation_type" class="form-control custom-input" required
                        style="border: 1px solid #acb7c2; outline: none;">
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
                      <select name="description" class="form-control custom-input" required
                        style="border: 1px solid #acb7c2; outline: none;">
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
                      <label for="Sanction">Sanction</label>
                      <select name="Sanction" class="form-control custom-input" required
                        style="border: 1px solid #acb7c2; outline: none;">
                        <option value="">Select Sanction</option>
                        <option value="1">1st Offense </option>
                        <option value="2">2nd Offense </option>
                        <option value="3">3rd Offense </option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="penalty">Penalty</label>
                      <textarea id="penalty" name="penalty" class="form-control custom-input" required
                        style="border: 1px solid #acb7c2; outline: none;"></textarea>
                    </div>

                    <div class="mt-4">
                      <button type="submit" class="custom-add-btn" name="submit">Add</button>
                    </div>
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

  <script>
    $(document).ready(function () {
      $('#add-violation-form').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
          type: 'POST',
          url: 'rest/add-violations.php', // Change to your PHP file path
          data: $(this).serialize(), // Serialize the form data
          dataType: 'json',
          success: function (response) {
            if (response.status === 'success') {
              alert(response.message);
            } else {
              showToast('danger', response.message);
            }
          },
          error: function () {
            showToast('danger', 'An unexpected error occurred.');
          }
        });
      })
    })

    function showToast(type, message) {
      const toastContainer = `<div class='toast-container position-fixed top-0 start-50 translate-middle-x p-3'>
          <div id='invalidToast' class='toast text-bg-${type}' role='alert' aria-live='assertive' aria-atomic='true'>
              <div class='toast-body'>${message}</div>
          </div>
      </div>`;

      $('body').append(toastContainer);
      const invalidToast = new bootstrap.Toast(document.getElementById('invalidToast'));
      invalidToast.show();

      // Remove toast after showing
      setTimeout(() => {
        $('.toast').remove();
      }, 3000);
    }
  </script>
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
      $('select[name="description"], select[name="Sanction"]').on('change', function () {
        var description = $('select[name="description"]').val();
        var Sanction = $('select[name="Sanction"]').val();
        console.log(Sanction)
        console.log(description)
        console.log(":Test")

        if (description && Sanction) {

          $.ajax({
            url: 'fetch_penalty.php',  // The PHP file that will handle the request
            method: 'POST',
            data: { description: description, Sanction: Sanction },
            dataType: 'json',
            success: function (response) {
              console.log(response)
              if (response.status === 'success') {
                $('#penalty').val(response.penalty);
              } else {
                $('#penalty').val('');
              }
            }
          });
        } else {
          $('#penalty').val('');
        }
      });
    });


    $(document).ready(function () {
      $('.select2').select2({
        tags: true,
        tokenSeparators: [',', ' '],
        theme: 'bootstrap',
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
  </style>
</body>

</html>