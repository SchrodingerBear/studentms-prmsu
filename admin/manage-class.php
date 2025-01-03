<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid'] == 0)) {
  header('location:logout.php');
} else {
  // Code for deletion

  if (isset($_GET['delid'])) {
    $rid = intval($_GET['delid']);
    echo $rid;

    // Get current active status
    $sql = "SELECT active FROM tblclass WHERE ID=:rid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':rid', $rid, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    // Toggle active status
    if ($result) {
      $newStatus = $result['active'] == 1 ? 0 : 1;
      $sqlUpdate = "UPDATE tblclass SET active=:newStatus WHERE ID=:rid";
      $queryUpdate = $dbh->prepare($sqlUpdate);
      $queryUpdate->bindParam(':newStatus', $newStatus, PDO::PARAM_INT);
      $queryUpdate->bindParam(':rid', $rid, PDO::PARAM_INT);
      $queryUpdate->execute();

      // Show a toast notification after toggling
      echo "
          <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
          <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
          <div class='toast-container position-fixed top-0 start-50 translate-middle-x p-3'>
              <div id='toggleToast' class='toast text-bg-success' role='alert' aria-live='assertive' aria-atomic='true'>
                  <div class='toast-body'>
                      Class status has been successfully updated.
                  </div>
              </div>
          </div>
          <script>
              var toggleToast = new bootstrap.Toast(document.getElementById('toggleToast'));
              toggleToast.show();
          </script>
      ";

      // Redirect back to manage-class.php after a delay
      echo "<script>setTimeout(function() { window.location.href = 'manage-class.php'; }, 3000);</script>";
    }
  }
  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>

    <link rel="icon" href="../images/logo.png" type="image/png">
    <title>STUDENT HANDBOOK ASSISTANCE ||Manage Class</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="./vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="./vendors/chartist/chartist.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="./css/style.css">
    <!-- End layout styles -->

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
          <div class="content-wrapper" style="background-color: #c71d68;">
            <div class="page-header">

              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">

                </ol>
              </nav>
            </div>
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title" style="text-align: center;">Manage Class</h4>
                  <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                      <div class="card">
                        <div class="card-body">
                          <div class="d-sm-flex align-items-center mb-4">
                            <h4 class="card-title mb-sm-0"></h4>
                            <a href="#" class="text-dark ml-auto mb-3 mb-sm-0"> </a>
                          </div>
                          <div class=" border rounded p-1">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th class="font-weight-bold">No</th>
                                  <th class="font-weight-bold">Class Name</th>
                                  <th class="font-weight-bold">Section</th>
                                  <th class="font-weight-bold">Status</th>
                                  <th class="font-weight-bold">Creation Date</th>
                                  <th class="font-weight-bold">Action</th>

                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                if (isset($_GET['pageno'])) {
                                  $pageno = $_GET['pageno'];
                                } else {
                                  $pageno = 1;
                                }
                                // Formula for pagination
                                $no_of_records_per_page = 500;
                                $offset = ($pageno - 1) * $no_of_records_per_page;
                                $ret = "SELECT ID FROM tblclass ";
                                $query1 = $dbh->prepare($ret);
                                $query1->execute();
                                $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                                $total_rows = $query1->rowCount();
                                $total_pages = ceil($total_rows / $no_of_records_per_page);
                                $sql = "SELECT * from tblclass";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                $cnt = 1;
                                if ($query->rowCount() > 0) {
                                  foreach ($results as $row) { ?>
                                    <tr>

                                      <td><?php echo htmlentities($cnt); ?></td>
                                      <td><?php echo htmlentities($row->ClassName); ?></td>
                                      <td><?php echo htmlentities($row->Section); ?></td>
                                      <td><?php echo $row->active == 1 ? 'Inactive' : 'Active'; ?></td>

                                      <td><?php echo htmlentities($row->CreationDate); ?></td>
                                      <td>
                                        <div><a href="edit-class-detail.php?editid=<?php echo htmlentities($row->ID); ?>"><i
                                              class="icon-eye"></i></a>
                                          || <a href="manage-class.php?delid=<?php echo ($row->ID); ?>"> <i
                                              class="icon-trash"></i></a></div>
                                      </td>
                                    </tr><?php $cnt = $cnt + 1;
                                  }
                                } ?>
                              </tbody>
                            </table>
                          </div>
                          <!-- <div align="left">
                        <ul class="pagination">
                          <li><a href="?pageno=1"><strong>First></strong></a></li>
                          <li class="<?php if ($pageno <= 1) {
                            echo 'disabled';
                          } ?>">
                            <a href="<?php if ($pageno <= 1) {
                              echo '#';
                            } else {
                              echo "?pageno=" . ($pageno - 1);
                            } ?>"><strong
                                style="padding-left: 10px">Prev></strong></a>
                          </li>
                          <li class="<?php if ($pageno >= $total_pages) {
                            echo 'disabled';
                          } ?>">
                            <a
                              href="<?php if ($pageno >= $total_pages) {
                                echo '#';
                              } else {
                                echo "?pageno=" . ($pageno + 1);
                              } ?>"><strong
                                style="padding-left: 10px">Next></strong></a>
                          </li>
                          <li><a href="?pageno=<?php echo $total_pages; ?>"><strong
                                style="padding-left: 10px">Last</strong></a></li>
                        </ul>
                      </div> -->
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
        </div>
        <!-- container-scroller -->
        <!-- plugins:js -->
        <script src="vendors/js/vendor.bundle.base.js"></script>
        <!-- endinject -->
        <!-- Plugin js for this page -->
        <script src="./vendors/chart.js/Chart.min.js"></script>
        <script src="./vendors/moment/moment.min.js"></script>
        <script src="./vendors/daterangepicker/daterangepicker.js"></script>
        <script src="./vendors/chartist/chartist.min.js"></script>
        <!-- End plugin js for this page -->
        <!-- inject:js -->
        <script src="js/off-canvas.js"></script>
        <script src="js/misc.js"></script>
        <!-- endinject -->
        <!-- Custom js for this page -->
        <script src="./js/dashboard.js"></script>
        <!-- End custom js for this page -->
        <?php include_once('includes/footer.php'); ?>

  </body>

  </html><?php } ?>