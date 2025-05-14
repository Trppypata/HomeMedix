<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "homemedix_db";

$con = new mysqli($servername, $username, $password, $database);

$base_url = "http://localhost/HomeMedix";

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
