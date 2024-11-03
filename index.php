<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="images/logo.png" type="image/png">
  <title>STUDENT HANDBOOK ASSISTANCE | Student Login</title>

  <!-- Bootstrap CSS -->
  <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
  <!-- Custom CSS -->
  <link href="css/style.css" rel="stylesheet" type="text/css">

  <!-- jQuery and Bootstrap JS -->
  <script src="js/jquery-1.11.0.min.js"></script>
  <script src="js/bootstrap.js"></script>

  <!-- Fonts and Icons -->
  <link
    href='//fonts.googleapis.com/css?family=Open+Sans:300,300italic,400italic,400,600,600italic,700,700italic,800,800italic'
    rel='stylesheet' type='text/css'>

  <!-- Custom Script -->
  <script src="js/modernizr.custom.js"></script>
  <script type="text/javascript" src="js/move-top.js"></script>
  <script type="text/javascript" src="js/easing.js"></script>
  <script type="text/javascript">
    jQuery(document).ready(function ($) {
      $(".scroll").click(function (event) {
        event.preventDefault();
        $('html,body').animate({ scrollTop: $(this.hash).offset().top }, 900);
      });
    });
  </script>

  <style>
    /* Custom Styles */
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f0f0f0;
    }

    h3 {
      color: #ff5733;
    }

    .slider h3 {
      font-size: 1.5rem;
    }

    .readmore a {
      font-size: 1rem;
      color: #fff;
    }

    @media (max-width: 576px) {
      .slider h3 {
        font-size: 1.2rem;
      }

      .readmore a {
        font-size: 0.9rem;
      }
    }
  </style>
</head>

<body>
  <?php include_once('includes/header.php'); ?>

  <!-- Banner Section -->
  <div class="banner">
    <div class="container">
      <div class="slider">
        <div class="callbacks_container">
          <ul class="rslides" id="slider">
            <li>
              <h3 class="text-center">WEB-BASED STUDENT HANDBOOK ASSISTANCE</h3>
              <div class="readmore text-center mt-3">
                <a href="user/login.php" class="btn btn-primary">Student Login <i
                    class="glyphicon glyphicon-menu-right"> </i></a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Public Notices Section -->
  <div class="testimonials py-5 bg-dark text-white">
    <div class="container">
      <div class="testimonial-nfo">
        <h3 class="text-center mb-4">Public Notices</h3>
        <div class="marquee" style="overflow-y: auto; max-height: 350px;">
          <?php
          $sql = "SELECT * from tblpublicnotice";
          $query = $dbh->prepare($sql);
          $query->execute();
          $results = $query->fetchAll(PDO::FETCH_OBJ);

          if ($query->rowCount() > 0) {
            foreach ($results as $row) { ?>
              <a href="view-public-notice.php?viewid=<?php echo htmlentities($row->ID); ?>" target="_blank"
                class="d-block text-white mb-2" style="font-size: 1.1rem;">
                <?php echo htmlentities($row->NoticeTitle); ?> (<?php echo htmlentities($row->CreationDate); ?>)
              </a>
              <hr class="bg-light">
            <?php }
          } ?>
        </div>
      </div>
    </div>
  </div>

  <?php include_once('includes/footer.php'); ?>
</body>

</html>