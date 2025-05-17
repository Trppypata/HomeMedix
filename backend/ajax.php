<?php
// Prevent PHP errors from being displayed in responses
ini_set('display_errors', 0);
error_reporting(0);

// Set content type to JSON for all responses
header('Content-Type: application/json');

require_once('./controller.php');
$controller = new Controller();

if (isset($_GET['action'])) {
	$action = $_GET['action'];
	if (method_exists($controller, $action)) {
		echo $controller->$action();
	} else {
		echo json_encode(['status' => 'error', 'message' => 'Invalid action specified.']);
	}
} else {
	echo json_encode(['status' => 'error', 'message' => 'No action specified.']);
}
?>
