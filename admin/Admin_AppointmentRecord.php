<?php
require_once('../backend/function.php');
if (!isset($_SESSION['role']) && $_SESSION['role'] != 0) {
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
                    <a href="./Appointment.php" class="btn"><button type="button" class="btn btn-info d-flex align-items-center">
                        <img src="img/Add.png" alt="Icon">
                        <h5 class="white-text">Add Appointment</h5>
                      </button></a>
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
                      <th>Case</th>
                      <th>Type of Service</th>
                      <th>Appointment Date</th>
                      <th>Appointment Time</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $appointments = getTable('appointments');
                    if ($appointments->num_rows > 0):
                      foreach ($appointments as $appointment):
                        $fullname = $appointment['fname'] . ($appointment['mname'] ? ' ' . $appointment['mname'] : '') . ' ' . $appointment['lname'];
                    ?>
                        <tr>
                          <td><?= $appointment['id'] + 100 ?></td>
                          <td><?= $fullname ?? '' ?></td>
                          <td><?= $appointment['appointment_case'] ?></td>
                          <td><?= getService($appointment['service']) ?></td>
                          <td><?= $appointment['appointment_date'] ?></td>
                          <td><?= $appointment['appointment_time'] ?></td>
                          <td>
                            <a href="appointment.php?id=<?= $appointment['id'] ?>"><button type="button" class="btn btn-primary">
                                <span class="material-symbols-outlined">edit</span>
                              </button></a>

                            <button type="button" class="btn btn-danger del-btn" data-id="<?= $appointment['id'] ?>">
                              <span class="material-symbols-outlined">delete</span>
                            </button>
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
<script>
  $('.del-btn').on('click', function() {
    const appointment_id = $(this).data('id')

    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '../backend/ajax.php?action=delete_appointment',
          method: 'POST',
          data: {
            'appointment_id': appointment_id
          },
          beforeSend: function() {
            Swal.fire({
              icon: "info",
              title: "Please wait...",
              timer: 60000,
              showConfirmButton: false,
              didOpen: () => {
                Swal.showLoading();
              }
            });
          },
          success: function(resp) {
            console.log(resp)
            resp = JSON.parse(resp)
            if (resp.status === 'error') {
              Swal.fire({
                icon: 'error',
                title: resp.message,
                heightAuto: false
              });
            } else if (resp.status === 'success') {
              Swal.fire({
                icon: 'success',
                title: resp.message,
                heightAuto: false
              }).then(function() {
                window.location.reload();
              })
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Oops something went wrong.',
                heightAuto: false
              });
            }
          }
        })
      }
    })
  })
</script>

</html>