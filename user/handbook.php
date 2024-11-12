<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsstuid'] == 0)) {
  header('location:logout.php');
} else {
  echo updateIsReading($_SESSION['sturecmsuid'], true);
  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/logo.png" type="image/png">
    <title>STUDENT HANDBOOK ASSISTANCE | View Announcement</title>
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="vendors/select2/select2.min.css">
    <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="js/dearflip/css/dflip.min.css" />
    <link rel="stylesheet" href="js/dearflip/css/themify-icons.min.css" />
    <script src="js/dearflip/js/dflip.min.js"></script>
  </head>
  

  <body>
    <style>
      @media (max-width: 768px) {
        .page-header {
          padding: 1rem;
          margin: 0;
        }
      }
    </style>

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
             <h3 class="page-title" style="color: white;"> View Student Handbook </h3>

              <nav aria-label="">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php"></a></li>
                  <li class="" aria-current="page"> </li>
                </ol>
              </nav>
            </div>
            <div class="row">
            <iframe allowfullscreen="allowfullscreen" scrolling="no" class="fp-iframe" style="border: 1px solid lightgray; width: 100%; height: 900px;" src="https://heyzine.com/flip-book/4cc96bca28.html"></iframe>
            </div>

          </div>
        </div>
      </div>
    </div>
    <?php include_once('includes/footer.php'); ?>
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="vendors/select2/select2.min.js"></script>
    <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <script src="js/typeahead.js"></script>
    <script src="js/select2.js"></script>
  </body>

  </html><?php } ?>