<?php
require_once('../backend/function.php');
require_once('../backend/config.php');
if(!isset($_SESSION['role']) && $_SESSION['role'] != 0){
  header("location: ../login.php");
  exit;
}

// Fetch unread notifications
$notif_sql = "SELECT * FROM admin_notifications WHERE is_read = 0 ORDER BY created_at DESC LIMIT 10";
$notif_result = $con->query($notif_sql);
$notif_count = $notif_result ? $notif_result->num_rows : 0;
?>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Admin_Records.css">
    <title>Appointment Records - Admin</title>
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
              <div class="banner-container">
                <img src="img/Admin_Appointments.png" alt="Banner">
              </div>
              <div class="container mt-4">
                <div class="row align-items-center">
                  <div class="col-md-8">
                    <div class="text-container">
                      <h1>HomeMedix <span class="bordered-blue">Appointments</span>
                      </h1>
                    </div>
                  </div>
                  <div class="col-md-4 text-md-end">
                    <div class="button-container  d-flex justify-content-end">
                      <button type="button" class="btn btn-info d-flex align-items-center">
                        <img src="img/Add.png" alt="Icon">
                        <h5 class="white-text">Add Appointment</h5>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="table-container">
                <div class="p-3 rounded-4 shadow">
                  <table class="table table-striped text-center table-hover">
                    <thead>
                      <tr>
                        <th>Appointment ID</th>
                        <th>Patient Name</th>
                        <th>Practitioner Name</th>
                        <th>Case</th>
                        <th>Type of Service</th>
                        <th>Appointment Date</th>
                        <th>Appointment Time</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>201</td>
                        <td>Lee Chaeryeong</td>
                        <td>Im Nayeon</td>
                        <td>Stroke</td>
                        <td>Physical Therapy</td>
                        <td>Dec. 4, 2024</td>
                        <td>09:00AM</td> 
                        <td>
                            <button type="button" class="btn btn-primary">
                                <span class="material-symbols-outlined">edit</span>
                            </button>

                            <button type="button" class="btn btn-danger">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </td>
                      </tr>

                      <tr>
                        <td>201</td>
                        <td>Lee Chaeryeong</td>
                        <td>Im Nayeon</td>
                        <td>Old Age</td>
                        <td>Caregiving (8-hour Shift)</td>
                        <td>Dec. 4, 2024</td>
                        <td>09:00AM</td> 
                        <td>
                            <button type="button" class="btn btn-primary">
                                <span class="material-symbols-outlined">edit</span>
                            </button>

                            <button type="button" class="btn btn-danger">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </td>
                      </tr>
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
  </body>
</html>