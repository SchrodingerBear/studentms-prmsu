<?php
function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('includes/dbconnection.php');
    include('mailer.php');

    $code = generateRandomString(10);

    // Retrieve form data
    $stuname = $_POST['stuname'];
    $stuemail = $_POST['stuemail'];
    $stuclass = $_POST['stuclass'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $stuid = $_POST['stuid'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $connum = $_POST['connum'];
    $altconnum = $_POST['altconnum'];
    $address = $_POST['address'];
    $password = $_POST['password'];

    // Handle file upload
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $target_dir = "user/images/faces/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($image_tmp, $target_file);
    } else {
        $image = "user/images/faces/default.jpg";
    }

    // Insert data into the database
    $sql = "INSERT INTO tblstudent (StudentName, StudentEmail, StudentClass, Gender, DOB, StuID, FatherName, MotherName, ContactNumber, AltenateNumber, Address, UserName, Password, Image, code) 
            VALUES (:stuname, :stuemail, :stuclass, :gender, :dob, :stuid, :fname, :mname, :connum, :altconnum, :address, :uname, :password, :image, :code)";

    $stmt = $dbh->prepare($sql);

    // Execute and check if the insertion was successful
    if (
        $stmt->execute([
            ':stuname' => $stuname,
            ':stuemail' => $stuemail,
            ':stuclass' => $stuclass,
            ':gender' => $gender,
            ':dob' => $dob,
            ':stuid' => $stuid,
            ':fname' => $fname,
            ':mname' => $mname,
            ':connum' => $connum,
            ':altconnum' => $altconnum,
            ':address' => $address,
            ':uname' => $stuid,
            ':password' => $password,
            ':image' => "user/images/faces/$image",
            ':code' => $code
        ])
    ) {
        // If successfully added, send the email
        sendEmail($stuid, $stuemail, $stuname, $code);

        // Show notification
        echo "<script>
                alert('Student registered successfully! Check your email before logging in.');
              </script>";
    } else {
        // Show error message if insertion failed
        echo "<script>
                alert('Failed to register student.');
              </script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/logo.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Custom CSS -->
    <style>
        .container {
            margin-top: 20px;
        }

        .form-section {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <form class="form-section" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="stuname">Student Name</label>
                <input type="text" name="stuname" id="stuname" class="form-control custom-input" required>
            </div>
            <div class="form-group">
                <label for="stuemail">Student Email</label>
                <input type="email" name="stuemail" id="stuemail" class="form-control custom-input" required>
            </div>
            <div class="form-group">
                <label for="studentClass">Student Class</label>
                <select class="form-control" id="stuclass" name="stuclass" required>
                    <option value="">Select Class</option>
                    <?php
                    include('includes/dbconnection.php');
                    // Fetch classes for the dropdown
                    $classSql = "SELECT ID, ClassName, Section FROM tblclass";
                    $classQuery = $dbh->prepare($classSql);
                    $classQuery->execute();
                    $classes = $classQuery->fetchAll(PDO::FETCH_OBJ);
                    foreach ($classes as $class) {
                        $selected = ($class->ID == $row->StudentClass) ? 'selected' : '';
                        $displayText = htmlspecialchars($class->ClassName) . ' - ' . htmlspecialchars($class->Section);
                        echo '<option value="' . htmlspecialchars($class->ID) . '" ' . $selected . '>' . $displayText . '</option>';
                    }
                    ?>
                </select>
                <div class="form-group mt-3"> <!-- Added mt-3 class for spacing -->
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" class="form-control custom-input" required>
                        <option value="">Choose Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" name="dob" id="dob" class="form-control custom-input" required>
                </div>
                <div class="form-group">
                    <label for="altconnum">Student Contact Number</label>
                    <input type="text" name="altconnum" id="altconnum" class="form-control custom-input" required
                        pattern="\d{11}" title="Contact number must be exactly 11 digits">
                </div>
                <div class="form-group">
                    <label for="image">Student Photo</label>
                    <input type="file" name="image" class="form-control custom-input">
                </div>

                <h3 style="margin-top: 20px; color: #1c82e6;">Guardian's Details</h3>
                <div class="form-group">
                    <label for="fname">Father's Name</label>
                    <input type="text" name="fname" id="fname" class="form-control custom-input">
                </div>
                <div class="form-group">
                    <label for="mname">Mother's Name</label>
                    <input type="text" name="mname" id="mname" class="form-control custom-input">
                </div>
                <div class="form-group">
                    <label for="connum">Contact Number</label>
                    <input type="text" name="connum" id="connum" class="form-control custom-input" pattern="\d{11}"
                        title="Contact number must be exactly 11 digits">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea name="address" id="address" class="form-control custom-input" required
                        placeholder="purok/barangay/municipality/province"></textarea>
                </div>

                <h3 style="margin-top: 20px; color: #1c82e6;">Login Details</h3>
                <div class="form-group">
                    <label for="stuid">Student ID</label>
                    <input type="text" name="stuid" id="stuid" class="form-control custom-input" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control custom-input" required>
                </div>
                <button type="submit" class="custom-add-btn">Register</button>
        </form>
    </div>

    <!-- Modal for Notification -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationModalLabel">Notification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (isset($message))
                        echo $message; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {

            $(document).ready(function () {
                <?php if (isset($message)) { ?>
                    $('#notificationModal').modal('show');
                <?php } ?>
            });

            // Restrict input for Contact Numbers to only numbers
            $('#connum, #altconnum').keypress(function (event) {
                var charCode = event.which;
                if (charCode >= 48 && charCode <= 57) { // Allow numbers (0-9)
                    return true;
                } else {
                    return false;
                }
            });

            // Restrict input for names to only letters and spaces
            $('#stuname, #fname, #mname').keypress(function (event) {
                var charCode = event.which;
                if ((charCode >= 65 && charCode <= 90) || // A-Z
                    (charCode >= 97 && charCode <= 122) || // a-z
                    charCode == 32) { // space
                    return true;
                } else {
                    return false;
                }
            });

            // Validate the Student ID (stuid)
            $('#stuid').on('input', function () {
                var inputVal = $(this).val();

                // Allow letters (A-Z, a-z), numbers (0-9), and dashes (-), restrict to 11 characters
                inputVal = inputVal.replace(/[^a-zA-Z0-9\-]/g, ''); // Keep only letters, digits, and dashes
                if (inputVal.length > 11) {
                    inputVal = inputVal.substring(0, 11); // Limit to 11 characters
                }

                // Set the cleaned value back to the input field
                $(this).val(inputVal);

                // Validate the format "XX-X-X-XXXX" (11 characters with dashes, letters allowed)
                var pattern = /^[a-zA-Z0-9]{2}-[a-zA-Z0-9]{1}-[a-zA-Z0-9]{1}-[a-zA-Z0-9]{4}$/;
                if (pattern.test(inputVal)) {
                    console.log('correct');
                } else {
                    console.log('error');
                }
            });
        });


    </script>

    </script>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .custom-input {
            border: 1px solid #acb7c2;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        .custom-input:focus {
            border-color: #1c82e6;
            outline: none;
        }

        .custom-add-btn {
            background-color: #1c82e6;
            color: #fff;
            border: none;
            padding: 10px 30px;
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

        /* Add spacing below each form group for consistency */
        .form-group {
            margin-bottom: 20px;
        }

        .custom-input {
            border: 1px solid #acb7c2;
            /* Thicker border */
            border-radius: 5px;
            padding: 3px;
            /* Reduced padding for smaller placeholder */
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }
    </style>


</body>

</html>