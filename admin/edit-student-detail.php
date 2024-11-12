<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../mailer.php');

session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $stuname = $_POST['stuname'];
        $stuemail = $_POST['stuemail'];
        $stuclass = $_POST['stuclass'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $stuid = $_POST['stuid'];
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $verify = $_POST['verify'];
        $connum = $_POST['connum'];
        $altconnum = $_POST['altconnum'];
        $address = $_POST['address'];
        $password = $_POST['password'];
        $eid = $_GET['editid'];

        // Handle image upload
        if (isset($_FILES['studentPhoto']) && $_FILES['studentPhoto']['error'] == UPLOAD_ERR_OK) {
            $uploadsDir = 'images/'; // Path kung saan i-save ang images
            $tmpName = $_FILES['studentPhoto']['tmp_name'];
            $fileName = $_FILES['studentPhoto']['name'];
            $filePath = $uploadsDir . basename($fileName);

            // Move the uploaded file to the images directory
            if (move_uploaded_file($tmpName, $filePath)) {
                // Update the student's photo path in the database
                $sql = "UPDATE tblstudent SET Photo = :photo WHERE ID = :eid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':photo', $fileName); // Save the filename in the database
                $query->bindParam(':eid', $eid);
                $query->execute();
            } else {
                echo '<script>alert("Failed to upload the image.")</script>';
            }
        }

        $sql = "UPDATE tblstudent SET 
            StudentName = :stuname,
            StudentEmail = :stuemail,
            StudentClass = :stuclass,
            Gender = :gender,
            DOB = :dob,
            FatherName = :fname,
            MotherName = :mname,
            ContactNumber = :connum,
            AltenateNumber = :altconnum,
            verify = :verify,
            Address = :address,
            Password = :password 
            WHERE ID = :eid";

        $query = $dbh->prepare($sql);
        $query->bindParam(':stuname', $stuname);
        $query->bindParam(':stuemail', $stuemail);
        $query->bindParam(':stuclass', $stuclass);
        $query->bindParam(':gender', $gender);
        $query->bindParam(':dob', $dob);
        $query->bindParam(':fname', $fname);
        $query->bindParam(':mname', $mname);
        $query->bindParam(':connum', $connum);
        $query->bindParam(':altconnum', $altconnum);
        $query->bindParam(':address', $address);
        $query->bindParam(':password', $password);
        $query->bindParam(':eid', $eid);
        $query->bindParam(':verify', $verify);

        // Execute the query and check if the update was successful
        if ($query->execute()) {

            if ($verify == 1) {
                sendEmail($stuid, $stuemail, $stuname, 'verifieduser');
            }

            // Show success toast
            echo "
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
            <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
            <div class='toast-container position-fixed top-0 start-50 translate-middle-x p-3'>
                <div id='studentUpdatedToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' style='background-color: #1c82e6; color: white;'>
                    <div class='toast-body'>
                        Student details have been successfully updated.
                    </div>
                </div>
            </div>
            <script>
                var studentUpdatedToast = new bootstrap.Toast(document.getElementById('studentUpdatedToast'));
                studentUpdatedToast.show();
            </script>
            ";
        } else {
            echo '<script>alert("Something Went Wrong. Please try again")</script>';
        }
    }

    // Fetch student details for editing
    $eid = $_GET['editid'];
    $sql = "SELECT 
        tblstudent.verify,
        tblstudent.StudentName,
        tblstudent.StudentEmail,
        tblstudent.StudentClass,
        tblstudent.Gender,
        tblstudent.DOB,
        tblstudent.StuID,
        tblstudent.FatherName,
        tblstudent.MotherName,
        tblstudent.ContactNumber,
        tblstudent.AltenateNumber,
        tblstudent.Address,
        tblstudent.Password,
       
        tblclass.ClassName,
        tblclass.Section 
        FROM tblstudent 
        JOIN tblclass ON tblclass.ID = tblstudent.StudentClass 
        WHERE tblstudent.ID = :eid";

    $query = $dbh->prepare($sql);
    $query->bindParam(':eid', $eid);
    $query->execute();
    $student = $query->fetch(PDO::FETCH_OBJ);

    if (!$student) {
        echo '<script>alert("Student not found")</script>';
        exit;
    }

    // Set the path for student photo
    $studentPhoto = !empty($student->StudentPhoto) ? '../uploads/' . htmlentities($student->StudentPhoto) : '../images/default.png';

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <link rel="icon" href="../images/logo.png" type="image/png">
        <title>STUDENT HANDBOOK ASSISTANCE | Update Students</title>
        <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
        <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
        <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
        <link rel="stylesheet" href="vendors/select2/select2.min.css">
        <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link rel="stylesheet" href="css/style.css" />
        <style>
            body {
                background-color: #f8f9fa;
                /* Light background for better contrast */
            }

            .card {
                border-radius: 10px;
                /* Rounded corners for cards */
                margin-bottom: 30px;
                /* Spacing between cards */
            }

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
                cursor: pointer;
            }

            .form-group {
                margin-bottom: 20px;
                /* Space between input fields */
            }

            h3 {
                margin-top: 20px;
                /* Space above section headers */
                color: #1c82e6;
                /* Matching header color */
            }

            .custom-input {
                border: 1px solid #acb7c2;
                border-radius: 5px;
                padding: 10px;
            }
        </style>
    </head>

    <body>
        <div class="container-scroller">
            <?php include_once('includes/header.php'); ?>
            <div class="container-fluid page-body-wrapper">
                <?php include_once('includes/sidebar.php'); ?>
                <div class="main-panel">
                    <div class="content-wrapper" style="background-color: #c71d68;">
                        <div class="page-header">
                            <h3 class="page-title"> </h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard.php"></a></li>
                                    <li class="" aria-current="page"> </li>
                                </ol>
                            </nav>
                        </div>
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title" style="text-align: center;">Update Student</h4>




                                        <form class="forms-sample" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="stuname">Student Name</label>
                                                <input type="text" name="stuname" id="stuname"
                                                    value="<?php echo htmlentities($student->StudentName); ?>"
                                                    class="form-control custom-input" required='true'>
                                            </div>
                                            <div class="form-group">
                                                <label for="verify">Verification Status</label>
                                                <select name="verify" class="form-control custom-input" required
                                                    style="border: 1px solid #acb7c2; outline: none;">
                                                    <option value="1" <?php if ($student->verify == 1)
                                                        echo 'selected'; ?>>
                                                        Verified</option>
                                                    <option value="0" <?php if ($student->verify == 0)
                                                        echo 'selected'; ?>>Not
                                                        Verified</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="stuemail">Student Email</label>
                                                <input type="email" name="stuemail"
                                                    value="<?php echo htmlentities($student->StudentEmail); ?>"
                                                    class="form-control custom-input" required='true'>
                                            </div>
                                            <div class="form-group">
                                                <label for="stuclass">Student Class</label>
                                                <select name="stuclass" class="form-control custom-input" required
                                                    style="border: 1px solid #acb7c2; outline: none;">

                                                    <option value="<?php echo htmlentities($student->StudentClass); ?>">
                                                        <?php echo htmlentities($student->ClassName . ' ' . $student->Section); ?>
                                                    </option>
                                                    <?php
                                                    $sql2 = "SELECT * FROM tblclass";
                                                    $query2 = $dbh->prepare($sql2);
                                                    $query2->execute();
                                                    $classes = $query2->fetchAll(PDO::FETCH_OBJ);
                                                    foreach ($classes as $class) {
                                                        echo '<option value="' . htmlentities($class->ID) . '">' . htmlentities($class->ClassName . ' ' . $class->Section) . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="altconnum">Student Contact Number</label>
                                                <input type="text" name="altconnum" id="altconnum"
                                                    value="<?php echo htmlentities($student->AltenateNumber); ?>"
                                                    class="form-control custom-input" required='true' maxlength="11">
                                            </div>
                                            <div class="form-group">
                                                <label for="gender">Gender</label>
                                                <select name="gender" id="gender" class="form-control custom-input" required
                                                    style="border: 1px solid #acb7c2; outline: none;">
                                                    <option value="<?php echo htmlentities($student->Gender); ?>">
                                                        <?php echo htmlentities($student->Gender); ?>
                                                    </option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="dob">Date of Birth</label>
                                                <input type="date" name="dob"
                                                    value="<?php echo htmlentities($student->DOB); ?>"
                                                    class="form-control custom-input" required='true'>
                                            </div>


                                            <h3>Guardian's details</h3>
                                            
                                            <div class="form-group">
                                                <label for="mname">Guardian's Name</label>
                                                <input type="text" name="mname" id="mname"
                                                    value="<?php echo htmlentities($student->MotherName); ?>"
                                                    class="form-control custom-input">
                                            </div>
                                            <div class="form-group">
                                                <label for="connum">Contact Number</label>
                                                <input type="text" name="connum" id="connum"
                                                    value="<?php echo htmlentities($student->ContactNumber); ?>"
                                                    class="form-control custom-input" required='true' maxlength="11">
                                            </div>
                                            <div class="form-group">
                                                <label for="address">Address</label>
                                                <textarea name="address" class="form-control custom-input"
                                                    required='true'><?php echo htmlentities($student->Address); ?></textarea>
                                            </div>
                                            <h3>Login details</h3>
                                            <div class="form-group">
                                                <label for="stuid">Student ID</label>
                                                <input type="text" name="stuid"
                                                    value="<?php echo htmlentities($student->StuID); ?>"
                                                    class="form-control custom-input " readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="text" name="password"
                                                    value="<?php echo htmlentities($student->Password); ?>"
                                                    class="form-control custom-input">
                                            </div>

                                            <button type="submit" name="submit" class="custom-add-btn">Update</button>
                                            <button type="button" class="custom-add-btn"
                                                onclick="window.location.href='manage-students.php'">Cancel</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include_once('includes/footer.php'); ?>
                </div>
            </div>
        </div>
    </body>

    </html>

    </div>
    </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#connum, #altconnum').keypress(function (event) {
                var charCode = event.which;
                if (charCode >= 48 && charCode <= 57) {
                    return true;
                } else {
                    return false;
                }
            });

            $('#stuname, #fname, #mname').keypress(function (event) {
                var charCode = event.which;
                if ((charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122) || charCode == 32) {
                    return true;
                } else {
                    return false;
                }
            });
        });
    </script>
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="vendors/select2/select2.min.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <script src="js/typeahead.js"></script>
    <script src="js/select2.js"></script>

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
<?php } ?>