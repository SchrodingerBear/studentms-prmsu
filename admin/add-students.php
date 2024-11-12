<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="../images/logo.png" type="image/png">
    <title>STUDENT HANDBOOK ASSISTANCE | Add Students</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="vendors/select2/select2.min.css">
    <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
                                    <h4 class="card-title" style="text-align: center;">Add Students</h4>

                                    <form id="studentForm" class="forms-sample" enctype="multipart/form-data">

                                        <div class="form-group">
                                            <label for="exampleInputName1">Student Name</label>
                                            <input type="text" name="stuname" id="stuname" value="" class="form-control custom-input" required='true'>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Student Email</label>
                                            <input type="text" name="stuemail" value="" class="form-control custom-input" required='true'>
                                        </div>

                                        <div class="form-group">
                                            <label for="stuclass">Student Class</label>
                                            <select name="stuclass" id="stuclass" class="form-control custom-input" required style="border: 1px solid #acb7c2; outline: none;">
                                                <option value="">Select Class</option>
                                                <?php
                                                $sql2 = "SELECT * from tblclass ";
                                                $query2 = $dbh->prepare($sql2);
                                                $query2->execute();
                                                $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                                                foreach ($result2 as $row1) {
                                                ?>
                                                    <option value="<?php echo htmlentities($row1->ID); ?>">
                                                        <?php echo htmlentities($row1->ClassName); ?> <?php echo htmlentities($row1->Section); ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputName1">Student Contact Number</label>
                                            <input type="text" name="altconnum" id="altconnum" value="" class="form-control custom-input" required='true' maxlength="11">
                                        </div>

                                        <div class="form-group">
                                            <label for="gender">Gender</label>
                                            <select name="gender" id="gender" class="form-control custom-input" required style="border: 1px solid #acb7c2; outline: none;">
                                                <option value="">Choose Gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Date of Birth</label>
                                            <input type="date" name="dob" value="" class="form-control custom-input" required='true'>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputName1">Student ID</label>
                                            <input type="text" id="stuid" name="stuid" value="" class="form-control custom-input" required='true'>
                                        </div>

                                       <div class="form-group">
    <label for="image">Student Photo</label>
    <input type="file" name="image" class="form-control custom-input">
</div>

                                     <h3 style="margin-top: 20px; color: #1c82e6;">Guardian's Details</h3>
                                        

                                        <div class="form-group">
                                            <label for="exampleInputName1">Guardian's Name</label>
                                            <input type="text" name="mname" id="mname" value="" class="form-control custom-input">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputName1">Contact Number</label>
                                            <input type="text" name="connum" id="connum" value="" class="form-control custom-input" required='true' maxlength="11">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputName1">Address</label>
                                            <textarea name="address" class="form-control custom-input" required='true' placeholder="purok/barangay/municipality/province"></textarea>
                                        </div>

                                        <h3 style="margin-top: 20px; color: #1c82e6;">Login Details</h3>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Student ID</label>
                                            <input type="text" id="uname" name="uname" value="" class="form-control custom-input" required='true' readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputName1">Password</label>
                                            <input type="Password" name="password" value="" class="form-control custom-input" required='true'>
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
</div>

<!-- Script -->
<script>
    $(document).ready(function() {
        $('#studentForm').on('submit', function(event) {
            event.preventDefault();

            // Create a FormData object to send the form data including the image file
            var formData = new FormData(this);

            $.ajax({
                url: 'rest/add-student.php', // PHP file where the data is sent
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    alert(response); // Show the response
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + xhr.responseText);
                }
            });
        });

        $('#connum, #altconnum').keypress(function(event) {
            var charCode = event.which;
            // Allow only numbers (0-9)
            if (charCode >= 48 && charCode <= 57) {
                return true;
            } else {
                return false;
            }
        });

        $('#stuname, #fname, #mname').keypress(function(event) {
            var charCode = event.which;
            // Allow A-Z, a-z, and space (charCode 32)
            if ((charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122) || charCode == 32) {
                return true;
            } else {
                return false;
            }
        });

        // Handle Student ID input and sync it with User Name
        $('#stuid').on('input', function() {
            var inputVal = $(this).val();

            // Allow only letters, numbers, and dashes
            inputVal = inputVal.replace(/[^a-zA-Z0-9\-]/g, '');

            // Restrict to 11 characters
            if (inputVal.length > 11) {
                inputVal = inputVal.substring(0, 11);
            }

            // Set the cleaned value back to the input field
            $(this).val(inputVal);

            // Sync User Name with Student ID
            $('#uname').val(inputVal);
        });
    });
 </script>
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

/* General styles for custom inputs */
.custom-input {
    border: 1px solid #acb7c2;
    border-radius: 5px;
    padding: 10px;
    transition: border-color 0.3s ease;
}

/* Styles for select dropdown */
select.custom-input {
    appearance: none; /* Remove default styling */
    background-color: white; /* Ensure background is white */
    padding: 10px; /* Ensure consistent padding */
    font-size: 14px; /* Set the font size */
    color: #495057; /* Text color */
}

/* Placeholder text styling for the disabled option */
.custom-input option[disabled] {
    color: #6c757d; /* Color for the placeholder option */
}

/* Selected value styling to match the placeholder color */
select.custom-input {
    color: #6c757d; /* Match selected text color with placeholder color */
}

/* Placeholder styling for textareas */
textarea.custom-input {
    height: auto;
    min-height: 38px;
    padding: 10px;
}

/* Placeholder text styling for inputs */
.custom-input::placeholder {
    font-size: 14px; 
    color: #6c757d; 
}
.custom-input {
    border: 1px solid #acb7c2; /* Thicker border */
    border-radius: 4px; 
    padding: 13px; /* Reduced padding for smaller placeholder */
    transition: border-color 0.3s ease; 
    box-sizing: border-box;
}


</style>

</body>

</html>
<?php } ?>  