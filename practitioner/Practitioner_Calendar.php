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
    <link rel="stylesheet" href="Practitioner_Calendar.css">
    <title>Appointment - Practitioners</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- CSS for full calender -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" />
    <!-- JS for full calender -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
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


        <!--CALENDAR HERE-->
        <div id="calendar"></div>


        </div>
      </div>
    </div>
    </div>
    </div>
  </body>
  <script>
    $(document).ready(function () {
      display_events();
    });

    function display_events() {
      let events = [];
      $.ajax({
        url: '../backend/ajax.php?action=fetch_appointments',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
          if (response && response.data && Array.isArray(response.data)) {
            const result = response.data;
            $.each(result, function (i, item) {
              events.push({
                event_id: item.event_id,
                title: item.title,
                start: item.start,
                end: item.end,
                color: item.color,
                service: item.service,
              });
            });
          }

          // Initialize FullCalendar
          $('#calendar').fullCalendar({
            defaultView: 'month',
            timeZone: 'local',
            editable: true,
            selectable: true,
            selectHelper: true,
            events: events,
            select: function(start, end) {
              Swal.fire({
                title: 'Add Appointment',
                html: `
                  <form id="appointmentForm" class="text-start">
                    <div class="mb-3">
                      <label for="fname" class="form-label">First Name</label>
                      <input type="text" class="form-control" id="fname" required>
                    </div>
                    <div class="mb-3">
                      <label for="lname" class="form-label">Last Name</label>
                      <input type="text" class="form-control" id="lname" required>
                    </div>
                    <div class="mb-3">
                      <label for="email" class="form-label">Email</label>
                      <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                      <label for="phone" class="form-label">Phone</label>
                      <input type="text" class="form-control" id="phone" required placeholder="09XXXXXXXXX">
                    </div>
                    <div class="mb-3">
                      <label for="sex" class="form-label">Sex</label>
                      <select class="form-control" id="sex" required>
                        <option value="">Select</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label for="bday" class="form-label">Birthday</label>
                      <input type="date" class="form-control" id="bday" required>
                    </div>
                    <div class="mb-3">
                      <label for="address" class="form-label">Address</label>
                      <input type="text" class="form-control" id="address" required>
                    </div>
                    <div class="mb-3">
                      <label for="barangay" class="form-label">Barangay</label>
                      <input type="text" class="form-control" id="barangay" required>
                    </div>
                    <div class="mb-3">
                      <label for="city" class="form-label">City</label>
                      <input type="text" class="form-control" id="city" required>
                    </div>
                    <div class="mb-3">
                      <label for="zip" class="form-label">ZIP Code</label>
                      <input type="text" class="form-control" id="zip" required>
                    </div>
                    <div class="mb-3">
                      <label for="appointment_case" class="form-label">Appointment Case</label>
                      <input type="text" class="form-control" id="appointment_case" required>
                    </div>
                    <div class="mb-3">
                      <label for="service" class="form-label">Service</label>
                      <select class="form-control" id="service" required>
                        <option value="">Select</option>
                        <option value="0">Physical Therapy</option>
                        <option value="1">Caregiving Service (8-hour shift)</option>
                        <option value="2">Caregiving Service (12-hour shift)</option>
                        <option value="3">Caregiving Service (24-hour shift)</option>
                        <option value="4">Nursing Home</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label for="time" class="form-label">Time</label>
                      <input type="time" class="form-control" id="time" required>
                    </div>
                  </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#28a745',
                width: '600px',
                preConfirm: () => {
                  const fname = document.getElementById('fname').value;
                  const lname = document.getElementById('lname').value;
                  const email = document.getElementById('email').value;
                  const phone = document.getElementById('phone').value;
                  const sex = document.getElementById('sex').value;
                  const bday = document.getElementById('bday').value;
                  const address = document.getElementById('address').value;
                  const barangay = document.getElementById('barangay').value;
                  const city = document.getElementById('city').value;
                  const zip = document.getElementById('zip').value;
                  const appointment_case = document.getElementById('appointment_case').value;
                  const service = document.getElementById('service').value;
                  const time = document.getElementById('time').value;
                  
                  // Check required fields
                  const requiredFields = [
                    { id: 'fname', label: 'First Name' },
                    { id: 'lname', label: 'Last Name' },
                    { id: 'email', label: 'Email' },
                    { id: 'phone', label: 'Phone' },
                    { id: 'sex', label: 'Sex' },
                    { id: 'bday', label: 'Birthday' },
                    { id: 'address', label: 'Address' },
                    { id: 'barangay', label: 'Barangay' },
                    { id: 'city', label: 'City' },
                    { id: 'zip', label: 'ZIP Code' },
                    { id: 'appointment_case', label: 'Appointment Case' },
                    { id: 'service', label: 'Service' },
                    { id: 'time', label: 'Time' }
                  ];
                  
                  for (const field of requiredFields) {
                    if (!document.getElementById(field.id).value) {
                      Swal.showValidationMessage(`Please enter ${field.label}`);
                      return false;
                    }
                  }

                  // Validate email format
                  if (!/^\S+@\S+\.\S+$/.test(email)) {
                    Swal.showValidationMessage('Please enter a valid email');
                    return false;
                  }

                  // Validate phone format (09XXXXXXXXX or +639XXXXXXXXX)
                  if (!/^(09\d{9}|\+639\d{9})$/.test(phone)) {
                    Swal.showValidationMessage('Please enter a valid phone number (09XXXXXXXXX or +639XXXXXXXXX)');
                    return false;
                  }
                  
                  return { 
                    fname, lname, email, phone, sex, bday, address, 
                    barangay, city, zip, appointment_case, service, time 
                  };
                }
              }).then((result) => {
                if (result.isConfirmed) {
                  const { 
                    fname, lname, email, phone, sex, bday, address, 
                    barangay, city, zip, appointment_case, service, time 
                  } = result.value;
                  const date = start.format('YYYY-MM-DD');
                  
                  // Add the event to the calendar
                  $('#calendar').fullCalendar('renderEvent', {
                    title: `${fname} ${lname}`,
                    start: `${date}T${time}`,
                    end: `${date}T${time}`,
                    color: '#28a745',
                    service: getServiceName(service)
                  }, true);
                  
                  // Save to database
                  $.ajax({
                    url: '../backend/ajax.php?action=add_appointment',
                    method: 'POST',
                    data: {
                      fname: fname,
                      lname: lname,
                      email: email,
                      phone: phone,
                      sex: sex,
                      bday: bday,
                      address: address,
                      barangay: barangay,
                      city: city,
                      zip: zip,
                      appointment_case: appointment_case,
                      service: service,
                      appointment_date: date,
                      appointment_time: time,
                      status: 2  // Set as accepted since it's added by the therapist
                    },
                    beforeSend: function() {
                      Swal.fire({
                        title: 'Saving...',
                        text: 'Please wait while we save your appointment',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                          Swal.showLoading();
                        }
                      });
                    },
                    success: function(response) {
                      try {
                        const data = JSON.parse(response);
                        if (data.status === 'success') {
                          Swal.fire({
                            title: 'Success!',
                            text: 'Appointment added successfully',
                            icon: 'success',
                            confirmButtonColor: '#28a745'
                          }).then(() => {
                            // Reload calendar to show updated events
                            $('#calendar').fullCalendar('destroy');
                            display_events();
                          });
                        } else {
                          Swal.fire({
                            title: 'Error!',
                            text: data.message || 'Failed to add appointment',
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                          });
                          console.error('Server response:', data);
                        }
                      } catch (e) {
                        console.error('Error parsing response:', e, response);
                        Swal.fire({
                          title: 'Error!',
                          text: 'Invalid server response',
                          icon: 'error',
                          confirmButtonColor: '#dc3545'
                        });
                      }
                    },
                    error: function(xhr, status, error) {
                      console.error('AJAX error:', xhr, status, error);
                      Swal.fire({
                        title: 'Error!',
                        text: 'Failed to add appointment. Please check your network connection.',
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                      });
                    }
                  });
                }
              });
            },
            eventClick: function (event) {
              Swal.fire({
                title: event.title,
                html: `
                  <p><strong>Service:</strong> ${event.service || 'Not specified'}</p>
                  <p><strong>Date:</strong> ${event.start.format('MMMM D, YYYY')}</p>
                  <p><strong>Time:</strong> ${event.start.format('h:mm A')}</p>
                `,
                icon: 'info', 
                confirmButtonText: 'OK',
                confirmButtonColor: '#28a745', 
              });
            },
          });
        },
        error: function (xhr, status, error) {
          console.log(xhr)
          console.error('Error fetching events:', error);
          alert('Failed to load appointments. Please try again.');
        },
      });
    }

    function getServiceName(service) {
      switch(service) {
        case '0': return 'Physical Therapy';
        case '1': return 'Caregiving Service (8-hour shift)';
        case '2': return 'Caregiving Service (12-hour shift)';
        case '3': return 'Caregiving Service (24-hour shift)';
        case '4': return 'Nursing Home';
        default: return 'Not specified';
      }
    }
  </script>
</html>