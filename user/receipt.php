<?php
require_once('../backend/function.php');

if(isset($_GET['id'])){
  $receipts = getTableWhere('appointments', 'id', $_GET['id']);
  if($receipts->num_rows > 0){
    foreach($receipts as $receipt){
      $payment = $receipt['payment'];
      $fullname = $receipt['fname'] . ($receipt['mname'] ? ' ' . $receipt['mname'] : '') . ' ' . $receipt['lname'];
      $service = $receipt['service'];
      $date = date('Y-m-d');
      $time = date('H:i:s');
    }
  }else{
    header("location: ./profile.php");
    exit;
  }
}else{
  header("location: ./profile.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Receipt - HomeMedix</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="receipt.css">
</head>
<body>

  <div class="bg-container">
  <div class="receipt-container mx-auto mt-4 border rounded p-3" id="invoice">
    <div class="text-center mb-3">
      <img src="img/logo.png" alt="Company Logo" class="img-fluid" style="max-height: 60px;">
    </div>
    <h6 class="text-center mb-2"><strong>Official Receipt</strong></h6>
    <hr>
    <div class="small">
      <p><strong>Transaction No.:</strong> #<?= $_GET['id'] + 100000 ?></p>
      <p><strong>Name:</strong> <?= $fullname ?></p>
      <p><strong>Date:</strong> <?= $date ?></p>
      <p><strong>Time:</strong> <?= $time ?></p>
      <p><strong>Payment Method:</strong> <?= $payment == 0 ? 'Over the Counter' : 'Card' ?></p>
      <p><strong>Queueing Number:</strong> <?= $_GET['id'] ?></p>
      <p><strong>Service Purchased:</strong> <?= getService($service) ?></p>
    </div>
    <div class="text-center mt-3">
      <img src="img/barcode.jpg" alt="Barcode" class="barcode d-none">
    </div>
    <hr>
    <div class="text-center mt-3">
      <button class="btn btn-sm btn-primary w-100 d-print-none mb-2" onclick="printReceipt()">Print</button>
      <button class="btn btn-sm btn-primary w-100 d-print-none" onclick="landingPage()">Return</button>
    </div>
  </div>
  </div>

  <script src="receipt.js"></script>
</body>
</html>
