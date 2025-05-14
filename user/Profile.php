<?php 
require_once('../backend/function.php');

$user_data = getTableWhere('users', 'id', $_SESSION['id']);
foreach($user_data as $data){
  $fullname = $data['fname'] . ' ' . $data['lname'];
  $email = $data['email'];
  $phone = $data['phone'];
  $address = $data['address'] ?? '';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Profile.css">
    <title>Profile - HomeMedix</title>
</head>
<body>

<nav class="navbar">
        <div class="navbar-container">
            <div class="logo-container">
                <img src="img/logo.png" alt="Logo" class="logo" />
            </div>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="LandingPage.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Services.php">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="PractitionersPage.php">Practitioners</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="AboutUs.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ContactUs.php">Contact Us</a>
                </li>
                <?php if(isset($_SESSION['id'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">Hello <?= $_SESSION['fname'] ?></a>
                </li>
                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="Login.php">Login</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container py-5">
      <div class="row g-4">
        
        <div class="col-md-4">
          <div class="profile-card text-center">
            <img src="img/blank_dp.webp" alt="John Doe" class="profile-photo">
            <div class="profile-info">
              <h4><?= $fullname ?></h4>
            </div>
            <div class="profile-buttons d-flex justify-content-center gap-2 mt-3">
              <button class="btn btn-primary">Edit</button>
              <a href="../backend/ajax.php?action=logout"><button class="btn btn-outline-danger">Logout</button></a>
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
            <h1>My <span class="bordered-blue">Appointments</span>
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
          <h4>Appointment <span class="blue">Queue</span></h4>
          </h1>
        </div>
  
        <div class="p-3 mt-4 rounded-4 shadow">
          <table class="table table-striped text-center table-hover">
            <thead>
              <tr>
                <th>Appointment ID</th>
                <th>Patient Name</th>
                <th>Type of Service</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $drafts = getAppointmentsByStatus('user_id', $_SESSION['id'], 1); 
                  if($drafts->num_rows > 0):
                    foreach($drafts as $draft):
                      $fullname = $draft['fname'] . ($draft['mname'] ? ' ' . $draft['mname'] : '') . ' ' . $draft['lname'];
              ?>
              <tr>
                <td><?= $draft['id'] + 100 ?></td>
                <td><?= $fullname ?? '' ?></td>
                <td><?= getService($draft['service']) ?></td>
                <td><?= $draft['appointment_date'] ?></td>
                <td><?= $draft['appointment_time'] ?></td> 
                <td class="d-flex justify-content-center">
                  <span class="bordered-yellow">Pending</span>
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

    <!-- Accepted Appointments Section -->
    <div class="container mt-4">
      <div class="table-container">
  
        <div class="text-container">
          <h4>Accepted <span class="blue">Appointments</span></h4>
          </h1>
        </div>
  
        <div class="p-3 mt-4 rounded-4 shadow">
          <table class="table table-striped text-center table-hover">
            <thead>
              <tr>
                <th>Appointment ID</th>
                <th>Patient Name</th>
                <th>Type of Service</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $accepted = getAppointmentsByStatus('user_id', $_SESSION['id'], 2); 
                  if($accepted->num_rows > 0):
                    foreach($accepted as $appointment):
                      $fullname = $appointment['fname'] . ($appointment['mname'] ? ' ' . $appointment['mname'] : '') . ' ' . $appointment['lname'];
              ?>
              <tr>
                <td><?= $appointment['id'] + 100 ?></td>
                <td><?= $fullname ?? '' ?></td>
                <td><?= getService($appointment['service']) ?></td>
                <td><?= $appointment['appointment_date'] ?></td>
                <td><?= $appointment['appointment_time'] ?></td> 
                <td class="d-flex justify-content-center">
                  <span class="bordered-green">Accepted</span>
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

    <!-- Declined Appointments Section -->
    <div class="container mt-4">
      <div class="table-container">
  
        <div class="text-container">
          <h4>Declined <span class="blue">Appointments</span></h4>
          </h1>
        </div>
  
        <div class="p-3 mt-4 rounded-4 shadow">
          <table class="table table-striped text-center table-hover">
            <thead>
              <tr>
                <th>Appointment ID</th>
                <th>Patient Name</th>
                <th>Type of Service</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $declined = getAppointmentsByStatus('user_id', $_SESSION['id'], 3); 
                  if($declined->num_rows > 0):
                    foreach($declined as $appointment):
                      $fullname = $appointment['fname'] . ($appointment['mname'] ? ' ' . $appointment['mname'] : '') . ' ' . $appointment['lname'];
              ?>
              <tr>
                <td><?= $appointment['id'] + 100 ?></td>
                <td><?= $fullname ?? '' ?></td>
                <td><?= getService($appointment['service']) ?></td>
                <td><?= $appointment['appointment_date'] ?></td>
                <td><?= $appointment['appointment_time'] ?></td> 
                <td class="d-flex justify-content-center">
                  <span class="bordered-red">Declined</span>
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

    <!-- Completed Appointments Section -->
    <div class="container mt-4">
      <div class="table-container">
  
        <div class="text-container">
          <h4>Completed <span class="blue">Appointments</span></h4>
          </h1>
        </div>
  
        <div class="p-3 mt-4 rounded-4 shadow">
          <table class="table table-striped text-center table-hover">
            <thead>
              <tr>
                <th>Appointment ID</th>
                <th>Patient Name</th>
                <th>Type of Service</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $completed = getAppointmentsByStatus('user_id', $_SESSION['id'], 4); 
                  if($completed->num_rows > 0):
                    foreach($completed as $appointment):
                      $fullname = $appointment['fname'] . ($appointment['mname'] ? ' ' . $appointment['mname'] : '') . ' ' . $appointment['lname'];
              ?>
              <tr>
                <td><?= $appointment['id'] + 100 ?></td>
                <td><?= $fullname ?? '' ?></td>
                <td><?= getService($appointment['service']) ?></td>
                <td><?= $appointment['appointment_date'] ?></td>
                <td><?= $appointment['appointment_time'] ?></td> 
                <td class="d-flex justify-content-center">
                  <span class="bordered-blue">Completed</span>
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

    <div class="container">
      <div class="table-container">
  
        <div class="text-container">
          <h4>Appointment <span class="blue">Draft</span></h4>
          </h1>
        </div>
  
        <div class="p-3 mt-4 rounded-4 shadow">
          <table class="table table-striped text-center table-hover">
            <thead>
              <tr>
                <th>Appointment ID</th>
                <th>Patient Name</th>
                <th>Type of Service</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                  $drafts = getAppointmentsByStatus('user_id', $_SESSION['id'], 0); 
                    if($drafts->num_rows > 0):
                      foreach($drafts as $draft):
                        $fullname = $draft['fname'] . ($draft['mname'] ? ' ' . $draft['mname'] : '') . ' ' . $draft['lname'];
                ?>
                <tr>
                  <td><?= $draft['id'] + 100 ?></td>
                  <td><?= $fullname ?? '' ?></td>
                  <td><?= getService($draft['service']) ?></td>
                  <td><?= $draft['appointment_date'] ?></td>
                  <td><?= $draft['appointment_time'] ?></td> 
                  <td class="d-flex justify-content-center">
                    <a href="./appointment.php?id=<?= $draft['id'] ?>"><button type="button" class="btn btn-primary d-flex">
                      <span class="material-symbols-outlined">edit</span> Edit
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
                  $drafts = getAppointmentHistory(); 
                    if($drafts->num_rows > 0):
                      foreach($drafts as $draft):
                        $fullname = $draft['fname'] . ($draft['mname'] ? ' ' . $draft['mname'] : '') . ' ' . $draft['lname'];
                ?>
                <tr>
                  <td><?= $draft['id'] + 100 ?></td>
                  <td><?= $fullname ?? '' ?></td>
                  <td><?= getService($draft['service']) ?></td>
                  <td><?= $draft['appointment_date'] ?></td>
                  <td><?= $draft['appointment_time'] ?></td> 
                  <td class="d-flex justify-content-center">
                    <a href="./appointment.php?id=<?= $draft['id'] ?>"><button type="button" class="btn btn-primary d-flex">
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

        <!--footer-->
        <footer class="bg-light text-center text-lg-start mt-5">
          <div class="container p-4">
            <!-- Row -->
            <div class="row">
              <!-- Column 1 -->
              <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
                <h5 class="text-uppercase">About HomeMedix</h5>
                <p class="text-justify">
                  HomeMedix is dedicated to providing quality in-home healthcare services, including physical therapy, caregiving, and nursing. We prioritize compassionate, personalized care to help individuals lead healthier lives.
                </p>
              </div>
              <!-- Column 2 -->
              <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
                <h5 class="text-uppercase">Quick Links</h5>
                <ul class="list-unstyled">
                  <li><a href="../LandingPage.php" class="text-dark">Home</a></li>
                  <li><a href="../Services.php" class="text-dark">Services</a></li>
                  <li><a href="../PractitionersPage.php" class="text-dark">Practitioners</a></li>
                  <li><a href="AboutUs.php" class="text-dark">About Us</a></li>
                  <li><a href="../ContactUs.php" class="text-dark">Contact Us</a></li>
                </ul>
              </div>
              <!-- Column 3 -->
              <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
                <h5 class="text-uppercase">Contact Information</h5>
                <ul class="list-unstyled">
                  <li><i class="fas fa-map-marker-alt"></i> <strong>124 A. Flores St, Marikina, 1804 Metro Manila</strong></li>
                  <li><i class="fas fa-map-marker-alt"></i> <strong>28 6th St, Marikina, 1807 Metro Manila</strong></li>
                  <li><i class="fas fa-map-marker-alt"></i><strong>24 Sampaguita St, Marikina, 1805 Metro Manila</strong></li>
                  <li><i class="fas fa-phone"></i> 0917 102 8250</li>
                  <li><i class="fas fa-envelope"></i> HomeMedix.ptcaregiving@gmail.com</li>
                </ul>
              </div>
            </div>
  
            <!-- Row End -->
          </div>
        
          <!-- Copyright -->
          <div class="text-center p-3" style="background-color: #f1f1f1;">
            © 2024 HomeMedix. All rights reserved.
          </div>
        </footer>
</body>
</html>