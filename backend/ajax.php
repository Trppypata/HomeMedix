<?php
// Enable error reporting (disable in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('./controller.php');

$controller = new Controller();
$action = $_GET['action'] ?? null;

switch ($action) {
	case 'login':
		$controller->login();
		break;
	case 'signup':
		$controller->signup();
		break;
	case 'verify':
		$controller->verify();
		break;
	case 'logout':
		$controller->logout();
		break;
	case 'update_user':
		$controller->update_user();
		break;
	case 'delete_user':
		$controller->delete_user();
		break;
	case 'add_appointment':
		$controller->add_appointment();
		break;
	case 'update_appointment':
		$controller->update_appointment();
		break;
	case 'update_appointment_status':
		$controller->update_appointment_status();
		break;
	case 'fetch_appointments':
		$controller->fetch_appointments();
		break;
	case 'delete_appointment':
		$controller->delete_appointment();
		break;
	case 'get_appointment_details':
		$controller->get_appointment_details();
		break;
	case 'mark_notifications_read':
		$controller->mark_notifications_read();
		break;
	default:
		echo json_encode([
			'status' => 'error',
			'message' => 'Invalid or missing action.'
		]);
		break;
}

if ($response) {
	echo $response;
} else {
	echo json_encode([
		'status' => 'error',
		'message' => 'No response returned from server logic.'
	]);
}
