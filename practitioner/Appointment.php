<?php
require_once('../backend/function.php');

$status = 0;
if(isset($_GET['id'])){
    $drafts = getTableWhere('appointments', 'id', $_GET['id']);
    if($drafts->num_rows > 0):
        foreach($drafts as $draft):
            $user_id = $draft['user_id'];
            $status = $draft['status'];

            $fname = $draft['fname'];
            $mname = $draft['mname'];
            $lname = $draft['lname'];
            $sex = $draft['sex'];
            $bday = $draft['bday'];
            $age = (new DateTime($draft['bday']))->diff(new DateTime())->y;
            $address = $draft['address'];
            $barangay = $draft['barangay'];
            $city = $draft['city'];
            $zip = $draft['zip'];
            $appointment_case = $draft['appointment_case'];
            $service = $draft['service'];
            $payment = $draft['service'];
            $appointment_date = $draft['appointment_date'];
            $appointment_time = $draft['appointment_time'];
            $email = $draft['email'];
            $phone = $draft['phone'];
        endforeach;
    else:
        header("location: ./profile.php");
        exit;
    endif;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Appointment.css">
    <title>Appointment Form - HomeMedix</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="banner-container">
        <img src="img/ClinicAppointment.jpg" alt="banner-container">
        <div class="banner-text">
            <h1><span class="bordered-blue">Appointment Form</span></h1>
        </div>
    </div>

    <div class="container mb-5">
        <form id="appointment-form">
            <div class="form-section">
                <h2 class="form-title">Personal Information</h2>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" name="fname" class="form-control" id="firstName" value="<?= $fname ?? '' ?>" required <?= $status != 0 ? 'disabled' : ''?>>
                    </div>
                    <div class="col-md-4">
                        <label for="middleName" class="form-label">Middle Name</label>
                        <input type="text" name="mname" class="form-control" id="middleName" value="<?= $mname ?? '' ?>" required <?= $status != 0 ? 'disabled' : ''?>>
                    </div>
                    <div class="col-md-4">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" name="lname" class="form-control" id="lastName" value="<?= $lname ?? '' ?>" required <?= $status != 0 ? 'disabled' : ''?>>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="sex" class="form-label">Sex</label>
                        <select class="form-select" id="sex" name="sex" required <?= $status != 0 ? 'disabled' : ''?>>
                            <option value="">Choose...</option>
                            <option value="1" <?= isset($sex) && $sex == 1 ? 'selected' : '' ?>>Male</option>
                            <option value="2" <?= isset($sex) && $sex == 2 ? 'selected' : '' ?>>Female</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="birthdate" class="form-label">Birthdate</label>
                        <input type="date" name="bday" class="form-control" id="birthdate" value="<?= $bday ?? '' ?>" required <?= $status != 0 ? 'disabled' : ''?>>
                    </div>
                    <div class="col-md-4">
                        <label for="age" class="form-label">Age</label>
                        <input type="number" class="form-control" id="age" value="<?= $age ?? '' ?>" readonly <?= $status != 0 ? 'disabled' : ''?>>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h2 class="form-title">Address</h2>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="streetAddress" class="form-label">Street Address</label>
                        <input type="text" name="address" class="form-control" id="streetAddress" value="<?= $address ?? '' ?>" required <?= $status != 0 ? 'disabled' : ''?>>
                    </div>
                    <div class="col-md-6">
                        <label for="barangay" class="form-label">Baranggay</label>
                        <input type="text" name="barangay" class="form-control" id="barangay" value="<?= $barangay ?? '' ?>" required <?= $status != 0 ? 'disabled' : ''?>>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="city" class="form-label">City</label>
                        <input type="text" name="city" class="form-control" id="city" value="<?= $city ?? '' ?>" required <?= $status != 0 ? 'disabled' : ''?>>
                    </div>
                    <div class="col-md-6">
                        <label for="zipCode" class="form-label">ZIP Code</label>
                        <input type="text" name="zip" class="form-control" id="zipCode" value="<?= $zip ?? '' ?>" required <?= $status != 0 ? 'disabled' : ''?>>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h2 class="form-title">Case</h2>
                <div class="mb-3">
                    <label for="caseDescription" class="form-label">Describe Your Case</label>
                    <textarea name="appointment_case" class="form-control" id="caseDescription" rows="3" required <?= $status != 0 ? 'disabled' : ''?>><?= $appointment_case ?? '' ?></textarea>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="serviceType" class="form-label">Type of Service</label>
                        <select name="service" class="form-select" id="serviceType" required <?= $status != 0 ? 'disabled' : ''?>>
                            <option value="">Choose...</option>
                            <option value="0" <?= isset($service) && $service == 0 ? 'selected' : '' ?>>Physical Therapy</option>
                            <option value="1" <?= isset($service) && $service == 1 ? 'selected' : '' ?>>Caregiving Service (8-hour shift)</option>
                            <option value="2" <?= isset($service) && $service == 2 ? 'selected' : '' ?>>Caregiving Service (12-hour shift)</option>
                            <option value="3" <?= isset($service) && $service == 3 ? 'selected' : '' ?>>Caregiving Service (24-hour shift)</option>
                            <option value="4" <?= isset($service) && $service == 4 ? 'selected' : '' ?>>Nursing Home</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="paymentType" class="form-label">Payment Type</label>
                        <select name="payment" class="form-select" id="paymentType" required <?= $status != 0 ? 'disabled' : ''?>>
                            <option value="">Choose...</option>
                            <option value="0" <?= isset($payment) && $payment == 0 ? 'selected' : '' ?>>Over the Counter</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="appointmentDate" class="form-label">Appointment Date</label>
                        <input type="date" name="appointment_date" class="form-control" id="appointmentDate" value="<?= $appointment_date ?? '' ?>" required <?= $status != 0 ? 'disabled' : ''?>>
                    </div>
                    <div class="col-md-6">
                        <label for="appointmentTime" class="form-label">Appointment Time</label>
                        <select class="form-select" name="appointment_time" id="appointmentTime" required <?= $status != 0 ? 'disabled' : ''?>>
                            <option value="">Select an Appointment Slot</option>
                            <option value="08:00" <?= isset($appointment_time) && $appointment_time == '08:00:00' ? 'selected' : '' ?>>8:00 AM</option>
                            <option value="09:00" <?= isset($appointment_time) && $appointment_time == '09:00:00' ? 'selected' : '' ?>>9:00 AM</option>
                            <option value="10:00" <?= isset($appointment_time) && $appointment_time == '10:00:00' ? 'selected' : '' ?>>10:00 AM</option>
                            <option value="11:00" <?= isset($appointment_time) && $appointment_time == '11:00:00' ? 'selected' : '' ?>>11:00 AM</option>
                            <option value="12:00" <?= isset($appointment_time) && $appointment_time == '12:00:00' ? 'selected' : '' ?>>12:00 PM</option>
                            <option value="13:00" <?= isset($appointment_time) && $appointment_time == '13:00:00' ? 'selected' : '' ?>>1:00 PM</option>
                            <option value="14:00" <?= isset($appointment_time) && $appointment_time == '14:00:00' ? 'selected' : '' ?>>2:00 PM</option>
                            <option value="15:00" <?= isset($appointment_time) && $appointment_time == '15:00:00' ? 'selected' : '' ?>>3:00 PM</option>
                            <option value="16:00" <?= isset($appointment_time) && $appointment_time == '16:00:00' ? 'selected' : '' ?>>4:00 PM</option>
                            <option value="17:00" <?= isset($appointment_time) && $appointment_time == '17:00:00' ? 'selected' : '' ?>>5:00 PM</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h2 class="form-title">Contacts</h2>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" value="<?= $email ?? '' ?>" required <?= $status != 0 ? 'disabled' : ''?>>
                    </div>
                    <div class="col-md-6">
                        <label for="phoneNumber" class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control" id="phoneNumber" value="<?= $phone ?? '' ?>" required <?= $status != 0 ? 'disabled' : ''?>>
                    </div>
                </div>
            </div>

            <?php if($status == 0): ?>
            <div class="button-container">
                  <button type="button" class="btn btn-primary add-btn" data-status="1">Book an Appointment Now!</button>
                  <!-- <button type="button" class="btn btn-outline-primary add-btn" data-status="0">Save As Draft</button> -->
              </div>
            <?php endif; ?>
        </form>
    </div>

    <script src="Appointment.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
    $('.add-btn').on('click', function(){
        const status = $(this).data('status')
        let action = 'add_appointment'

        let formData = $('#appointment-form').serializeArray()

        formData.push({ name: 'status', value: status })

        let appointment_id = <?= $_GET['id'] ?? 0 ?> 

        if(appointment_id != 0){
            action = 'update_appointment'
            formData.push({ name: 'appointment_id', value: appointment_id })
        }

        const payment = $('#paymentType').val()

        console.log(action)

        $.ajax({
            url:'../backend/ajax.php?action='+action,
            method:'POST',
            data:formData,
            beforeSend: function() {
                Swal.fire({
                    icon: "info",
                    title: "Please wait...",
                    timer: 60000,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success:function(resp){
                console.log(resp)
                resp = JSON.parse(resp)
                if(resp.status === 'error') {
                    Swal.fire({
                        icon: 'error',
                        text: resp.message,
                        heightAuto: false
                    });
                } else if(resp.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        text: resp.message,
                        heightAuto: false
                    }).then(function(){
                        window.location.href = './profile.php';
                    })
                } else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops something went wrong.',
                        heightAuto: false
                    });
                }
            }
        }) 
    })
</script>
</html>
