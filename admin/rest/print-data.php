<?php
include('../includes/restconnection.php');

$violationID = isset($_GET['violationID']) ? (int) $_GET['violationID'] : 0; // Ensure violationID is valid

// Query to get violation and student details
$sql = "SELECT violations.*, tblstudent.* FROM violations 
INNER JOIN tblstudent ON violations.student_id = tblstudent.ID WHERE violations.id = $violationID";
$result = mysqli_query($conn, $sql);

// Check if the query is successful and has results
if (!$result || mysqli_num_rows($result) === 0) {
  header("Location: ../manage-violations.php");
  exit();
}

$row = $result->fetch_assoc();
?>

<style>
  table {
    border-collapse: collapse;
    border: 1px solid #ccc;
  }

  th,
  td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: left;
  }

  th {
    background-color: #f2f2f2;
  }

  img {
    width: 100px;
    height: 100px;
  }

  main {
    display: grid;
    place-items: center;
  }

  .container {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  button {
    padding: 0.5rem 1rem;
  }

  @media print {
    @page {
      size: A4;
      /* Set page size to A4 */
      margin: 1cm;
      /* Set margins to 1 cm */
    }

    button {
      display: none;
    }
  }
</style>

<main>
  <div class="container">
    <img src="../../<?php echo htmlspecialchars($row['Image']); ?>" alt="Student Image" />
    <table>
      <tr>
        <th>Student Details</th>
      </tr>
      <tr>
        <td>Student Name: </td>
        <td><?php echo htmlspecialchars($row['StudentName']); ?></td>
      </tr>
      <tr>
        <td>Student Email: </td>
        <td><?php echo htmlspecialchars($row['StudentEmail']); ?></td>
      </tr>
      <tr>
        <td>Student Class: </td>
        <td>
          <?php
          $getClassName = "SELECT ClassName, Section FROM tblclass WHERE ID = " . $row['StudentClass'];
          $classResult = mysqli_query($conn, $getClassName);
          $classRow = $classResult ? $classResult->fetch_assoc() : null;

          echo $classRow ? htmlspecialchars($classRow['ClassName'] . ' ' . $classRow['Section']) : 'N/A';
          ?>
        </td>
      </tr>
      <tr>
        <td>Admission Date: </td>
        <td><?php echo htmlspecialchars($row['DateofAdmission']); ?></td>
      </tr>
      <tr>
        <th>Violation Details</th>
      </tr>
      <tr>
        <td>Date: </td>
        <td><?php echo htmlspecialchars($row['violation_date']); ?></td>
      </tr>
      <tr>
        <td>Type: </td>
        <td><?php echo htmlspecialchars($row['violation_type']); ?></td>
      </tr>
      <tr>
        <td>Description: </td>
        <td><?php echo htmlspecialchars($row['description']); ?></td>
      </tr>
      <tr>
        <td>Sanction: </td>
        <td><?php echo htmlspecialchars($row['Sanction']); ?></td>
      </tr>
      <tr>
        <td>Penalty: </td>
        <td>
          <?php
          $getPenalty = mysqli_query($conn, "SELECT penalty FROM tblviolations WHERE description = '" . mysqli_real_escape_string($conn, $row['description']) . "'");
          $penaltyRow = $getPenalty ? $getPenalty->fetch_assoc() : null;

          echo $penaltyRow ? htmlspecialchars($penaltyRow['penalty']) : 'N/A';
          $conn->close();
          ?>
        </td>
      </tr>
    </table>

    <button onclick='window.print()'>Print</button>
  </div>
</main>