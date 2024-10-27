<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $newpassword = $_POST['newpassword'];

    // Fetch user based on email and mobile
    $sql = "SELECT StudentEmail FROM tblstudent WHERE StudentEmail=:email and ContactNumber=:mobile";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        // Update password
        $con = "UPDATE tblstudent SET Password=:newpassword WHERE StudentEmail=:email AND ContactNumber=:mobile";
        $chngpwd1 = $dbh->prepare($con);
        $chngpwd1->bindParam(':email', $email, PDO::PARAM_STR);
        $chngpwd1->bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
        $chngpwd1->execute();
        echo "<script>alert('Your password was successfully changed');</script>";
    } else {
        echo "<script>alert('Invalid email or mobile number');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="../images/logo.png" type="image/png">
    <title>STUDENT HANDBOOK ASSISTANCE | Student Forgot Password</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- inject:css -->
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript">
        function valid() {
            if (document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
                alert("New Password and Confirm Password fields do not match!!");
                document.chngpwd.confirmpassword.focus();
                return false;
            }
            return true;
    }
  </script>
 <style>

 .form-control {
    border: 1px solid #1E90FF; /* Mas makapal na border */
    border-radius: 5px; 
    padding: 10px;
    transition: border-color 0.3s ease, box-shadow 0.3s ease; 
}

.form-control:focus {
    border-color: #28a745; /* Bagong kulay kapag naka-focus */
    box-shadow: 0 0 5px rgba(40, 167, 69, 0.5); 
    outline: none; 
}

.form-control:hover {
    border-color: #FFD700; /* Iba pang kulay sa hover */
}



    .container-scroller {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .content-wrapper {
      background: none !important;
    }

    .auth-form-light {
      background: #fff;
      border-radius: 10px;
      padding: 40px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .brand-logo {
      width: 100px;
      height: 100px;
      background-color: #f8f9fa;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0 auto 20px;
    }

    .brand-logo img {
      width: 60%;
    }

   /* Styles for the Update button */
.btn-custom {
    background-color: #ffc42e;
    color: #fff; /* Text color */
    border: none;
    padding: 12px 20px;
    border-radius: 30px;
    font-weight: bold;
    font-size: 16px;
    transition: background-color 0.3s ease, color 0.3s ease; /* Add transition for smooth effect */
    width: 100%;
}

.btn-custom:hover {
    background-color: #e6c05e; /* Button hover background color */
    color: #fff; /* Keep font color white */
}

/* Styles for the Back Home button */
.custom-back-home-btn {
    background-color: #1c82e6;
    color: #fff; /* Text color */
    border: none;
    padding: 10px 20px;
    border-radius: 30px;
    font-weight: bold;
    font-size: 16px;
    transition: background-color 0.3s ease, color 0.3s ease; /* Add transition for smooth effect */
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.custom-back-home-btn:hover {
    background-color: #155ba0; /* Button hover background color */
    color: #fff; /* Keep font color white */
    cursor: pointer;
}


    .auth-link {
    color:blue;              /* Blue color to match 'Forgot Password?' */
    text-decoration: underline;   /* Underline the text */
    font-weight: "Open Sans", sans-serif;           /* Make the font bold */
    font-size: 16px;              /* Same font size as 'Forgot Password?' */
    background: transparent;      /* No background color */
    border: none;                 /* Remove any potential border */
    transition: color 0.3s ease;  /* Smooth color change on hover */
}

.auth-link:hover {
    color: #28a745;         /* Darker blue on hover */
    background: transparent;      /* Ensure no background color on hover */
}


    body {
      background-image: url("../images/login.jpg");
      background-repeat: no-repeat;
      background-size: cover;
    }
  </style>
</head>
<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row flex-grow">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
              <div class="brand-logo">
                <img src="../images/prmsu.png" alt="Logo">
              </div>
              <h4>RECOVER PASSWORD</h4>
              <h6 class="font-weight-light">Enter your email address and mobile number to update your password!</h6>
              <form class="pt-3" id="login" method="post" name="login" onsubmit="return valid();">
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" placeholder="Email Address" required="true" name="email">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="mobile" placeholder="Mobile Number" required="true" maxlength="10" pattern="[0-9]+">
                </div>
                <div class="form-group">
                  <input class="form-control form-control-lg" type="password" name="newpassword" placeholder="New Password" required="true" />
                </div>
                <div class="form-group">
                  <input class="form-control form-control-lg" type="password" name="confirmpassword" placeholder="Confirm Password" required="true" />
                </div>
                <div class="mt-3">
                  <button class="btn btn-custom" name="submit" type="submit">Update</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
    <a href="login.php" class="auth-link text-black" style="margin-left: 10px;">Sign in</a>
</div>

                <div class="mb-2">
                  <a href="../index.php" class="btn btn-block custom-back-home-btn">
                    Back Home
                  </a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
</body>

</html>