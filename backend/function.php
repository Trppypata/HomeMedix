<?php
if (file_exists('./config.php')) {
    require_once('./config.php');
} elseif (file_exists('../backend/config.php')) {
    require_once('../backend/config.php');
}
session_start();

function getTable($table){
    global $con;

    $table = mysqli_real_escape_string($con, $table);

    $query = "SELECT * FROM `$table` ORDER BY created_at DESC";
    return $query_run = mysqli_query($con, $query);
}

function getTableWhere($table, $column, $value){
    global $con;

    $table = mysqli_real_escape_string($con, $table);
    $column = mysqli_real_escape_string($con, $column);
    $value = mysqli_real_escape_string($con, $value);

    // For appointments with status 1 (pending), don't filter by practitioner_id
    if ($table == 'appointments' && $column == 'status' && $value == 1) {
        $query = "SELECT * FROM `$table` WHERE `$column` = $value ORDER BY created_at DESC";
    } 
    // For appointments with status 2 (accepted), filter by the current practitioner
    else if ($table == 'appointments' && $column == 'status' && $value == 2 && isset($_SESSION['role']) && ($_SESSION['role'] == 2 || $_SESSION['role'] == 3)) {
        $query = "SELECT * FROM `$table` WHERE `$column` = $value AND practitioner_id = {$_SESSION['id']} ORDER BY created_at DESC";
    }
    // Default query
    else {
        $query = "SELECT * FROM `$table` WHERE `$column` = $value ORDER BY created_at DESC";
    }
    
    return $query_run = mysqli_query($con, $query);
}

function getUsersByRole($role){
    global $con;

    $role = mysqli_real_escape_string($con, $role);

    if ($role == 2 || $role == 3) {
        $query = "
            SELECT *, users.id AS user_id
            FROM users 
            INNER JOIN practitioners ON users.id = practitioners.user_id 
            WHERE users.role = $role 
            ORDER BY users.created_at DESC
        ";
    } else {
        $query = "
            SELECT *, id AS user_id 
            FROM users 
            WHERE role = $role 
            ORDER BY created_at DESC
        ";
    }

    return $query_run = mysqli_query($con, $query);
}

function getAppointmentsByStatus($column, $id, $status){
    global $con;

    $column = mysqli_real_escape_string($con, $column);
    $id = mysqli_real_escape_string($con, $id);
    $status = mysqli_real_escape_string($con, $status);

    $query = "SELECT * FROM appointments WHERE status = $status AND `$column` = $id ORDER BY created_at DESC";
    return $query_run = mysqli_query($con, $query);
}

function getCurrentAppointments(){
    global $con;

    $today = date('Y-m-d');

    $query = "SELECT * FROM appointments 
              WHERE status = 2 
              AND appointment_date >= CURDATE() 
              AND practitioner_id = '".$_SESSION['id']."' 
              ORDER BY appointment_date ASC, appointment_time ASC";
    return $query_run = mysqli_query($con, $query);
}

function getPastAppointments(){
    global $con;

    $today = date('Y-m-d');

    $query = "SELECT * FROM appointments WHERE appointment_date < CURDATE() AND practitioner_id = '".$_SESSION['id']."' ORDER BY appointment_date DESC";
    return $query_run = mysqli_query($con, $query);
}

function getAppointmentHistory() {
    global $con;

    $query = "SELECT * FROM appointments 
              WHERE status != 0 
              AND user_id = '".$_SESSION['id']."'
              AND appointment_date < CURDATE() 
              ORDER BY appointment_date DESC";
              
    return $query_run = mysqli_query($con, $query);
}

function getRole($role){
    switch($role){
        case 1:
            return 'Users';
        case 2:
            return 'Therapists';
        case 3:
            return 'Caregivers';
        default: 
            return 'Admins';
    }
}

function getService($service){
    switch($service){
        case 0:
            return 'Physical Therapy';
        case 1:
            return 'Caregiving Service (8-hour shift)';
        case 2:
            return 'Caregiving Service (12-hour shift)';
        case 3:
            return 'Caregiving Service (24-hour shift)';
        case 4:
            return 'Nursing Home';
        default: 
            return 'No selected yet.';
    }
}

function getPractitionerNotifications($practitioner_id, $limit = 10) {
    global $con;
    $practitioner_id = mysqli_real_escape_string($con, $practitioner_id);
    $query = "SELECT * FROM practitioner_notifications WHERE practitioner_id = $practitioner_id ORDER BY created_at DESC LIMIT $limit";
    return mysqli_query($con, $query);
}

function getPractitionerUnreadNotificationCount($practitioner_id) {
    global $con;
    $practitioner_id = mysqli_real_escape_string($con, $practitioner_id);
    $query = "SELECT COUNT(*) as unread_count FROM practitioner_notifications WHERE practitioner_id = $practitioner_id AND is_read = 0";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['unread_count'] ?? 0;
}

?>