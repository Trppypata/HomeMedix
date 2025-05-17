<?php
$servername = "sql108.infinityfree.com";
$username   = "if0_38967460";
$password   = "Ld83ukA9glGB";
$database   = "if0_38967460_homemedix_db";

$con = new mysqli($servername, $username, $password, $database);

// Remote hosting URL
$base_url = "https://homemedix.free.nf";

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
