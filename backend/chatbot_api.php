<?php
require_once('./config.php');

header('Content-Type: application/json');

function getServices() {
    global $con;
    $query = "SELECT * FROM services WHERE status = 1";
    $result = mysqli_query($con, $query);
    $services = [];
    while($row = mysqli_fetch_assoc($result)) {
        $services[] = $row;
    }
    return $services;
}

function getServiceByName($name) {
    global $con;
    $name = mysqli_real_escape_string($con, $name);
    $query = "SELECT * FROM services WHERE name LIKE '%$name%' AND status = 1";
    $result = mysqli_query($con, $query);
    return mysqli_fetch_assoc($result);
}

function getIllnesses() {
    global $con;
    $query = "SELECT * FROM illnesses WHERE status = 1";
    $result = mysqli_query($con, $query);
    $illnesses = [];
    while($row = mysqli_fetch_assoc($result)) {
        $illnesses[] = $row;
    }
    return $illnesses;
}

function getIllnessByName($name) {
    global $con;
    $name = mysqli_real_escape_string($con, $name);
    $query = "SELECT * FROM illnesses WHERE name LIKE '%$name%' AND status = 1";
    $result = mysqli_query($con, $query);
    return mysqli_fetch_assoc($result);
}

function getIllnessesByService($service) {
    global $con;
    $service = mysqli_real_escape_string($con, $service);
    $query = "SELECT * FROM illnesses WHERE related_services LIKE '%$service%' AND status = 1";
    $result = mysqli_query($con, $query);
    $illnesses = [];
    while($row = mysqli_fetch_assoc($result)) {
        $illnesses[] = $row;
    }
    return $illnesses;
}

function getMessages() {
    global $con;
    $query = "SELECT * FROM messages WHERE status = 1";
    $result = mysqli_query($con, $query);
    $messages = [];
    while($row = mysqli_fetch_assoc($result)) {
        $messages[] = $row;
    }
    return $messages;
}

// Handle the request
$action = $_GET['action'] ?? '';
$query = $_GET['query'] ?? '';

switch($action) {
    case 'services':
        if (!empty($query)) {
            $service = getServiceByName($query);
            echo json_encode(['status' => 'success', 'data' => $service]);
        } else {
            echo json_encode(['status' => 'success', 'data' => getServices()]);
        }
        break;
        
    case 'illnesses':
        if (!empty($query)) {
            $illness = getIllnessByName($query);
            echo json_encode(['status' => 'success', 'data' => $illness]);
        } else {
            echo json_encode(['status' => 'success', 'data' => getIllnesses()]);
        }
        break;
        
    case 'illnesses_by_service':
        if (!empty($query)) {
            echo json_encode(['status' => 'success', 'data' => getIllnessesByService($query)]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Service name is required']);
        }
        break;
        
    case 'messages':
        echo json_encode(['status' => 'success', 'data' => getMessages()]);
        break;
        
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
} 