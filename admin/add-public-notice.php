<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $nottitle = $_POST['nottitle'];

    $notmsg = $_POST['notmsg'];
    $sql = "insert into tblpublicnotice(AnnouncementTitle,AnnouncementMessage)values(:nottitle,:notmsg)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':nottitle', $nottitle, PDO::PARAM_STR);
    $query->bindParam(':notmsg', $notmsg, PDO::PARAM_STR);
    $query->execute();
    $LastInsertId = $dbh->lastInsertId();
    if ($LastInsertId > 0) {
      echo '<script>alert("Announcementcement has been added.")</script>';
      echo "<script>window.location.href ='add-public-Announcement.php'</script>";
    } else {
      echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
  }
  ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

      <link rel="icon" href="../images/logo.png" type="image/png">
      <title>STUDENT HANDBOOK ASSISTANCE | Add Announcementcement</title>
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
               
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    
                  </ol>
                </nav>
              </div>
              <div class="row">

                <div class="col-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title" style="text-align: center;">Add Public Announcementcement</h4>

                      <form class="forms-sample" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                          <label for="exampleInputName1">Announcementcement Title</label>
                          <input type="text" name="nottitle" value="" class="form-control custom-input" required style="border: 1px solid #acb7c2;">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputName1">Announcementcement Message</label>
                          <textarea name="notmsg" value="" class="form-control custom-input" required style="border: 1px solid #acb7c2;"></textarea>
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

    </html><?php } ?>