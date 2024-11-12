<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/dbconnection.php');

// Check if the user is logged in
if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
} else {
    // Handle form submission
    if (isset($_POST['submit'])) {
        $pagetitle = $_POST['pagetitle'];
        $pagedes = $_POST['pagedes'];

        // Update query
        $sql = "UPDATE tblpage SET PageTitle=:pagetitle, PageDescription=:pagedes WHERE PageType='aboutus'";
        $query = $dbh->prepare($sql);
        $query->bindParam(':pagetitle', $pagetitle, PDO::PARAM_STR);
        $query->bindParam(':pagedes', $pagedes, PDO::PARAM_STR);
        
     
         try {
            // Execute the update
            $query->execute();
            
            // Check if any row was updated
            if ($query->rowCount() > 0) {
                // Success toast
                echo "
                <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
                <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
                <div class='toast-container position-fixed top-0 start-50 translate-middle-x p-3'>
                    <div id='updateSuccessToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' style='background-color: #1c82e6; color: white;'>
                        <div class='toast-body'>
                            About Us has been successfully updated.
                        </div>
                    </div>
                </div>
                <script>
                    var updateSuccessToast = new bootstrap.Toast(document.getElementById('updateSuccessToast'));
                    updateSuccessToast.show();
                </script>
                ";
            }
        } catch (PDOException $e) {
            // Display the error message using an error toast
            echo "
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
            <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
            <div class='toast-container position-fixed top-0 start-50 translate-middle-x p-3'>
                <div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' style='background-color: #e63946; color: white;'>
                    <div class='toast-body'>
                        Error: " . $e->getMessage() . "
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="../images/logo.png" type="image/png">
    <title>STUDENT HANDBOOK ASSISTANCE | Update About Us</title>
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="css/style.css" />
    
    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript">
        // Initialize the WYSIWYG editor
        function initializeEditor() {
            new nicEditor({ fullPanel: true }).panelInstance('pagedes');
        }

        document.addEventListener("DOMContentLoaded", function () {
            initializeEditor();
        });
    </script>
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
                            <ol class="breadcrumb"></ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title" style="text-align: center;">Update About </h4>
                                    <form class="forms-sample" method="post">
                                        <?php
                                        // Fetch existing data
                                        $sql = "SELECT * FROM tblpage WHERE PageType='aboutus'";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $row) { ?>
                                                <div class="form-group">
                                                    <label for="pagetitle">Page Title:</label>
                                                    <input type="text" name="pagetitle" value="<?php echo htmlentities($row->PageTitle); ?>" class="form-control" required='true'>
                                                </div>
                                                <div class="form-group">
                                                    <label for="pagedes">Page Address:</label>
                                                    <textarea id="pagedes" name="pagedes" class="form-control" required='true'><?php echo htmlentities($row->Address); ?></textarea>
                                                </div>
                                            <?php }
                                        } else {
                                            echo '<p>No data found for the About Us page.</p>';
                                        } ?>
                                        <button type="submit" name="submit" class="custom-add-btn">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
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
