<?php
session_start();
include('includes/dbconnection.php');

if (isset($_POST['studentId'])) {
    $studentId = $_POST['studentId'];
    $studentName = $_POST['studentName'];
    $studentEmail = $_POST['studentEmail'];
    $studentClass = $_POST['studentClass'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $fatherName = $_POST['fatherName'];
    $motherName = $_POST['motherName'];
    $contactNumber = $_POST['contactNumber'];
    $altenateNumber = $_POST['altenateNumber'];
    $address = $_POST['address'];

    // Handle file upload
    $profileImage = isset($_FILES['profileImage']['name']) ? $_FILES['profileImage']['name'] : '';
    $target_dir = "images/faces/";
    $newImageName = $studentId . '.' . pathinfo($profileImage, PATHINFO_EXTENSION);
    $target_file = $target_dir . basename($newImageName);

    if ($profileImage) {
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $target_file)) {
            $imagePath = $target_dir . $newImageName;
        } else {
            $imagePath = '';
        }
    } else {
        $imagePath = '';
    }

    $sql = "UPDATE tblstudent SET 
            StudentName = :studentName,
            StudentEmail = :studentEmail,
            StudentClass = :studentClass,
            Gender = :gender,
            DOB = :dob,
            FatherName = :fatherName,
            MotherName = :motherName,
            ContactNumber = :contactNumber,
            AltenateNumber = :altenateNumber,
            Address = :address"
        . ($profileImage ? ", Image = CONCAT('user/', :profileImage)" : "") .

        " WHERE StuID = :studentId";

    $query = $dbh->prepare($sql);

    // Bind all parameters
    $query->bindParam(':studentName', $studentName, PDO::PARAM_STR);
    $query->bindParam(':studentEmail', $studentEmail, PDO::PARAM_STR);
    $query->bindParam(':studentClass', $studentClass, PDO::PARAM_STR);
    $query->bindParam(':gender', $gender, PDO::PARAM_STR);
    $query->bindParam(':dob', $dob, PDO::PARAM_STR);
    $query->bindParam(':fatherName', $fatherName, PDO::PARAM_STR);
    $query->bindParam(':motherName', $motherName, PDO::PARAM_STR);
    $query->bindParam(':contactNumber', $contactNumber, PDO::PARAM_STR);
    $query->bindParam(':altenateNumber', $altenateNumber, PDO::PARAM_STR);
    $query->bindParam(':address', $address, PDO::PARAM_STR);
    $query->bindParam(':studentId', $studentId, PDO::PARAM_STR);

    if ($profileImage) {
        $query->bindParam(':profileImage', $imagePath, PDO::PARAM_STR);
    }

    if ($query->execute()) {
        $updateStatus = "Student profile updated successfully.";
    } else {
        $updateStatus = "Something went wrong. Please try again.";
    }

    echo "<h2>Debugging Information:</h2>";
    echo "<p><strong>Student ID:</strong> $studentId</p>";
    echo "<p><strong>Student Name:</strong> $studentName</p>";
    echo "<p><strong>Student Email:</strong> $studentEmail</p>";
    echo "<p><strong>Student Class:</strong> $studentClass</p>";
    echo "<p><strong>Gender:</strong> $gender</p>";
    echo "<p><strong>DOB:</strong> $dob</p>";
    echo "<p><strong>Father's Name:</strong> $fatherName</p>";
    echo "<p><strong>Mother's Name:</strong> $motherName</p>";
    echo "<p><strong>Contact Number:</strong> $contactNumber</p>";
    echo "<p><strong>Alternate Number:</strong> $altenateNumber</p>";
    echo "<p><strong>Address:</strong> $address</p>";
    echo "<p><strong>Database Update Status:</strong> $updateStatus</p>";

    header("Location: student-profile.php");
    exit();
}
?>