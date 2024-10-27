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
    $sql = "delete from tblstudent where ID=:rid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':rid', $rid, PDO::PARAM_STR);
    $query->execute();
    echo "<script>alert('Data deleted');</script>";
    echo "<script>window.location.href = 'manage-students.php'</script>";
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" href="../images/logo.png" type="image/png">
  <title>STUDENT HANDBOOK ASSISTANCE || Between Dates Reports</title>
  <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="./vendors/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="./vendors/chartist/chartist.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome -->
  <link rel="stylesheet" href="./css/style.css">
</head>
<body>
  <div class="container-scroller">
    <?php include_once('includes/header.php'); ?>
    <div class="container-fluid page-body-wrapper">
      <?php include_once('includes/sidebar.php'); ?>
      <div class="main-panel">
        <div class="content-wrapper"style="background-color: #c71d68;">
          <div class="page-header">
            <h3 class="page-title"></h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php"></a></li>
                <li class="" aria-current="page"></li>
              </ol>
            </nav>
          </div>
          <div class="col-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <?php
                $fdate = $_POST['fromdate'];
                $tdate = $_POST['todate'];
                ?>
                <h5 align="center" style="color:blue">Report from <?php echo $fdate ?> To <?php echo $tdate ?></h5>
                <div style="text-align: right; margin-bottom: 10px;">
                    <i class="fas fa-print" style="font-size: 24px; cursor: pointer;" onclick="printReport()" title="Print Report"></i>
                </div>
                <div class="table-responsive border rounded p-1">
                  <table class="table">
                    <thead>
                      <tr>
                        <th class="font-weight-bold">No</th>
                        <th class="font-weight-bold">Student ID</th>
                        <th class="font-weight-bold">Student Class</th>
                        <th class="font-weight-bold">Student Name</th>
                        <th class="font-weight-bold">Student Email</th>
                        <th class="font-weight-bold">Admission Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if (isset($_GET['pageno'])) {
                        $pageno = $_GET['pageno'];
                      } else {
                        $pageno = 1;
                      }
                      $no_of_records_per_page = 5;
                      $offset = ($pageno - 1) * $no_of_records_per_page;
                      $ret = "SELECT ID FROM tblstudent";
                      $query1 = $dbh->prepare($ret);
                      $query1->execute();
                      $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                      $total_rows = $query1->rowCount();
                      $total_pages = ceil($total_rows / $no_of_records_per_page);
                      $sql = "SELECT tblstudent.StuID, tblstudent.ID as sid, tblstudent.StudentName, tblstudent.StudentEmail, tblstudent.DateofAdmission, tblclass.ClassName, tblclass.Section FROM tblstudent JOIN tblclass ON tblclass.ID = tblstudent.StudentClass WHERE date(tblstudent.DateofAdmission) BETWEEN '$fdate' AND '$tdate'";
                      $query = $dbh->prepare($sql);
                      $query->execute();
                      $results = $query->fetchAll(PDO::FETCH_OBJ);
                      $cnt = 1;
                      if ($query->rowCount() > 0) {
                        foreach ($results as $row) { ?>
                          <tr>
                            <td><?php echo htmlentities($cnt); ?></td>
                            <td><?php echo htmlentities($row->StuID); ?></td>
                            <td><?php echo htmlentities($row->ClassName); ?> <?php echo htmlentities($row->Section); ?></td>
                            <td><?php echo htmlentities($row->StudentName); ?></td>
                            <td><?php echo htmlentities($row->StudentEmail); ?></td>
                            <td><?php echo htmlentities($row->DateofAdmission); ?></td>
                          </tr>
                          <?php $cnt++; 
                        }
                      } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php include_once('includes/footer.php'); ?>
      </div>
    </div>
  </div>
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="./vendors/chart.js/Chart.min.js"></script>
  <script src="./vendors/moment/moment.min.js"></script>
  <script src="./vendors/daterangepicker/daterangepicker.js"></script>
  <script src="./vendors/chartist/chartist.min.js"></script>
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
  <script src="./js/dashboard.js"></script>
  <script>
     function printReport() {
    // Ensure the from and to dates are properly captured from the PHP variables
    var fromDate = "<?php echo $fdate; ?>"; // Fetching the from date from PHP
    var toDate = "<?php echo $tdate; ?>";   // Fetching the to date from PHP
    var reportTitle = "Report from " + fromDate + " To " + toDate; // Building the title

    var reportContent = document.querySelector('.table-responsive').outerHTML; // Gets the report table
    var printWindow = window.open('', '', 'height=600,width=800');
    
    // Building the print document with the correct title and report content
    printWindow.document.write('<html><head><title>' + reportTitle + '</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { background: none; color: black; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; }');
    printWindow.document.write('th, td { border: 1px solid black; padding: 8px; text-align: left; }');
    printWindow.document.write('h5 { text-align: center; }');
    printWindow.document.write('@media print { * { background: none !important; color: black !important; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    // Writing the dynamic report title and content
    printWindow.document.write('<h5>' + reportTitle + '</h5>');
    printWindow.document.write(reportContent);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

  </script>
</body>
</html>
<?php } ?>
