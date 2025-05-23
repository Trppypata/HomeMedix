<?php
require_once('../backend/function.php');
require_once('../backend/config.php');
if (!isset($_SESSION['role']) && $_SESSION['role'] != 0) {
  header("location: ../index.php");
  exit;
}
// Fetch unread notifications
$notif_sql = "SELECT * FROM admin_notifications WHERE is_read = 0 ORDER BY created_at DESC LIMIT 10";
$notif_result = $con->query($notif_sql);
$notif_count = $notif_result ? $notif_result->num_rows : 0;

// Fetch stats for dashboard
$total_patients = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as cnt FROM users WHERE role = 1"))['cnt'];
$active_therapists = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as cnt FROM users WHERE role = 2 AND status = 1"))['cnt'];
$active_caregivers = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as cnt FROM users WHERE role = 3 AND status = 1"))['cnt'];
$treated_patients = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as cnt FROM appointments WHERE status = 4"))['cnt']; // assuming status 4 is completed
$in_queue = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as cnt FROM appointments WHERE status = 1"))['cnt']; // pending appointments
$earnings = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as cnt FROM appointments WHERE status IN (2,4)"))['cnt'] * 1500; // rough estimation
?>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="Admin_Dashboard.css">
  <title>Dashboard - Admin</title>
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar">
      <div class="logo-container">
        <img src="img/logo.png" alt="Logo" class="logo">
      </div>
      <ul>
        <li>
          <a href="Admin_Dashboard.php">
            <i class="fas fa-home"></i>Dashboard </a>
        </li>
        <li>
          <a href="Admin_PatientRecord.php">
            <i class="fas fa-bed"></i>Our Patients </a>
        </li>
        <li>
          <a href="Admin_UserRecord.php?role=2">
            <i class="fas fa-user-doctor"></i>Therapists </a>
        </li>
        <li>
          <a href="Admin_UserRecord.php?role=3">
            <i class="fas fa-user-nurse"></i>Caregivers </a>
        </li>
        <li>
          <a href="Admin_UserRecord.php?role=1">
            <i class="fas fa-user"></i>User Accounts </a>
        </li>
        <li>
          <a href="Admin_UserRecord.php?role=0">
            <i class="fas fa-user-tie"></i>Admin </a>
        </li>
        <li>
          <a href="Admin_AppointmentRecord.php">
            <i class="fas fa-calendar"></i>Appointments </a>
        </li>
        <li>
          <a href="Reports.php">
            <i class="fas fa-chart-bar"></i>Reports </a>
        </li>
        <li>
          <a href="Admin_Inbox.php">
            <i class="fas fa-envelope"></i>Inbox - Contact Us </a>
        </li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="main_content">
      <div class="header d-flex justify-content-end align-items-center">

        <button class="btn btn-light notification-btn">
          <span class="material-symbols-outlined">notifications</span>
          <span class="notification-badge"><?= $notif_count ?></span>
        </button>

        <h6 class="mx-2">Admin <span class="bordered-blue"><?= $_SESSION['fname'] . ' ' . $_SESSION['lname'] ?></span></h6>
        
        <a href="../backend/ajax.php?action=logout" class="btn btn-outline-danger btn-sm ms-3">
          <i class="fas fa-sign-out-alt"></i> Log Out
        </a>
      </div>

      <div class="info">
        <div class="container-fluid">
          <div class="container">

            <div class="text-container">
              <h1>Dashboard</h1>
            </div>

            <div class="banner-container">
              <img src="img/admin_dashboard_banner.jpg" alt="Banner">
            </div>

            <div class="button-group d-flex justify-content-between text-center mt-5">
              <div class="button">
                <a href="Admin_UserRecord.php?role=2&action=add" class="text-decoration-none">
                  <button class="custom-button therapist">
                    <img src="img/Add_Therapist.png" alt="Therapist Icon">
                    Add Therapist
                  </button>
                </a>
              </div>

              <div class="button">
                <a href="Admin_UserRecord.php?role=3&action=add" class="text-decoration-none">
                  <button class="custom-button caregiver">
                    <img src="img/Add_Caregiver.png" alt="Caregiver Icon">
                    Add Caregiver
                  </button>
                </a>
              </div>

              <div class="button">
                <a href="Admin_PatientRecord.php?action=add" class="text-decoration-none">
                  <button class="custom-button patient">
                    <img src="img/Add_Patient.png" alt="Patient Icon">
                    Add Patient
                  </button>
                </a>
              </div>

              <div class="button">
                <a href="Appointment.php" class="text-decoration-none">
                  <button class="custom-button appointment">
                    <img src="img/Add_Appointment.png" alt="Appointment Icon">
                    Add Appointment
                  </button>
                </a>
              </div>

              <div class="button">
                <a href="Admin_UserRecord.php?role=0&action=add" class="text-decoration-none">
                  <button class="custom-button admin">
                    <img src="img/Add_Admin.png" alt="Admin Icon">
                    Add Admin
                  </button>
                </a>
              </div>

              <div class="button">
                <a href="Reports.php" class="text-decoration-none">
                  <button class="custom-button reports">
                    <div style="width:100px;height:100px;display:flex;justify-content:center;align-items:center;margin-bottom:10px;">
                      <i class="fas fa-chart-bar fa-4x"></i>
                    </div>
                    View Reports
                  </button>
                </a>
              </div>
            </div>

            <div class="status-section mt-5">
              <h4><span class="blue">Analytical Status</span></h4>

              <div class="row g-3">
                <div class="col-md-4">
                  <div class="status-card shadow bg-light-blue">
                    <div class="status-texts">
                      <div class="status-label">Total Patients</div>
                      <div class="status-value"><?= $total_patients ?></div>
                    </div>
                    <div class="status-img">
                      <img src="img/Total_Patients.png" alt="...">
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="status-card shadow bg-light-blue">
                    <div class="status-texts">
                      <div class="status-label">Active Therapists</div>
                      <div class="status-value"><?= $active_therapists ?></div>
                    </div>
                    <div class="status-img">
                      <img src="img/Active_Therapists.png" alt="...">
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="status-card shadow bg-light-blue">
                    <div class="status-texts">
                      <div class="status-label">Active Caregivers</div>
                      <div class="status-value"><?= $active_caregivers ?></div>
                    </div>
                    <div class="status-img">
                      <img src="img/Active_Caregivers.png" alt="...">
                    </div>
                  </div>
                </div>
              </div>

              <div class="row g-3 ">
                <div class="col-md-4">
                  <div class="status-card shadow bg-light-blue">
                    <div class="status-texts">
                      <div class="status-label">Treated Patients</div>
                      <div class="status-value"><?= $treated_patients ?></div>
                    </div>
                    <div class="status-img">
                      <img src="img/Treated_Patients.png" alt="...">
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="status-card shadow bg-light-blue">
                    <div class="status-texts">
                      <div class="status-label">In Queue</div>
                      <div class="status-value"><?= $in_queue ?></div>
                    </div>
                    <div class="status-img">
                      <img src="img/In_queue.png" alt="...">
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="status-card shadow bg-light-blue">
                    <div class="status-texts">
                      <div class="status-label">Earnings</div>
                      <div class="status-value">₱<?= number_format($earnings) ?></div>
                    </div>
                    <div class="status-img">
                      <img src="img/Peso.png" alt="...">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="table-container">
              <div class="row mt-4">
                <!-- Therapists Section -->
                <div class="col-6">
                  <div class="p-3 rounded-4 shadow">
                    <div class="text-container white-text">
                      <h4><strong>Therapists</strong></h4>
                      <p>This is the current list of active Therapists</p>
                    </div>
                    <table class="table table-striped text-center table-hover">
                      <thead>
                        <tr>
                          <th>Therapist ID</th>
                          <th>Therapist Name</th>
                          <th>Email Address</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $therapists = mysqli_query($con, "SELECT * FROM users WHERE role = 2 AND status = 1 ORDER BY id DESC LIMIT 3");
                        if(mysqli_num_rows($therapists) > 0):
                          while($row = mysqli_fetch_assoc($therapists)):
                        ?>
                        <tr>
                          <td><?= $row['id'] ?></td>
                          <td><?= $row['fname'] . ' ' . $row['lname'] ?></td>
                          <td><?= $row['email'] ?></td>
                        </tr>
                        <?php 
                          endwhile;
                        else:
                        ?>
                        <tr>
                          <td colspan="3">No active therapists found</td>
                        </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                </div>

                <!-- Caregivers Section -->
                <div class="col-6">

                  <div class="p-3 rounded-4 shadow">
                    <div class="text-container white-text">
                      <h4><strong>Caregivers</strong></h4>
                      <p>This is the current list of active Caregivers</p>
                    </div>
                    <table class="table table-striped text-center table-hover">
                      <thead>
                        <tr>
                          <th>Caregiver ID</th>
                          <th>Caregiver Name</th>
                          <th>Email Address</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $caregivers = mysqli_query($con, "SELECT * FROM users WHERE role = 3 AND status = 1 ORDER BY id DESC LIMIT 3");
                        if(mysqli_num_rows($caregivers) > 0):
                          while($row = mysqli_fetch_assoc($caregivers)):
                        ?>
                        <tr>
                          <td><?= $row['id'] ?></td>
                          <td><?= $row['fname'] . ' ' . $row['lname'] ?></td>
                          <td><?= $row['email'] ?></td>
                        </tr>
                        <?php 
                          endwhile;
                        else:
                        ?>
                        <tr>
                          <td colspan="3">No active caregivers found</td>
                        </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="notification-dropdown" style="position:absolute;right:60px;top:60px;z-index:1000;background:#fff;border:1px solid #ccc;border-radius:8px;min-width:300px;display:none;">
      <?php if ($notif_count == 0): ?>
        <div class="notification-item p-3">No new notifications.</div>
      <?php else: ?>
        <?php while ($notif = $notif_result->fetch_assoc()): ?>
          <div class="notification-item p-3 border-bottom">
            <strong><?= htmlspecialchars($notif['type']) ?>:</strong>
            <?= htmlspecialchars($notif['message']) ?><br>
            <small><?= $notif['created_at'] ?></small>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>
    </div>
    <script>
      // Toggle notification dropdown
      const notifBtn = document.querySelector('.notification-btn');
      const notifDropdown = document.querySelector('.notification-dropdown');
      notifBtn.addEventListener('click', function(e) {
        notifDropdown.style.display = notifDropdown.style.display === 'block' ? 'none' : 'block';
        e.stopPropagation();
      });
      document.addEventListener('click', function() {
        notifDropdown.style.display = 'none';
      });
    </script>
</body>

</html>