<?php
require_once('../backend/function.php');
if(!isset($_SESSION['role']) && $_SESSION['role'] != 0){
  header("location: ../login.php");
  exit;
}
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
            <a href="Admin_Inbox.php">
              <i class="fas fa-envelope"></i>Inbox - Contact Us </a>
          </li>
        </ul>
        <div class="logout-container">
          <a href="../backend/ajax.php?action=logout" class="ms-3 p-0 w-100"><button class="btn btn-outline-danger btn-logout">Log Out</button></a>
        </div>
      </div>

      <!-- Main Content -->
      <div class="main_content">
        <div class="header d-flex justify-content-end align-items-center">

            <button class="btn btn-light notification-btn">
                <span class="material-symbols-outlined">notifications</span>
                <span class="notification-badge">3</span>
            </button>

          <h6>Admin <span class="bordered-blue"><?= $_SESSION['fname'] . ' ' . $_SESSION['lname'] ?></span>
          </h6>
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
  </body>
</html>