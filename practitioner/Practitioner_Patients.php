<?php
require_once('../backend/function.php');
if(!isset($_SESSION['role']) || ($_SESSION['role'] != 2 && $_SESSION['role'] != 3)){
  header("location: ../index.php");
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
    <link rel="stylesheet" href="Practitioner_Records.css">
    <title>My Patients - Practitioner</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <a href="Practitioner_Dashboard.php">
              <i class="fas fa-home"></i>Dashboard </a>
          </li>
          <li>
            <a href="Practitioner_Calendar.php">
              <i class="fas fa-calendar"></i>Calendar</a>
          </li>
          <li>
            <a href="Practitioner_Appointments.php">
              <i class="fas fa-notes-medical"></i>Appointments</a>
          </li>
          <li>
            <a href="Practitioner_Patients.php">
              <i class="fas fa-users"></i>My Patients</a>
          </li>
          <li>
            <a href="Practitioner_Profile.php">
              <i class="fas fa-user"></i>Profile</a>
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

          <h6>Dr. <span class="bordered-blue"><?= $_SESSION['fname'] . ' ' . $_SESSION['lname'] ?></span>
          </h6>
        </div>
        <div class="info">
          <div class="container-fluid">
            <div class="container">
              <div class="banner-container">
                <img src="img/Practitioner_Patient.jpg" alt="Banner">
              </div>
              <div class="container mt-4">
                <div class="row align-items-center">
                  <div class="col-md-8">
                    <div class="text-container">
                      <h1>My <span class="bordered-blue">Patients</span>
                      </h1>
                    </div>
                  </div>
                  <!-- <div class="col-md-4 text-md-end">
                    <div class="button-container  d-flex justify-content-end">
                      <button type="button" class="btn btn-info d-flex align-items-center">
                        <img src="img/Add.png" alt="Icon">
                        <h4 class="white-text">Add Patient</h4>
                      </button>
                    </div>
                  </div> -->
                </div>
              </div>
              
              <div class="table-container">
                <div class="p-3 rounded-4 shadow">
                    <table class="table table-striped text-center table-hover">
                      <thead>
                        <tr>
                          <th>Patient ID</th>
                          <th>Patient Name</th>
                          <th>Birthdate</th>
                          <th>Age</th>
                          <th>Home Address</th>
                          <th>Case</th>
                          <th>Contact Person</th>
                          <th>Contact Number</th>
                          <th>Email Address</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $patients = getTableWhere('appointments', 'status', 2); 
                          if($patients->num_rows > 0):
                            foreach($patients as $patient):
                              $fullname = $patient['fname'] . ($patient['mname'] ? ' ' . $patient['mname'] : '') . ' ' . $patient['lname'];
                        ?>
                        <tr>
                          <td><?= $patient['id'] + 100 ?></td>
                          <td><?= $fullname ?></td>
                          <td><?= $patient['bday'] ?></td>
                          <td><?= (new DateTime($patient['bday']))->diff(new DateTime())->y ?></td>
                          <td><?= $patient['address'] . ' ' . $patient['barangay'] . ' ' . $patient['city'] . ' ' . $patient['zip']?></td>
                          <td><?= $patient['appointment_case'] ?></td>
                          <td><?= $patient['cperson'] ?? 'N/A' ?></td>
                          <td><?= $patient['phone'] ?></td>
                          <td><?= $patient['email'] ?></td>
                        </tr>
                        <?php 
                            endforeach; 
                          else:
                        ?>
                        <tr>
                          <td colspan="9">No available data.</td>
                        </tr>
                      <?php 
                        endif;
                      ?>
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
    </div>
  </body>
</html>