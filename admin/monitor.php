<?php
session_start();
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {

    if (isset($_GET['delid'])) {
        $rid = intval($_GET['delid']);
        $sql = "DELETE FROM tblviolations WHERE id = :rid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':rid', $rid, PDO::PARAM_INT);
        $query->execute();
        echo "<script>alert('Data deleted');</script>";
        echo "<script>window.location.href = 'manage-violations.php'</script>";
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <link rel="icon" href="../images/logo.png" type="image/png">
        <title>Monitor Online Students</title>
        <!-- plugins:css -->
        <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
        <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
        <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
        <!-- inject:css -->
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
                    <div class="content-wrapper" style="background-color: #c71d68;">
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title" style="text-align: center;">Monitor Online Students</h4>

                                        <!-- Print Button Container -->
                                        <div class="print-button-container"
                                            style="position: absolute; top: 20px; right: 20px; text-align: right;">
                                            <a href="javascript:void(0)" onclick="printSection()">
                                                <i class="icon-printer" style="font-size: 24px;"></i> Print
                                            </a>
                                        </div>

                                        <!-- Search Bar -->
                                        <input style="border: 2px #a5a5a5 solid;" type="text" id="searchInput"
                                            onkeyup="filterTable()"
                                            placeholder="Search for Students ID, Student Class, Student Name, Last Seen"
                                            class="form-control mb-3">

                                        <table class="table" id="table">
                                            <thead>
                                                <tr>
                                                    <th class="font-weight-bold">No</th>
                                                    <th class="font-weight-bold">Student ID</th>
                                                    <th class="font-weight-bold">Student Class</th>
                                                    <th class="font-weight-bold">Student Name</th>
                                                    <th class="font-weight-bold">Student Email</th>
                                                    <th class="font-weight-bold">Last Seen</th>
                                                    <th class="font-weight-bold">Active</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php
                                                if (isset($_GET['pageno'])) {
                                                    $pageno = $_GET['pageno'];
                                                } else {
                                                    $pageno = 1;
                                                }
                                                $no_of_records_per_page = 10;
                                                $offset = ($pageno - 1) * $no_of_records_per_page;

                                                $ret = "SELECT ID FROM tblstudent";
                                                $query1 = $dbh->prepare($ret);
                                                $query1->execute();
                                                $total_rows = $query1->rowCount();
                                                $total_pages = ceil($total_rows / $no_of_records_per_page);

                                                $sql = "SELECT tblstudent.StuID, tblstudent.isReading, tblstudent.last_seen, tblstudent.ID as sid, tblstudent.StudentName, tblstudent.StudentEmail, tblstudent.DateofAdmission, tblclass.ClassName, tblclass.Section
            FROM tblstudent
            JOIN tblclass ON tblclass.ID = tblstudent.StudentClass
            LIMIT $offset, $no_of_records_per_page";
                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                                $cnt = 1;
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $row) {
                                                        if ($row->isReading) {
                                                            $updateLastSeen = "UPDATE tblstudent SET last_seen = NOW() WHERE ID = :sid";
                                                            $updateQuery = $dbh->prepare($updateLastSeen);
                                                            $updateQuery->bindParam(':sid', $row->sid, PDO::PARAM_INT);
                                                            $updateQuery->execute();
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td><?php echo htmlentities($cnt); ?></td>
                                                            <td><?php echo htmlentities($row->StuID); ?></td>
                                                            <td><?php echo htmlentities($row->ClassName); ?>
                                                                <?php echo htmlentities($row->Section); ?>
                                                            </td>
                                                            <td><?php echo htmlentities($row->StudentName); ?></td>
                                                            <td><?php echo htmlentities($row->StudentEmail); ?></td>
                                                            <td>
                                                                <?php
                                                                $datetime = new DateTime($row->last_seen);
                                                                $formattedDate = $datetime->format('F d, Y h:i A');
                                                                echo $formattedDate;
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if (htmlentities($row->isReading)) {
                                                                    echo "Active Now";
                                                                } else {
                                                                    date_default_timezone_set('Asia/Manila');
                                                                    $datetime1 = new DateTime($row->last_seen);
                                                                    $datetime2 = new DateTime();
                                                                    $interval = $datetime1->diff($datetime2);
                                                                    $minutesDifference = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;

                                                                    if ($minutesDifference < 60) {
                                                                        echo "$minutesDifference minutes ago.";
                                                                    } elseif ($minutesDifference < 1440) {
                                                                        $hoursDifference = floor($minutesDifference / 60);
                                                                        echo "$hoursDifference hour" . ($hoursDifference > 1 ? 's' : '') . " ago.";
                                                                    } else {
                                                                        $daysDifference = $interval->days;
                                                                        echo "$daysDifference day" . ($daysDifference > 1 ? 's' : '') . " ago.";
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
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

        <!-- container-scroller -->
        <!-- plugins:js -->
        <script src="vendors/js/vendor.bundle.base.js"></script>
        <!-- Custom js for this page -->
        <script src="js/off-canvas.js"></script>
        <script src="js/misc.js"></script>

        <!-- JavaScript for Filtering -->
        <script>
            function filterTable() {
                var input = document.getElementById("searchInput");
                var filter = input.value.toLowerCase();
                var table = document.getElementById("table");
                var tr = table.getElementsByTagName("tr");

                for (var i = 1; i < tr.length; i++) {
                    var found = false;
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
                    tr[i].style.display = found ? "" : "none";
                }
            }

            // Function to print the section with title
            function printSection() {
                var tableContent = document.getElementById("table").outerHTML;
                var title = "<h4 style='text-align: center;'>Monitor Online Students</h4>";
                var originalContent = document.body.innerHTML;

                // Open a new window to hold the printable content
                var printWindow = window.open('', '', 'height=600,width=800');
                printWindow.document.write('<html><head><title>Monitor Online Students</title>');
                printWindow.document.write('<style>table { width: 100%; border-collapse: collapse; } table, th, td { border: 1px solid black; padding: 10px; text-align: left; } th { background-color: #f2f2f2; }</style>');
                printWindow.document.write('</head><body>');
                printWindow.document.write(title);
                printWindow.document.write(tableContent);
                printWindow.document.write('</body></html>');

                printWindow.document.close();
                printWindow.focus();
                printWindow.print();
                printWindow.close();
            }
        </script>
    </body>

    </html>
<?php } ?>