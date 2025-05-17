<?php
// Enable error reporting (disable in production)
ini_set('display_errors', 0); // Disable error display
error_reporting(E_ALL);

include('./controller.php');

$controller = new Controller();
$action = $_GET['action'] ?? null;

// Initialize response variable
$response = null;

switch ($action) {
	case 'login':
		$response = $controller->login();
		break;
	case 'signup':
		$response = $controller->signup();
		break;
	case 'verify':
		$response = $controller->verify();
		break;
	case 'logout':
		$response = $controller->logout();
		break;
	case 'update_user':
		$response = $controller->update_user();
		break;
	case 'delete_user':
		$response = $controller->delete_user();
		break;
	case 'add_appointment':
		$response = $controller->add_appointment();
		break;
	case 'update_appointment':
		$response = $controller->update_appointment();
		break;
	case 'update_appointment_status':
		$response = $controller->update_appointment_status();
		break;
	case 'fetch_appointments':
		$response = $controller->fetch_appointments();
		break;
	case 'delete_appointment':
		$response = $controller->delete_appointment();
		break;
	case 'get_appointment_details':
		$response = $controller->get_appointment_details();
		break;
	case 'mark_notifications_read':
		$response = $controller->mark_notifications_read();
		break;
	default:
		$response = json_encode([
			'status' => 'error',
			'message' => 'Invalid or missing action.'
		]);
		break;
}

// Output the response
if ($response) {
	echo $response;
} else {
	echo json_encode([
		'status' => 'error',
		'message' => 'No response returned from server logic.'
	]);
}
