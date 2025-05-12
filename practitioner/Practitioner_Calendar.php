<?php
require_once('../backend/function.php');
if(!isset($_SESSION['role']) && ($_SESSION['role'] != 2 || $_SESSION['role'] != 3)){
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
    <link rel="stylesheet" href="Practitioner_Records.css">
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
          console.log(response)
          if (response && response.data) {
           
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

            // Initialize FullCalendar
            $('#calendar').fullCalendar({
              defaultView: 'month',
              timeZone: 'local',
              editable: false,
              events: events,
              eventClick: function (event) {
                Swal.fire({
                  title: event.title,
                  html: `
                    <p><strong>Service:</strong> ${event.service || 'Not specified'}</p>
                    <p><strong>Date:</strong> ${event.start || 'Not specified'}</p>
                  `,
                  icon: 'info', 
                  confirmButtonText: 'OK',
                  confirmButtonColor: '#28a745', 
                });
              },
            });
          } else {
            console.error('No data received.');
          }
        },
        error: function (xhr, status, error) {
          console.log(xhr)
          console.error('Error fetching events:', error);
          alert('Failed to load appointments. Please try again.');
        },
      });
    }
  </script>
</html>