<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../images/logo.png" type="image/png">
  <title>STUDENT HANDBOOK ASSISTANCE | About Us Page</title>
  <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <script src="js/jquery-1.11.0.min.js"></script>
  <script src="js/bootstrap.js"></script>
</head>

<body>
    <?php include_once('includes/header.php'); ?>
    
    <div class="testimonials">
        <div class="container">
            <div class="about">
                <?php
                // Fetch the existing data (this should be in the About Us page)
                $sql = "SELECT * FROM tblpage WHERE PageType='aboutus'";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);

                if ($query->rowCount() > 0) {
                    foreach ($results as $row) { ?>
                        <h2 style="color: #fff; font-size: 40px;"><?php echo htmlentities($row->PageTitle); ?></h2>
                        <div class="about-info-grids">
                            <div class="col-md-12 abt-info-pic">
                                <!-- Display Addresswith HTML rendering -->
                                <p><?php echo html_entity_decode($row->Address); ?></p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php }
                } else {
                    echo '<p>No data found for the About Us page.</p>';
                } ?>
            </div>
        </div>
    </div>
    
    <?php include_once('includes/footer.php'); ?>
</body>

</html>
