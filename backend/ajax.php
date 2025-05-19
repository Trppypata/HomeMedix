<?php
// Prevent PHP errors from being displayed in responses
ini_set('display_errors', 0);
error_reporting(0);

// Set content type to JSON for all responses
header('Content-Type: application/json');
// Set CORS headers if needed
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once('./controller.php');
$controller = new Controller();

if (isset($_GET['action'])) {
	$action = $_GET['action'];
	if (method_exists($controller, $action)) {
		$result = $controller->$action();
		// Don't re-encode if the result is already JSON
		if (is_string($result) && is_array(json_decode($result, true)) && json_last_error() == JSON_ERROR_NONE) {
			echo $result; // Result is already valid JSON
		} else {
			echo json_encode($result); // Convert to JSON
		}
	} else {
		echo json_encode(['status' => 'error', 'message' => 'Invalid action specified.']);
	}
} else {
	echo json_encode(['status' => 'error', 'message' => 'No action specified.']);
}
?>
