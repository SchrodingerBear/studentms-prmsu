<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_GET['delid'])) {
    $rid = intval($_GET['delid']);
    echo $rid;
    $sql = "DELETE FROM tblviolations WHERE id = :rid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':rid', $rid, PDO::PARAM_INT);
    $query->execute();
    echo "<script>alert('Data deleted');</script>";
    echo "<script>window.location.href = 'manage-offense.php'</script>";
  }
  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <link rel="icon" href="../images/logo.png" type="image/png">
    <title>STUDENT HANDBOOK ASSISTANCE | Manage Violations</title>
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
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="text-align: center;">Manage Offense</h4>

                    <div class="table-responsive">
                      <!-- Search Bar -->
                      <input style="border: 2px #a5a5a5 solid;" type="text" id="searchInput" onkeyup="filterTable()"
                        placeholder="Search" class="form-control mb-4 mt-4">

                      <table class="table table-responsive" id="table">
                        <thead>
                          <tr>
                            <th class="font-weight-bold">Violation Type</th>
                            <th class="font-weight-bold">Offense</th>
                            <th class="font-weight-bold">Penalty</th>
                            <th class="font-weight-bold">Sanctions</th>
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
                          $no_of_records_per_page = 1000;
                          $offset = ($pageno - 1) * $no_of_records_per_page;
                          $ret = "SELECT id FROM tblviolations";
                          $query1 = $dbh->prepare($ret);
                          $query1->execute();
                          $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                          $total_rows = $query1->rowCount();
                          $total_pages = ceil($total_rows / $no_of_records_per_page);

                          // Retrieve violations with pagination
                          $sql = "SELECT * FROM tblviolations LIMIT $offset, $no_of_records_per_page";
                          $query = $dbh->prepare($sql);
                          $query->execute();
                          $results = $query->fetchAll(PDO::FETCH_OBJ);

                          $cnt = 1;
                          if ($query->rowCount() > 0) {
                            foreach ($results as $row) { ?>
                              <tr>
                                <td><?php echo htmlentities($row->violation_type); ?></td>
                                <td><?php echo htmlentities($row->description); ?></td>
                                <td><?php echo htmlentities($row->penalty); ?></td>
                                <td>
                                  <?php
                                  switch ($row->Sanction) {
                                    case 1:
                                      echo '1st offense';
                                      break;
                                    case 2:
                                      echo '2nd offense';
                                      break;
                                    case 3:
                                      echo '3rd offense';
                                      break;
                                    default:
                                      echo 'Unknown';
                                      break;
                                  }
                                  ?>
                                </td>
                                <td>
                                  <div>
                                    <a href="edit-offense.php?editid=<?php echo htmlentities($row->id); ?>"><i
                                        class="icon-eye"></i></a>
                                    || <a href="manage-offense.php?delid=<?php echo ($row->id); ?>"
                                      onclick="return confirm('Do you really want to Delete ?');"> <i
                                        class="icon-trash"></i></a>
                                  </div>
                                </td>
                              </tr><?php $cnt++;
                            }
                          } ?>
                        </tbody>
                      </table>
                    </div>


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
    <!-- JavaScript for Filtering -->
    <script>
      function filterTable() {
        // Get the search input
        var input = document.getElementById("searchInput");
        var filter = input.value.toLowerCase();

        // Get the table and its rows
        var table = document.getElementById("table");
        var tr = table.getElementsByTagName("tr");

        // Loop through all table rows, except the first which contains table headers
        for (var i = 1; i < tr.length; i++) {
          var found = false;
          // Get all cells of the current row
          var td = tr[i].getElementsByTagName("td");
          for (var j = 0; j < td.length; j++) {
            if (td[j]) {
              var txtValue = td[j].textContent || td[j].innerText;
              if (txtValue.toLowerCase().indexOf(filter) > -1) {
                found = true;
                break;
              }
            }
          }
          // Show or hide row based on search criteria
          tr[i].style.display = found ? "" : "none";
        }
      }
    </script>
    <?php include_once('includes/footer.php'); ?>

  </body>

  </html>
<?php } ?>