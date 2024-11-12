<?php
session_start();
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsstuid'] == 0)) {
  header('location:logout.php');
} else {

  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/logo.png" type="image/png">
    <title>STUDENT HANDBOOK ASSISTANCE | View Students Profile</title>
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="vendors/select2/select2.min.css">
    <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="css/style.css" />
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
                  <li class="" aria-current="page"></li>
                </ol>
              </nav>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  <div class="table-responsive">
  <table class="table table-bordered mg-b-0">
    <div id="student-profile-content"></div>

    <?php
    $sid = $_SESSION['sturecmsstuid'];
    $sql = "SELECT tblstudent.StudentName, tblstudent.StudentEmail, tblstudent.StudentClass, tblstudent.Gender, tblstudent.DOB, tblstudent.StuID, tblstudent.FatherName, tblstudent.MotherName, tblstudent.ContactNumber, tblstudent.AltenateNumber, tblstudent.Address, tblstudent.UserName, tblstudent.Password, tblstudent.Image, tblstudent.DateofAdmission, tblclass.ClassName, tblclass.Section 
        FROM tblstudent 
        JOIN tblclass ON tblclass.ID = tblstudent.StudentClass 
        WHERE tblstudent.StuID = :sid";

    $query = $dbh->prepare($sql);
    $query->bindParam(':sid', $sid, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
      foreach ($results as $row) { ?>
        <tr align="center" class="table-warning">
          <td colspan="4" class="text-center" style="font-size:30px;color:#1c82e6;">Student Details</td>
        </tr>

        <tr class="table-info">
          <th class="d-block d-md-table-cell">Student Name</th>
          <td class="d-block d-md-table-cell"><?php echo $row->StudentName; ?></td>
          <th class="d-block d-md-table-cell">Student Email</th>
          <td class="d-block d-md-table-cell"><?php echo $row->StudentEmail; ?></td>
        </tr>
        <tr class="table-warning">
          <th class="d-block d-md-table-cell">Student Class</th>
          <td class="d-block d-md-table-cell"><?php echo $row->ClassName . ' ' . $row->Section; ?></td>
          <th class="d-block d-md-table-cell">Gender</th>
          <td class="d-block d-md-table-cell"><?php echo $row->Gender; ?></td>
        </tr>
        <tr class="table-danger">
          <th class="d-block d-md-table-cell">Date of Birth</th>
          <td class="d-block d-md-table-cell"><?php echo $row->DOB; ?></td>
          <th class="d-block d-md-table-cell">Student ID</th>
          <td class="d-block d-md-table-cell"><?php echo $row->StuID; ?></td>
        </tr>
        <tr class="table-success">
             <th class="d-block d-md-table-cell">Student Contact Number</th>
          <td class="d-block d-md-table-cell"><?php echo $row->AltenateNumber; ?></td>
          <th class="d-block d-md-table-cell"></th>
        
                 </tr>
        <tr class="table-primary">
          <th class="d-block d-md-table-cell">Guardian's Name</th>
          <td class="d-block d-md-table-cell"><?php echo $row->MotherName; ?></td>
           <th class="d-block d-md-table-cell">Contact Number</th>
          <td class="d-block d-md-table-cell"><?php echo $row->ContactNumber; ?></td>
        </tr>
        <tr class="table-progress">
          <th class="d-block d-md-table-cell">Address</th>
          <td class="d-block d-md-table-cell"><?php echo $row->Address; ?></td>
          <th class="d-block d-md-table-cell">User Name</th>
          <td class="d-block d-md-table-cell"><?php echo $row->UserName; ?></td>
        </tr>
        <tr class="table-info">
          <th class="d-block d-md-table-cell">Profile Image</th>
          <td class="d-block d-md-table-cell"><img src="../<?php echo $row->Image; ?>" alt="Student Image" width="100" height="100"></td>
          <th class="d-block d-md-table-cell">Date of Admission</th>
          <td class="d-block d-md-table-cell"><?php echo $row->DateofAdmission; ?></td>
        </tr>
        <tr>
          <td colspan="4" class="text-center">
            <button class="btn custom-add-btn" data-toggle="modal" data-target="#editModal"
              data-id="<?php echo $row->StuID; ?>" data-name="<?php echo $row->StudentName; ?>"
              data-email="<?php echo $row->StudentEmail; ?>" data-class="<?php echo $row->StudentClass; ?>"
              data-gender="<?php echo $row->Gender; ?>" data-dob="<?php echo $row->DOB; ?>"
              data-father="<?php echo $row->FatherName; ?>" data-mother="<?php echo $row->MotherName; ?>"
              data-contact="<?php echo $row->ContactNumber; ?>"
              data-alternate="<?php echo $row->AltenateNumber; ?>"
              data-address="<?php echo $row->Address; ?>" data-username="<?php echo $row->UserName; ?>"
              data-dateofadmission="<?php echo $row->DateofAdmission; ?>">Edit Profile</button>
          </td>
        </tr>
      <?php }
    }
    ?>
  </table>
</div>
                    <!-- <table class="table-responsive table table-bordered mg-b-0">
                      <div id="student-profile-content">
                      </div>


                      <?php
                      $sid = $_SESSION['sturecmsstuid'];
                      $sql = "SELECT tblstudent.StudentName, tblstudent.StudentEmail, tblstudent.StudentClass, tblstudent.Gender, tblstudent.DOB, tblstudent.StuID, tblstudent.FatherName, tblstudent.MotherName, tblstudent.ContactNumber, tblstudent.AltenateNumber, tblstudent.Address, tblstudent.UserName, tblstudent.Password, tblstudent.Image, tblstudent.DateofAdmission, tblclass.ClassName, tblclass.Section 
          FROM tblstudent 
          JOIN tblclass ON tblclass.ID = tblstudent.StudentClass 
          WHERE tblstudent.StuID = :sid";

                      $query = $dbh->prepare($sql);
                      $query->bindParam(':sid', $sid, PDO::PARAM_STR);
                      $query->execute();
                      $results = $query->fetchAll(PDO::FETCH_OBJ);
                      if ($query->rowCount() > 0) {
                        foreach ($results as $row) { ?>
                          <tr align="center" class="table-warning">
                            <td colspan="4" style="font-size:25px;color:#1c82e6;">Students Details</td>
                          </tr>

                          <tr class="table-info">
                            <th>Student Name</th>
                            <td><?php echo $row->StudentName; ?></td>
                            <th>Student Email</th>
                            <td><?php echo $row->StudentEmail; ?></td>
                          </tr>
                          <tr class="table-warning">
                            <th>Student Class</th>
                            <td><?php echo $row->ClassName; ?>       <?php echo $row->Section; ?></td>
                            <th>Gender</th>
                            <td><?php echo $row->Gender; ?></td>
                          </tr>
                          <tr class="table-danger">
                            <th>Date of Birth</th>
                            <td><?php echo $row->DOB; ?></td>
                            <th>Student ID</th>
                            <td><?php echo $row->StuID; ?></td>

                          </tr>
                          <tr class="table-success">
                            <th>Father Name</th>
                            <td><?php echo $row->FatherName; ?></td>
                            <th>Student Contact Number</th>
                            <td><?php echo $row->AltenateNumber; ?></td>
                          </tr>
                          <tr class="table-primary">
                            <th>Contact Number</th>
                            <td><?php echo $row->ContactNumber; ?></td>
                            <th>Mother Name</th>
                            <td><?php echo $row->MotherName; ?></td>
                          </tr>
                          <tr class="table-progress">
                            <th>Address</th>
                            <td><?php echo $row->Address; ?></td>
                            <th>User Name</th>
                            <td><?php echo $row->UserName; ?></td>
                          </tr>
                          <tr class="table-info">
                            <th>Profile Image</th>
                            <td><img src="../<?php echo $row->Image; ?>" alt="Student Image" width="100" height="100">
                            </td>
                            <th>Date of Admission</th>
                            <td><?php echo $row->DateofAdmission; ?></td>
                          </tr>
                          <tr>
                            <td colspan="4" class="text-center">
                              <button class="btn custom-add-btn" data-toggle="modal" data-target="#editModal"
                                data-id="<?php echo $row->StuID; ?>" data-name="<?php echo $row->StudentName; ?>"
                                data-email="<?php echo $row->StudentEmail; ?>" data-class="<?php echo $row->StudentClass; ?>"
                                data-gender="<?php echo $row->Gender; ?>" data-dob="<?php echo $row->DOB; ?>"
                                data-father="<?php echo $row->FatherName; ?>" data-mother="<?php echo $row->MotherName; ?>"
                                data-contact="<?php echo $row->ContactNumber; ?>"
                                data-alternate="<?php echo $row->AltenateNumber; ?>"
                                data-address="<?php echo $row->Address; ?>" data-username="<?php echo $row->UserName; ?>"
                                data-dateofadmission="<?php echo $row->DateofAdmission; ?>">Edit Profile</button>
                                
                            </td>
                          </tr>
                          <?php
                        }
                      }
                      ?>
                    </table> -->

                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Edit Modal -->
          <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content" style="background-color: #fff;">
                <div class="modal-header">
                  <h3 class="modal-title" id="editModalLabel" style="text-align: center; width: 100%;color: #1c82e6;">Edit
                    Student Profile</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body">
                  <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="studentName">Student Name</label>
                      <input type="text" class="form-control custom-input" id="studentName" name="studentName"
                        value="<?php echo htmlspecialchars($row->StudentName); ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="studentEmail">Student Email</label>
                      <input type="email" class="form-control custom-input" id="studentEmail" name="studentEmail"
                        value="<?php echo htmlspecialchars($row->StudentEmail); ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="studentClass">Student Class</label>
                      <select name="studentClass" class="form-control" required style="border: 1px solid #ccc;">
                        <?php
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

                    </div>
                    <div class="form-group">
                      <label for="altenateNumber">Student Contact Number</label>
                      <input type="text" class="form-control custom-input" id="altenateNumber" name="altenateNumber"
                        value="<?php echo htmlspecialchars($row->AltenateNumber); ?>">
                    </div>
                    <div class="form-group">
                      <label for="gender">Gender</label>
                      <select name="gender" class="form-control" required='true' style="border: 1px solid #ccc;">
                        <option value="Male" <?php echo ($row->Gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo ($row->Gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="dob">Date of Birth</label>
                      <input type="date" class="form-control custom-input" id="dob" name="dob"
                        value="<?php echo htmlspecialchars($row->DOB); ?>" required>
                    </div>
                   
                    <div class="form-group">
                      <label for="motherName">Guardian's Name</label>
                      <input type="text" class="form-control custom-input" id="motherName" name="motherName"
                        value="<?php echo htmlspecialchars($row->MotherName); ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="contactNumber">Contact Number</label>
                      <input type="text" class="form-control custom-input" id="contactNumber" name="contactNumber"
                        value="<?php echo htmlspecialchars($row->ContactNumber); ?>" required>
                    </div>

                    <div class="form-group">
                      <label for="address">Address</label>
                      <textarea class="form-control custom-input" id="address" name="address"
                        required><?php echo htmlspecialchars($row->Address); ?></textarea>
                    </div>
                    <div class="form-group">
                      <label for="profileImage">Profile Image</label>
                      <input type="file" class="form-control custom-input" id="profileImage" name="profileImage">
                    </div>

                    <input type="hidden" name="studentId" value="<?php echo htmlspecialchars($row->StuID); ?>">
                    
                     <button type="submit" name="submit" class="custom-add-btn">Save changes</button>
                  </form>
                </div>
              </div>
            </div>
          </div>


        </div>
      </div>
    </div>

    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="vendors/select2/select2.min.js"></script>
    <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/template.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/todolist.js"></script>
    <script src="js/file-upload.js"></script>
    <script src="js/typeahead.js"></script>
    <script src="js/select2.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>




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
    
    
    
    <script>
      $(document).ready(function(){
        $('#contactNumber, #altenateNumber').keypress(function(event) {
            var charCode = event.which;
            // Allow only numbers (0-9)
            if (charCode >= 48 && charCode <= 57) {
                return true;
            } else {
                return false;
            }
        });

        $('#studentName, #fatherName, #motherName').keypress(function(event) {
            var charCode = event.which;
            // Allow A-Z, a-z and space (charCode 32)
            if ((charCode >= 65 && charCode <= 90) || 
                (charCode >= 97 && charCode <= 122) || 
                charCode == 32) {
                return true;
            } else {
                return false;
            }
        });
      })
    </script>
  </body>

  </html>
<?php } ?>