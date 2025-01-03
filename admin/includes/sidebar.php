<style>
  .hidethis {
    display: none;
  }

  @media (max-width: 768px) {
    .hidethis {
      display: block;
    }
  }
</style>

<nav class="sidebar sidebar-offcanvas" id="sidebar" style="background-color: #2f3d58;">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="#" class="nav-link">
        <div class="profile-image">
          <img class="img-xs rounded-circle" src="images/faces/face8.jpg" alt="profile image">
          <div class="dot-indicator bg-success"></div>
        </div>
        <div class="text-wrapper">
          <?php
          $aid = $_SESSION['sturecmsaid'];
          $sql = "SELECT * from tbladmin where ID=:aid";

          $query = $dbh->prepare($sql);
          $query->bindParam(':aid', $aid, PDO::PARAM_STR);
          $query->execute();
          $results = $query->fetchAll(PDO::FETCH_OBJ);

          $cnt = 1;
          if ($query->rowCount() > 0) {
            foreach ($results as $row) { ?>
              <p class="profile-name"><?php echo htmlentities($row->AdminName); ?></p>
              <p class="designation"><?php echo htmlentities($row->Email); ?></p><?php $cnt = $cnt + 1;
            }
          } ?>
        </div>

      </a>
    </li>
    <li class="nav-item nav-category">
      <span class="nav-link">Dashboard</span>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="dashboard.php">
        <span class="menu-title">Dashboard</span>
        <i class="icon-screen-desktop menu-icon"></i>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
        <span class="menu-title">Class</span>
        <i class="icon-layers menu-icon"></i>
      </a>
      <div class="collapse" id="ui-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="add-class.php">Add Class</a></li>
          <li class="nav-item"> <a class="nav-link" href="manage-class.php">Manage Class</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic1" aria-expanded="false" aria-controls="ui-basic1">
        <span class="menu-title">Students</span>
        <i class="icon-people menu-icon"></i>
      </a>
      <div class="collapse" id="ui-basic1">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="add-students.php">Add Students</a></li>
          <li class="nav-item"> <a class="nav-link" href="manage-students.php">Manage Students</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#violations" aria-expanded="false" aria-controls="violations">
        <span class="menu-title">Violations</span>
        <i class="icon-lock menu-icon"></i> <!-- Update icon if necessary -->
      </a>
      <div class="collapse" id="violations">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="add-violations.php">Add Violations</a></li>
          <li class="nav-item"> <a class="nav-link" href="manage-violations.php">Manage Violations</a></li>

        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#offense" aria-expanded="false" aria-controls="offense">
        <span class="menu-title">Offense</span>
        <i class="icon-close menu-icon"></i> <!-- Update icon if necessary -->
      </a>
      <div class="collapse" id="offense">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="add-offense.php">Add Offense</a></li>
          <li class="nav-item"> <a class="nav-link" href="manage-offense.php">Manage Offense</a></li>

        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
        <span class="menu-title">Announcement </span>
        <i class="icon-doc menu-icon"></i>
      </a>
      <div class="collapse" id="auth">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="add-notice.php"> Add Class Announcement </a></li>
          <li class="nav-item"> <a class="nav-link" href="add-public-notice.php"> Public Announcement </a></li>
          <!-- <li class="nav-item"> <a class="nav-link" href="manage-Announcement.php"> MAnnouncement </a></li> -->
          <li class="nav-item"> <a class="nav-link" href="manage-public-notice.php"> Manage Public Announcement
            </a></li>
        </ul>
      </div>
    </li>
    <!-- <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#auth1" aria-expanded="false" aria-controls="auth">
        <span class="menu-title">Public Announcementcement</span>
        <i class="icon-doc menu-icon"></i>
      </a>
      <div class="collapse" id="auth1">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="add-public-Announcement.php"> Add PAnnouncement </a></li>
          <li class="nav-item"> <a class="nav-link" href="manage-public-Announcement.php"> Manage PAnnouncement </a></li>
        </ul>
      </div> -->
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#auth2" aria-expanded="false" aria-controls="auth">
        <span class="menu-title">Pages</span>
        <i class="icon-doc menu-icon"></i>
      </a>
      <div class="collapse" id="auth2">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="about-us.php"> About Us </a></li>
          <li class="nav-item"> <a class="nav-link" href="contact-us.php"> Contact Us </a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="between-dates-reports.php">
        <span class="menu-title">Reports</span>
        <i class="icon-notebook menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="violation-report.php">
        <span class="menu-title">Violation Reports</span>
        <i class="icon-notebook menu-icon"></i>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="handbook2.php">
        <span class="menu-title">Student Handbook</span>
        <i class="icon-docs menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="monitor.php">
        <span class="menu-title">Monitor Handbook</span>
        <i class="icon-docs menu-icon"></i>
      </a>
    </li>
    <li class="nav-item hidethis">
      <a class="nav-link" href="profile.php">
        <span class="menu-title">Admin Profile</span>
        <i class="icon-user menu-icon"></i>
      </a>

    </li>
    <li class="nav-item hidethis">
      <a class="nav-link" href="change-password.php">
        <span class="menu-title">Setting</span>
        <i class="icon-energy menu-icon"></i>
      </a>
    </li>
    <li class="nav-item hidethis">
      <a class="nav-link" href="../user/logout.php">
        <span class="menu-title">Logout</span>
        <i class="icon-power menu-icon"></i>
      </a>
    </li>
  </ul>
</nav>