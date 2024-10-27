<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $sql = "SELECT ID FROM tbladmin WHERE UserName=:username and Password=:password";
  $query = $dbh->prepare($sql);
  $query->bindParam(':username', $username, PDO::PARAM_STR);
  $query->bindParam(':password', $password, PDO::PARAM_STR);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_OBJ);
  if ($query->rowCount() > 0) {
    foreach ($results as $result) {
      $_SESSION['sturecmsaid'] = $result->ID;
    }

    if (!empty($_POST["remember"])) {
      // COOKIES for username
      setcookie("user_login", $_POST["username"], time() + (10 * 365 * 24 * 60 * 60));
      // COOKIES for password
      setcookie("userpassword", $_POST["password"], time() + (10 * 365 * 24 * 60 * 60));
    } else {
      if (isset($_COOKIE["user_login"])) {
        setcookie("user_login", "");
      }
      if (isset($_COOKIE["userpassword"])) {
        setcookie("userpassword", "");
      }
    }
    $_SESSION['login'] = $_POST['username'];
    
    echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
 } else {
    echo "
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
    <div class='toast-container position-fixed top-0 start-50 translate-middle-x p-3'>
      <div id='invalidToast' class='toast text-bg-danger' role='alert' aria-live='assertive' aria-atomic='true'>
        <div class='toast-body'>
          Invalid password. Please try again.
        </div>
      </div>
    </div>
    <script>
      var invalidToast = new bootstrap.Toast(document.getElementById('invalidToast'));
      invalidToast.show();
    </script>
    ";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" href="../images/logo.png" type="image/png">
  <title>STUDENT HANDBOOK ASSISTANCE | Login Page</title>
  <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

 <style>

    .text-center {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
}

     .custom-login-btn {
    background-color: #ffc42e;
    color: #fff;  
    border: none; 
    padding: 10px 20px;
    border-radius: 30px; 
    font-weight: bold; 
    font-size: 16px;
    transition: background-color 0.3s ease; 
}

.custom-login-btn:hover {
    background-color: #e6c05e; 
    color: #fff; 
    cursor: pointer;
}

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
    background-color: #155ba0;
    color: #fff; 
    cursor: pointer;
}

.custom-back-home-btn i {
    margin-right: 8px; /* Space between icon and text */
}


/* Make the border of the input field more visible */
.form-control {
    border: 1px solid #ccc; /* Thicker and more visible border */
    border-radius: 5px; /* Rounded corners */
    padding: 10px;
}

/* Add focus effect */
.form-control:focus {
    border-color: #1E90FF; /* Highlight border on focus */
    box-shadow: 0 0 5px rgba(30, 144, 255, 0.5); /* Light blue shadow */
    outline: none; /* Remove default outline */
}

/* Optional: Hover effect */
.form-control:hover {
    border-color: #FED365; /* Change color when hovering */
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

    .loginbtn {
      background-color: #28a745;
      border: none;
    }

    .loginbtn:hover {
      background-color: #218838;
    }

    .register-link {
      text-align: center !important;
      color: #28a745;
    }

    .auth-link:hover {
      text-decoration: underline;
    }

    .form-check-label {
      margin-left: 10px;
    }

    .register-link {
      margin-top: 20px;
      font-size: 14px;
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
    <div class="content-wrapper d-flex align-items-center auth">
      <div class="row flex-grow">
        <div class="col-lg-4 mx-auto">
          <div class="auth-form-light text-left p-5">
           <div class="brand-logo">
    <img src="../images/prmsu.png" alt="Logo">
</div>

<!-- Center the following content -->
<div class="text-center">
    <h3 class="mt-4">Admin Login</h3>
    <h6 class="font-weight-light"></h6>
</div>

<form class="pt-3" id="login" method="post" name="login">
    <div class="form-group">
        <input id="usernameInput" type="text" class="form-control form-control-lg" placeholder="Enter your username"
            required="true" name="username" value="admin" hidden>
    </div>
    <!-- Add the rest of your form fields and buttons here -->
</form>

           <form class="pt-3" id="loginForm" method="POST" action="">
              <div class="form-group">
                 <input id="usernameInput" type="text" class="form-control form-control-lg" placeholder="Enter your username"
                 required="true" name="username" value="admin" hidden>
              </div>
              <div class="form-group">
                 <input type="password" class="form-control form-control-lg" placeholder="Enter your password"
                 name="password" required="true" value="<?php if (isset($_COOKIE['userpassword'])) { echo $_COOKIE['userpassword']; } ?>">
              </div>
              <div class="mt-3">
                 <button class="btn btn-block custom-login-btn" name="login" type="submit">Login</button>
              </div>

              <div class="mb-2 mt-4">
                 <a href="../index.php" class="btn btn-block custom-back-home-btn">
                   <i class="icon-social-home mr-2"></i>Back Home
    </a>
</div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
        $(document).ready(function(){
            // Bind the input event to validate while typing
            $('#usernameInput').on('input', function() {
                // Get the input value
                var inputVal = $(this).val();
                console.log(inputVal)
                
                // Define the regex pattern for validation
                var pattern = /^21-\d-\d-\d{4}$/;

                // Validate the input value against the pattern
                if (pattern.test(inputVal)) {
                    console.log('correct')
                } else {
                  console.log('error')
                }
            });
        });
    </script>
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
</body>

</html>