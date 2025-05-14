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

// Fetch appointment stats
$total = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as cnt FROM appointments"))['cnt'];
$pending = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as cnt FROM appointments WHERE status = 1"))['cnt'];
$accepted = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as cnt FROM appointments WHERE status = 2"))['cnt'];
$completed = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as cnt FROM appointments WHERE status = 3"))['cnt'];
$otc = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as cnt FROM appointments WHERE payment = 0"))['cnt'];

// Fetch recent appointments
$recent = mysqli_query($con, "SELECT * FROM appointments ORDER BY created_at DESC LIMIT 10");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="Admin_Dashboard.css">
  <title>Reports - Admin</title>
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
          <a href="Reports.php" class="active">
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
              <h1>Reports</h1>
            </div>

            <!-- Stats Cards -->
            <div class="status-section mt-4">
              <h4><span class="blue">Appointment Statistics</span></h4>
              <div class="row g-3">
                <div class="col-md-3">
                  <div class="status-card shadow bg-light-blue">
                    <div class="status-texts">
                      <div class="status-label">Total Appointments</div>
                      <div class="status-value"><?= $total ?></div>
                    </div>
                    <div class="status-img">
                      <i class="fas fa-calendar-check fa-3x text-primary"></i>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="status-card shadow bg-light-blue">
                    <div class="status-texts">
                      <div class="status-label">Pending</div>
                      <div class="status-value"><?= $pending ?></div>
                    </div>
                    <div class="status-img">
                      <i class="fas fa-clock fa-3x text-warning"></i>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="status-card shadow bg-light-blue">
                    <div class="status-texts">
                      <div class="status-label">Accepted</div>
                      <div class="status-value"><?= $accepted ?></div>
                    </div>
                    <div class="status-img">
                      <i class="fas fa-check-circle fa-3x text-success"></i>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="status-card shadow bg-light-blue">
                    <div class="status-texts">
                      <div class="status-label">Completed</div>
                      <div class="status-value"><?= $completed ?></div>
                    </div>
                    <div class="status-img">
                      <i class="fas fa-clipboard-check fa-3x text-info"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Payment Stats -->
            <div class="status-section mt-4">
              <h4><span class="blue">Payment Statistics</span></h4>
              <div class="row g-3">
                <div class="col-md-4">
                  <div class="status-card shadow bg-light-blue">
                    <div class="status-texts">
                      <div class="status-label">Over the Counter Payments</div>
                      <div class="status-value"><?= $otc ?></div>
                    </div>
                    <div class="status-img">
                      <i class="fas fa-money-bill-wave fa-3x text-success"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Recent Appointments Table -->
            <div class="table-container mt-4">
              <div class="row">
                <div class="col-12">
                  <div class="p-3 rounded-4 shadow">
                    <div class="text-container">
                      <h4><span class="blue">Recent Appointments</span></h4>
                    </div>
                    <table class="table table-striped mt-3">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Patient</th>
                          <th>Service</th>
                          <th>Date</th>
                          <th>Time</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php while($row = mysqli_fetch_assoc($recent)): ?>
                        <tr>
                          <td><?= $row['id'] + 100 ?></td>
                          <td><?= $row['fname'] . ' ' . $row['lname'] ?></td>
                          <td>
                            <?php
                            switch($row['service']) {
                              case 0: echo 'Physical Therapy'; break;
                              case 1: echo 'Caregiving (8hr)'; break;
                              case 2: echo 'Caregiving (12hr)'; break;
                              case 3: echo 'Caregiving (24hr)'; break;
                              case 4: echo 'Nursing Home'; break;
                              default: echo 'Unknown';
                            }
                            ?>
                          </td>
                          <td><?= $row['appointment_date'] ?></td>
                          <td><?= $row['appointment_time'] ?></td>
                          <td>
                            <?php
                            switch($row['status']) {
                              case 0: echo '<span class="badge bg-secondary">Draft</span>'; break;
                              case 1: echo '<span class="badge bg-warning text-dark">Pending</span>'; break;
                              case 2: echo '<span class="badge bg-success">Accepted</span>'; break;
                              case 3: echo '<span class="badge bg-danger">Declined</span>'; break;
                              case 4: echo '<span class="badge bg-info">Completed</span>'; break;
                              default: echo '<span class="badge bg-secondary">Other</span>';
                            }
                            ?>
                          </td>
                        </tr>
                        <?php endwhile; ?>
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

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 