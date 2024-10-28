<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $cname = $_POST['cname'];
        $section = $_POST['section'];
        $sql = "insert into tblclass(ClassName,Section) values(:cname,:section)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':cname', $cname, PDO::PARAM_STR);
        $query->bindParam(':section', $section, PDO::PARAM_STR);
        $query->execute();
        $LastInsertId = $dbh->lastInsertId();

        if ($LastInsertId > 0) {
            echo "
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
            <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
            <div class='toast-container position-fixed top-0 start-50 translate-middle-x p-3'>
                <div id='classAddedToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' style='background-color: #1c82e6; color: white;'>
                    <div class='toast-body'>
                        Class has been successfully added.
                    </div>
                </div>
            </div>
            <script>
                var classAddedToast = new bootstrap.Toast(document.getElementById('classAddedToast'));
                classAddedToast.show();
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
    <title>STUDENT HANDBOOK ASSISTANCE | Add Class</title>
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
                <div class="content-wrapper" style="background-color: #c71d68;">
                    <div class="page-header">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb"></ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title" style="text-align: center;">Add Class</h4>
                                    <div class="col-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <form class="forms-sample" method="post">
                                                    <div class="form-group">
                                                        <label for="exampleInputName1">Class Name</label>
                                                        <input type="text" name="cname" value="" class="form-control" required='true' style="border: 1px solid #ccc;">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail3">Section</label>
                                                        <select name="section" class="form-control" required='true' style="border: 1px solid #ccc;">
                                                            <option value="">Choose Section</option>
                                                           <option value="1">1</option>
                                                           <option value="2">2</option>
                                                           <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="1A">1A</option>
                                                              <option value="1B">1B</option>
                                                             <option value="1C">1C</option>
                                                             <option value="2A">2A</option>
                                                            <option value="2B">2B</option>
                                                           <option value="3A">3A</option>
                                                           <option value="3B">3B</option>
                                                             <option value="4A">4A</option>
                                                        </select>
                                                    </div>
                                            <button type="submit" name="submit" class="custom-add-btn">Add</button>

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
            </div>
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

</html>