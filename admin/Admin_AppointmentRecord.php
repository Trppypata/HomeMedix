<?php
require_once('../backend/function.php');
require_once('../backend/config.php');
if (!isset($_SESSION['role']) && $_SESSION['role'] != 0) {
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
                    <a href="./Appointment.php" class="btn"><button type="button" class="btn btn-info d-flex align-items-center">
                        <img src="img/Add.png" alt="Icon">
                        <h5 class="white-text">Add Appointment</h5>
                      </button></a>
                  </div>
                </div>
              </div>
              
              <!-- Filter by status -->
              <div class="row mt-3 mb-3">
                <div class="col-md-4">
                  <div class="input-group">
                    <label class="input-group-text" for="statusFilter">Filter by Status:</label>
                    <select class="form-select" id="statusFilter">
                      <option value="all" selected>All Appointments</option>
                      <option value="1">Pending</option>
                      <option value="2">Accepted</option>
                      <option value="3">Declined</option>
                      <option value="4">Completed</option>
                    </select>
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
                      <th>Status</th>
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
                            <?php
                              switch($appointment['status']) {
                                case 0: echo '<span class="badge bg-secondary">Draft</span>'; break;
                                case 1: echo '<span class="badge bg-warning text-dark">Pending</span>'; break;
                                case 2: echo '<span class="badge bg-success">Accepted</span>'; break;
                                case 3: echo '<span class="badge bg-danger">Declined</span>'; break;
                                case 4: echo '<span class="badge bg-info">Completed</span>'; break;
                                default: echo '<span class="badge bg-secondary">Unknown</span>';
                              }
                            ?>
                          </td>
                          <td>
                            <a href="appointment.php?id=<?= $appointment['id'] ?>"><button type="button" class="btn btn-primary">
                                <span class="material-symbols-outlined">edit</span>
                              </button></a>

                            <button type="button" class="btn btn-secondary view-btn" data-id="<?= $appointment['id'] ?>">
                              <span class="material-symbols-outlined">visibility</span>
                            </button>

                            <button type="button" class="btn btn-danger del-btn" data-id="<?= $appointment['id'] ?>">
                              <span class="material-symbols-outlined">delete</span>
                            </button>
                            
                            <div class="btn-group mt-2">
                              <button type="button" class="btn <?= $appointment['status'] == 2 ? 'btn-success' : 'btn-outline-success' ?> btn-sm status-btn" data-id="<?= $appointment['id'] ?>" data-status="2" data-bs-toggle="tooltip" data-bs-placement="top" title="Accept">
                                <i class="fas fa-check"></i>
                              </button>
                              <button type="button" class="btn <?= $appointment['status'] == 1 ? 'btn-warning' : 'btn-outline-warning' ?> btn-sm status-btn" data-id="<?= $appointment['id'] ?>" data-status="1" data-bs-toggle="tooltip" data-bs-placement="top" title="Pending">
                                <i class="fas fa-clock"></i>
                              </button>
                              <button type="button" class="btn <?= $appointment['status'] == 3 ? 'btn-danger' : 'btn-outline-danger' ?> btn-sm status-btn" data-id="<?= $appointment['id'] ?>" data-status="3" data-bs-toggle="tooltip" data-bs-placement="top" title="Decline">
                                <i class="fas fa-times"></i>
                              </button>
                              <?php if ($appointment['status'] == 2 || $appointment['status'] == 4): ?>
                              <button type="button" class="btn <?= $appointment['status'] == 4 ? 'btn-info' : 'btn-outline-info' ?> btn-sm status-btn" data-id="<?= $appointment['id'] ?>" data-status="4" data-bs-toggle="tooltip" data-bs-placement="top" title="Mark as Completed">
                                <i class="fas fa-clipboard-check"></i>
                              </button>
                              <?php endif; ?>
                            </div>
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
  
  <!-- Appointment Details Modal -->
  <div class="modal fade" id="appointmentDetailsModal" tabindex="-1" aria-labelledby="appointmentDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="appointmentDetailsModalLabel">Appointment Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <h6 class="fw-bold">Patient Information</h6>
              <p><strong>Name:</strong> <span id="modal-patient-name"></span></p>
              <p><strong>Sex:</strong> <span id="modal-sex"></span></p>
              <p><strong>Age:</strong> <span id="modal-age"></span></p>
              <p><strong>Address:</strong> <span id="modal-address"></span></p>
              <p><strong>Email:</strong> <span id="modal-email"></span></p>
              <p><strong>Phone:</strong> <span id="modal-phone"></span></p>
            </div>
            <div class="col-md-6">
              <h6 class="fw-bold">Appointment Information</h6>
              <p><strong>ID:</strong> <span id="modal-appointment-id"></span></p>
              <p><strong>Case:</strong> <span id="modal-case"></span></p>
              <p><strong>Service:</strong> <span id="modal-service"></span></p>
              <p><strong>Date:</strong> <span id="modal-date"></span></p>
              <p><strong>Time:</strong> <span id="modal-time"></span></p>
              <p><strong>Status:</strong> <span id="modal-status"></span></p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    
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
            dataType: 'json',
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
            },
            error: function(xhr, status, error) {
              console.error('AJAX Error:', xhr, status, error);
              Swal.fire({
                icon: 'error',
                title: 'Connection Error',
                text: 'Could not connect to server. Please try again later.',
                heightAuto: false
              });
            }
          })
        }
      })
    })

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
    
    // Handle appointment status change
    $('.status-btn').on('click', function() {
      const appointment_id = $(this).data('id');
      const status = $(this).data('status');
      let statusText = '';
      let buttonColor = '#3085d6';
      
      switch(status) {
        case 1: 
          statusText = 'mark as Pending'; 
          buttonColor = '#f8bb86'; 
          break;
        case 2: 
          statusText = 'Accept'; 
          buttonColor = '#28a745'; 
          break;
        case 3: 
          statusText = 'Decline'; 
          buttonColor = '#dc3545'; 
          break;
        case 4: 
          statusText = 'mark as Completed'; 
          buttonColor = '#17a2b8'; 
          break;
        default: 
          statusText = 'update';
          buttonColor = '#3085d6';
      }
      
      // If accepting appointment, first get list of therapists
      if (status == 2) {
        $.ajax({
          url: '../backend/ajax.php?action=get_therapists',
          method: 'GET',
          dataType: 'json', // Tell jQuery to expect JSON
          success: function(data) {
            try {
              if (data.status === 'success' && data.data.length > 0) {
                // Create therapist options
                let therapistOptions = '';
                data.data.forEach(therapist => {
                  therapistOptions += `<option value="${therapist.id}">${therapist.fname} ${therapist.lname} (${therapist.role == 2 ? 'Therapist' : 'Caregiver'})</option>`;
                });
                
                Swal.fire({
                  title: 'Assign to Therapist',
                  html: `
                    <p>Please select a therapist to assign this appointment to:</p>
                    <select id="therapist-select" class="form-select">
                      <option value="">-- Select a therapist --</option>
                      ${therapistOptions}
                    </select>
                  `,
                  icon: 'question',
                  showCancelButton: true,
                  confirmButtonColor: buttonColor,
                  cancelButtonColor: '#6c757d',
                  confirmButtonText: `Assign & Accept`,
                  preConfirm: () => {
                    const therapistId = document.getElementById('therapist-select').value;
                    if (!therapistId) {
                      Swal.showValidationMessage('Please select a therapist');
                      return false;
                    }
                    return therapistId;
                  }
                }).then((result) => {
                  if (result.isConfirmed) {
                    updateAppointmentStatus(appointment_id, status, result.value);
                  }
                });
              } else {
                // No therapists available
                Swal.fire({
                  title: 'No Therapists Available',
                  text: 'There are no therapists or caregivers available in the system. Please add therapists first.',
                  icon: 'warning',
                  confirmButtonColor: '#3085d6'
                });
              }
            } catch (e) {
              console.error('Error processing therapists:', e);
              // Fall back to regular confirmation
              showRegularConfirmation(appointment_id, status, statusText, buttonColor);
            }
          },
          error: function(xhr, status, error) {
            console.error('AJAX Error:', xhr, status, error);
            // Fall back to regular confirmation on error
            showRegularConfirmation(appointment_id, status, statusText, buttonColor);
          }
        });
      } else {
        // For non-accept status, show regular confirmation
        showRegularConfirmation(appointment_id, status, statusText, buttonColor);
      }
    });
    
    // Function to show regular confirmation dialog
    function showRegularConfirmation(appointment_id, status, statusText, buttonColor) {
      Swal.fire({
        title: 'Are you sure?',
        text: `Do you want to ${statusText} this appointment?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: buttonColor,
        cancelButtonColor: '#6c757d',
        confirmButtonText: `Yes, ${statusText}!`
      }).then((result) => {
        if (result.isConfirmed) {
          updateAppointmentStatus(appointment_id, status);
        }
      });
    }
    
    // Function to update appointment status
    function updateAppointmentStatus(appointment_id, status, therapist_id = null) {
      const data = {
        'appointment_id': appointment_id,
        'status': status
      };
      
      // Add therapist_id if provided
      if (therapist_id) {
        data.therapist_id = therapist_id;
      }
      
      $.ajax({
        url: '../backend/ajax.php?action=update_appointment_status',
        method: 'POST',
        data: data,
        dataType: 'json', // Tell jQuery to expect JSON response
        beforeSend: function() {
          Swal.fire({
            icon: "info",
            title: "Processing...",
            text: "Please wait while we update the appointment status.",
            timer: 60000,
            showConfirmButton: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });
        },
        success: function(resp) {
          if (resp.status === 'error') {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: resp.message || 'An error occurred while updating the appointment status.',
              heightAuto: false
            });
          } else if (resp.status === 'success') {
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: resp.message || `Appointment has been updated successfully!`,
              heightAuto: false
            }).then(function() {
              window.location.reload();
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Unexpected Response',
              text: 'The server returned an unexpected response. Please try again.',
              heightAuto: false
            });
          }
        },
        error: function(xhr, status, error) {
          console.error('AJAX Error:', xhr, status, error);
          Swal.fire({
            icon: 'error',
            title: 'Connection Error',
            text: 'Could not connect to the server. Please check your network connection and try again.',
            heightAuto: false
          });
        }
      });
    }
    
    // Handle status filtering
    $('#statusFilter').on('change', function() {
      const status = $(this).val();
      
      if (status === 'all') {
        // Show all rows
        $('tbody tr').show();
      } else {
        // Hide all rows first
        $('tbody tr').hide();
        
        // Show only rows with matching status
        $('tbody tr').each(function() {
          const rowStatus = $(this).find('td:nth-child(7) .badge').text();
          
          if ((status === '1' && rowStatus === 'Pending') ||
              (status === '2' && rowStatus === 'Accepted') ||
              (status === '3' && rowStatus === 'Declined') ||
              (status === '4' && rowStatus === 'Completed')) {
            $(this).show();
          }
        });
      }
    });
    
    // Handle view button click
    $('.view-btn').on('click', function() {
      const appointmentId = $(this).data('id');
      const row = $(this).closest('tr');
      
      // Get data from the row
      const patientName = row.find('td:nth-child(2)').text();
      const appointmentCase = row.find('td:nth-child(3)').text();
      const service = row.find('td:nth-child(4)').text();
      const date = row.find('td:nth-child(5)').text();
      const time = row.find('td:nth-child(6)').text();
      const status = row.find('td:nth-child(7) .badge').text();
      
      // Fetch additional details via AJAX
      $.ajax({
        url: '../backend/ajax.php?action=get_appointment_details',
        method: 'POST',
        data: {
          'appointment_id': appointmentId
        },
        dataType: 'json', // Tell jQuery to expect JSON
        success: function(data) {
          if (data.status === 'success') {
            const appointment = data.data;
            
            // Populate modal with data
            $('#modal-patient-name').text(patientName);
            $('#modal-sex').text(appointment.sex == 1 ? 'Male' : 'Female');
            
            // Calculate age from birthday
            const birthDate = new Date(appointment.bday);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
              age--;
            }
            $('#modal-age').text(age);
            
            // Format address
            const fullAddress = `${appointment.address}, ${appointment.barangay}, ${appointment.city}, ${appointment.zip}`;
            $('#modal-address').text(fullAddress);
            
            $('#modal-email').text(appointment.email);
            $('#modal-phone').text(appointment.phone);
            $('#modal-appointment-id').text(appointmentId);
            $('#modal-case').text(appointmentCase);
            $('#modal-service').text(service);
            $('#modal-date').text(date);
            $('#modal-time').text(time);
            $('#modal-status').text(status);
            
            // Show the modal
            const appointmentModal = new bootstrap.Modal(document.getElementById('appointmentDetailsModal'));
            appointmentModal.show();
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Could not fetch appointment details.'
            });
          }
        },
        error: function(xhr, status, error) {
          console.error('AJAX Error:', xhr, status, error);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Could not fetch appointment details.'
          });
        }
      });
    });
  </script>
</body>

</html>