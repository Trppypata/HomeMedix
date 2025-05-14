<?php
include('./controller.php');

$action = $_GET['action'];
$controller = new Controller();

if($action == 'login'){
	$response = $controller->login();
	if($response)
		echo $response;
}

if($action == 'signup'){
	$response = $controller->signup();
	if($response)
		echo $response;
}

if($action == 'verify'){
	$response = $controller->verify();
	if($response)
		echo $response;
}

if($action == 'logout'){
	$response = $controller->logout();
	if($response)
		echo $response;
}

if($action == 'update_user'){
	$response = $controller->update_user();
	if($response)
		echo $response;
}

if($action == 'delete_user'){
	$response = $controller->delete_user();
	if($response)
		echo $response;
}

if($action == 'add_appointment'){
	$response = $controller->add_appointment();
	if($response)
		echo $response;
}

if($action == 'update_appointment'){
	$response = $controller->update_appointment();
	if($response)
		echo $response;
}

if($action == 'update_appointment_status'){
	$response = $controller->update_appointment_status();
	if($response)
		echo $response;
}

if($action == 'fetch_appointments'){
	$response = $controller->fetch_appointments();
	if($response)
		echo $response;
}

if($action == 'delete_appointment'){
	$response = $controller->delete_appointment();
	if($response)
		echo $response;
}

if($action == 'get_appointment_details'){
	$response = $controller->get_appointment_details();
	if($response)
		echo $response;
}

if($action == 'mark_notifications_read'){
	$response = $controller->mark_notifications_read();
	if($response)
		echo $response;
}
?>