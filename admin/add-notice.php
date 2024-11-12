<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';
error_reporting(0);
include('includes/dbconnection.php');

// Session check fix
if (strlen($_SESSION['sturecmsaid']) == 0) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $nottitle = $_POST['nottitle'];
    $classid = $_POST['classid'];
    $notmsg = $_POST['notmsg'];

    // Insert notice into the database
    $sql = "insert into tblnotice(NoticeTitle, ClassId, NoticeMsg) values(:nottitle, :classid, :notmsg)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':nottitle', $nottitle, PDO::PARAM_STR);
    $query->bindParam(':classid', $classid, PDO::PARAM_STR);
    $query->bindParam(':notmsg', $notmsg, PDO::PARAM_STR);

    if ($query->execute()) {
      $LastInsertId = $dbh->lastInsertId();
      if ($LastInsertId > 0) {
        // Success notification


        // Get students' emails and names
        $sql = "SELECT StudentEmail, StudentName FROM tblstudent WHERE StudentClass = :classid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':classid', $classid, PDO::PARAM_STR);
        $query->execute();
        $students = $query->fetchAll(PDO::FETCH_ASSOC);

        // Prepare PHPMailer
        $mail = new PHPMailer(true);
        try {
          $mail->isSMTP();
          $mail->Host = 'smtp.hostinger.com';
          $mail->SMTPAuth = true;
          $mail->Username = 'support@prmsu-scstudenthandbook.website';
          $mail->Password = 'E&b2eWY#*dP|'; // Keep this secure
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
          $mail->Port = 587;
          $mail->setFrom('support@prmsu-scstudenthandbook.website', 'Studentms Mailer');
          $mail->isHTML(true);
          $mail->Subject = "New Announcement: $nottitle";

          // Send the announcement to each student in the class
          foreach ($students as $student) {
            $stuemail = $student['StudentEmail'];
            $stuname = $student['StudentName'];

            $mail->clearAddresses();
            $mail->addAddress($stuemail, $stuname);
            $mail->Body = "<p>Hello $stuname,</p><p>There is a new announcement:</p><p><strong>$nottitle</strong></p><p>$notmsg</p>";
            $mail->AltBody = "New announcement: $nottitle - $notmsg";

            $mail->send();
          }
        } catch (Exception $e) {
          echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        echo "
                <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
                <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
                <div class='toast-container position-fixed top-0 start-50 translate-middle-x p-3'>
                    <div id='noticeAddedToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' style='background-color: #1c82e6; color: white;'>
                        <div class='toast-body'>
                            Notice has been successfully added and students email are notified.
                        </div>
                    </div>
                </div>
                <script>
                    var noticeAddedToast = new bootstrap.Toast(document.getElementById('noticeAddedToast'));
                    noticeAddedToast.show();
                </script>";
      }
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
  <title>STUDENT HANDBOOK ASSISTANCE | Add Notice</title>
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
              <ol class="breadcrumb">

              </ol>
            </nav>
          </div>
          <div class="row">

            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title" style="text-align: center;">Add Class Notice</h4>

                  <form class="forms-sample" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                      <label for="exampleInputName1">Notice Title</label>
                      <input type="text" name="nottitle" value="" class="form-control custom-input" required
                        style="border: 1px solid #acb7c2;">
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail3">Notice For</label>
                      <select name="classid" class="form-control custom-input" required
                        style="border: 1px solid #acb7c2;">
                        <option value="">Select Class</option>
                        <?php

                        $sql2 = "SELECT * from    tblclass where id != '0' ";
                        $query2 = $dbh->prepare($sql2);
                        $query2->execute();
                        $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                        foreach ($result2 as $row1) {
                          ?>
                          <option value="<?php echo htmlentities($row1->ID); ?>">
                            <?php echo htmlentities($row1->ClassName); ?>   <?php echo htmlentities($row1->Section); ?>
                          </option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputName1">Notice Message</label>
                      <textarea name="notmsg" value="" class="form-control custom-input" required
                        style="border: 1px solid #acb7c2;"></textarea>
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

</html>