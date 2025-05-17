<?php
require_once('../backend/function.php');

if(!isset($_SESSION['role']) || ($_SESSION['role'] != 2 && $_SESSION['role'] != 3)){
  header("location: ../index.php");
  exit;
}

$user_data = getTableWhere('users', 'id', $_SESSION['id']);
foreach($user_data as $data){
  $fullname = $data['fname'] . ' ' . $data['lname'];
  $email = $data['email'];
  $phone = $data['phone'];
  $address = $data['address'] ?? '';
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
    <link rel="stylesheet" href="Practitoner_Profile.css">
    <title>Profile - Practitioners</title>
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

            <div class="container py-5">
                <div class="row g-4">
                  
                  <div class="col-md-4">
                    <div class="profile-card text-center">
                      <img src="img/Active_Caregivers.png" alt="John Doe" class="profile-photo">
                      <div class="profile-info">
                      <h4><?= $fullname ?></h4>
                      </div>
                      <div class="profile-buttons d-flex justify-content-center gap-2 mt-3">
                        <button class="btn btn-primary">Edit</button>
                        <button class="btn btn-outline-danger">Logout</button>
                      </div>
                    </div>
                  </div>
            
                  <div class="col-md-8">
                    <div class="details-card">
                      <table>
                      <tbody>
                <tr>
                  <td><strong>Full Name</strong></td>
                  <td><?= $fullname ?></td>
                </tr>
                <tr>
                  <td><strong>Email</strong></td>
                  <td><?= $email ?></td>
                </tr>
                <tr>
                  <td><strong>Phone</strong></td>
                  <td><?= $phone ?></td>
                </tr>
                <tr>
                  <td><strong>Address</strong></td>
                  <td><?= $address ?></td>
                </tr>
              </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <div class="container">
                <div class="row align-items-center">
                  <div class="col-md-8">
                    <div class="text-container">
                      <h1>Patient <span class="bordered-blue">Appointments</span>
                      </h1>
                    </div>
                  </div>
                  <div class="col-md-4 text-md-end">
                    <div class="button-container  d-flex justify-content-end">
                      <a href="Appointment.php">
                        <button type="button" class="btn btn-info d-flex align-items-center">
                          <img src="img/Add.png" alt="Icon">
                          <h5 class="white-text">Add Appointment</h5>
                        </button>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            
              <div class="container">
                <div class="table-container">
            
                  <div class="text-container">
                    <h4>Current <span class="blue">Appointments</span></h4>
                    </h1>
                  </div>
            
                  <div class="p-3 mt-4 rounded-4 shadow">
                    <table class="table table-striped text-center table-hover">
                        <thead>
                          <tr>
                            <th> </th>
                            <th>Appointment ID</th>
                            <th>Patient Name</th>
                            <th>Type of Service</th>
                            <th>Appointment Date</th>
                            <th>Appointment Time</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php 
                          $currents = getCurrentAppointments(); 
                            if($currents->num_rows > 0):
                              foreach($currents as $current):
                                $fullname = $current['fname'] . ($current['mname'] ? ' ' . $current['mname'] : '') . ' ' . $current['lname'];
                          ?>
                            <tr>
                              <td> 
                                <div class="form-check d-flex justify-content-center align-items-center">
                                  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                  <label class="form-check-label" for="flexCheckDefault1"></label>
                                </div>
                              </td>  
                              <td><?= $current['id'] + 100 ?></td>
                              <td><?= $fullname ?? '' ?></td>
                              <td><?= getService($current['service']) ?></td>
                              <td><?= $current['appointment_date'] ?></td>
                              <td><?= $current['appointment_time'] ?></td>
                              <tdappointment</td> 
                            </tr>
                            <?php 
                                endforeach; 
                              else:
                            ?>
                            <tr>
                              <td colspan="6">No available data.</td>
                            </tr>
                          <?php 
                            endif;
                          ?>
                        </tbody>
                      </table>
                  </div>
                </div>
              </div>
          
              <div class="container">
                <div class="table-container">
            
                  <div class="text-container mt-4">
                    <h4>Appointment <span class="blue">Queue</span></h4>
                    </h1>
                  </div>
            
                  <div class="p-3 mt-4 rounded-4 shadow">
                    <table class="table table-striped text-center table-hover">
                      <thead>
                        <tr>
                          <th>Patient ID</th>
                          <th>Patient Name</th>
                          <th>Type of Service</th>
                          <th>Appointment Date</th>
                          <th>Appointment Time</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $pendings = getTableWhere('appointments', 'status', 1); 
                          if($pendings->num_rows > 0):
                            foreach($pendings as $pending):
                              $fullname = $pending['fname'] . ($pending['mname'] ? ' ' . $pending['mname'] : '') . ' ' . $pending['lname'];
                        ?>
                        <tr>
                          <td><?= $pending['id'] + 100 ?></td>
                          <td><?= $fullname ?? '' ?></td>
                          <td><?= getService($pending['service']) ?></td>
                          <td><?= $pending['appointment_date'] ?></td>
                          <td><?= $pending['appointment_time'] ?></td> 
                          <td class="d-flex justify-content-center">
                            <button type="button" class="btn btn-success me-1 status-btn" data-id="<?= $pending['id'] ?>" data-status="2">Accept</button>
                            <button type="button" class="btn btn-danger status-btn" data-id="<?= $pending['id'] ?>" data-status="3">Decline</button>
                          </td>
                        </tr>
                          <?php 
                              endforeach; 
                            else:
                          ?>
                          <tr>
                            <td colspan="6">No available data.</td>
                          </tr>
                        <?php 
                          endif;
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
          
              <div class="container mt-4">
                <div class="table-container">
            
                  <div class="text-container">
                    <h4>Appointment <span class="blue">History</span></h4>
                    </h1>
                  </div>
            
                  <div class="p-3 mt-4 rounded-4 shadow">
                    <table class="table table-striped text-center table-hover">
                      <tbody>
                      <?php 
                        $pasts = getPastAppointments(); 
                          if($pasts->num_rows > 0):
                            foreach($pasts as $past):
                              $fullname = $past['fname'] . ($past['mname'] ? ' ' . $past['mname'] : '') . ' ' . $past['lname'];
                        ?>
                        <tr>
                          <td><?= $past['id'] + 100 ?></td>
                          <td><?= $fullname ?? '' ?></td>
                          <td><?= getService($past['service']) ?></td>
                          <td><?= $past['appointment_date'] ?></td>
                          <td><?= $past['appointment_time'] ?></td> 
                          <td class="d-flex justify-content-center">
                            <a href="./appointment.php?id=<?= $past['id'] ?>"><button type="button" class="btn btn-primary d-flex">
                              <span class="material-symbols-outlined">history</span> View Details
                            </button></a>
                          </td>
                        </tr>
                        <?php 
                            endforeach; 
                          else:
                        ?>
                        <tr>
                          <td colspan="6">No available data.</td>
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
  </body>
</html>