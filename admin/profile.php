<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $adminid = $_SESSION['sturecmsaid'];
    $AName = $_POST['adminname'];
    $mobno = $_POST['mobilenumber'];
    $email = $_POST['email'];
    $sql = "update tbladmin set AdminName=:adminname,MobileNumber=:mobilenumber,Email=:email where ID=:aid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':adminname', $AName, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':mobilenumber', $mobno, PDO::PARAM_STR);
    $query->bindParam(':aid', $adminid, PDO::PARAM_STR);
    $query->execute();

   if ($query->rowCount() > 0) {
      // Success toast
      echo "
      <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
      <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
      <div class='toast-container position-fixed top-0 start-50 translate-middle-x p-3'>
        <div id='profileUpdatedToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' style='background-color: #1c82e6; color: white;'>
          <div class='toast-body'>
            Your profile has been successfully updated.
          </div>
        </div>
      </div>
      <script>
        var profileUpdatedToast = new bootstrap.Toast(document.getElementById('profileUpdatedToast'));
        profileUpdatedToast.show();
      </script>
      ";
    } else {
      // Error toast
      echo "
      <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
      <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
      <div class='toast-container position-fixed top-0 start-50 translate-middle-x p-3'>
        <div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' style='background-color: #e63946; color: white;'>
          <div class='toast-body'>
            Something went wrong. Please try again.
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
      <title>STUDENT HANDBOOK ASSISTANCE | Profile</title>
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
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
          <!-- partial:partials/_sidebar.html -->
          <?php include_once('includes/sidebar.php'); ?>
          <!-- partial -->
          <div class="main-panel">
            <div class="content-wrapper"style="background-color: #c71d68;">
              <div class="page-header">
                <h3 class="page-title">  </h3>
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
                      <h4 class="card-title" style="text-align: center;">Admin Profile</h4>

                      <form class="forms-sample" method="post">
                        <?php

                        $sql = "SELECT * from  tbladmin";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        $cnt = 1;
                        if ($query->rowCount() > 0) {
                          foreach ($results as $row) { ?>
                                <div class="form-group">
                                  <label for="exampleInputName1">Admin Name</label>
                                  <input type="text" name="adminname" value="<?php echo $row->AdminName; ?>" class="form-control" required='true' style="border: 1px solid #ccc;">
                                </div>
                                <div class="form-group">
                                  <label for="exampleInputEmail3">User Name</label>
                                  <input type="text" name="username" value="<?php echo $row->UserName; ?>" class="form-control" required='true' style="border: 1px solid #ccc;">
                                </div>
                                <div class="form-group">
                                  <label for="exampleInputPassword4">Contact Number</label>
                                  <input type="text" name="mobilenumber" value="<?php echo $row->MobileNumber; ?>"
                                    class="form-control" maxlength='10' required='true' pattern="[0-9]+"style="border: 1px solid #ccc;">
                                </div>
                                <div class="form-group">
                                  <label for="exampleInputCity1">Email</label>
                                  <input type="email" name="email" value="<?php echo $row->Email; ?>" class="form-control" required='true' style="border: 1px solid #ccc;">
                                </div>
                                <div class="form-group">
                                  <label for="exampleInputCity1">Admin Registration Date</label>
                                  <input type="text" name="" value="<?php echo $row->AdminRegdate; ?>" readonly=""
                                    class="form-control" required='true' style="border: 1px solid #ccc;">
                                </div><?php $cnt = $cnt + 1;
                          }
                        } ?>
                    <button type="submit" name="submit" class="custom-add-btn">Update</button>

                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            <?php include_once('includes/footer.php'); ?>
            <!-- partial -->
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
                padding: 10px 30px;
                border-radius: 30px;
                font-weight: bold;
                font-size: 16px;
                transition: background-color 0.3s ease;
            }

            .custom-add-btn:hover {
                background-color: #155ba0;
                color: #fff;
                cursor: pointer;
            }

            /* Add spacing below each form group for consistency */
            .form-group {
                margin-bottom: 20px;
            }
        </style>
    </body>

    </html><?php } ?>