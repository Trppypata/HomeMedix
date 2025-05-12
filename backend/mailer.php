<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('../vendor/autoload.php');

$mail = new PHPMailer;

$mail->isSMTP(); 
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'qsc-garachico@tip.edu.ph';
$mail->Password = 'ochk wovk pxri msej';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->isHTML(true); 
$mail->setFrom('qsc-garachico@tip.edu.ph', 'HomeMedix');
?>