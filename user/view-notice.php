<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsstuid'] == 0)) {
  header('location:logout.php');
} else {
  echo updateIsReading($_SESSION['sturecmsuid'], false);
  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/logo.png" type="image/png">
    <link rel="icon" href="../images/logo.png" type="image/png">
    <title>STUDENT HANDBOOK ASSISTANCE | View Announcement</title>
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
              <h3 class="page-title" style="color: white;"> View Class Announcementcement </h3>

              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  
                </ol>
              </nav>
            </div>
            <div class="row">

              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">

                    <table border="1" class="table table-bordered mg-b-0">
                      <?php
                      $stuclass = $_SESSION['stuclass'];

                      $sql = "SELECT tblclass.ID,tblclass.ClassName,tblclass.Section,tblnotice.AnnouncementTitle,tblnotice.CreationDate,tblnotice.ClassId,tblnotice.AnnouncementMsg,tblnotice.ID as nid from tblnotice join tblclass on tblclass.ID=tblnotice.ClassId where tblnotice.ClassId=:stuclass";
                      $query = $dbh->prepare($sql);
                      $query->bindParam(':stuclass', $stuclass, PDO::PARAM_STR);
                      $query->execute();
                      $results = $query->fetchAll(PDO::FETCH_OBJ);
                      $cnt = 1;
                      if ($query->rowCount() > 0) {
                        foreach ($results as $row) { ?>
                          <tr align="center" class="table-warning">
                            <td colspan="4" style="font-size:25px;color:#1c82e6;">
                              Announcementcement</td>
                          </tr>
                          <tr class="table-info">
                            <th>Announced Date</th>
                            <td><?php echo $row->CreationDate; ?></td>
                          </tr>
                          <tr class="table-info">
                            <th>Announcementcement Title</th>
                            <td><?php echo $row->AnnouncementTitle; ?></td>
                          </tr>
                          <tr class="table-info">
                            <th>Message</th>
                            <td><?php echo $row->AnnouncementMsg; ?></td>

                          </tr>

                          <?php $cnt = $cnt + 1;
                        }
                      } else { ?>
                        <tr>
                          <th colspan="2" style="color:red;">No Announcementcement Found</th>
                        </tr>
                      <?php } ?>
                    </table>
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
  </body>

  </html><?php } ?>