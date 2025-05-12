<?php 
require_once('../backend/function.php');
if(!isset($_SESSION['role']) && $_SESSION['role'] != 0){
  header("location: ../login.php");
  exit;
}

$role = 1;
if(isset($_GET['role'])){
  $role = $_GET['role'];

  if($role != '0' && $role != '1' && $role != '2' && $role != '3'){
    $role = 1;
  }
}
?>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Admin_Records.css">
    <title>User Records - Admin</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar">
        <div class="logo-container">
          <img src="img/logo.png" alt="Logo" class="logo">
        </div>
        <ul>
          <li>
            <a href="Admin_Dashboard.php">
              <i class="fas fa-home"></i>Dashboard </a>
          </li>
          <li>
            <a href="Admin_PatientRecord.php">
              <i class="fas fa-bed"></i>Our Patients </a>
          </li>
          <li>
            <a href="Admin_UserRecord.php?role=2">
              <i class="fas fa-user-doctor"></i>Therapists </a>
          </li>
          <li>
            <a href="Admin_UserRecord.php?role=3">
              <i class="fas fa-user-nurse"></i>Caregivers </a>
          </li>
          <li>
            <a href="Admin_UserRecord.php?role=1">
              <i class="fas fa-user"></i>User Accounts </a>
          </li>
          <li>
            <a href="Admin_UserRecord.php?role=0">
              <i class="fas fa-user-tie"></i>Admin </a>
          </li>
          <li>
            <a href="Admin_AppointmentRecord.php">
              <i class="fas fa-calendar"></i>Appointments </a>
          </li>
          <li>
            <a href="Admin_Inbox.php">
              <i class="fas fa-envelope"></i>Inbox - Contact Us </a>
          </li>
        </ul>
        <div class="logout-container">
          <a href="../backend/ajax.php?action=logout" class="ms-3 p-0 w-100"><button class="btn btn-outline-danger btn-logout">Log Out</button></a>
        </div>
      </div>

      <!-- Main Content -->
      <div class="main_content">
        <div class="header d-flex justify-content-end align-items-center">

            <button class="btn btn-light notification-btn">
                <span class="material-symbols-outlined">notifications</span>
                <span class="notification-badge">3</span>
            </button>

          <h6>Admin <span class="bordered-blue"><?= $_SESSION['fname'] . ' ' . $_SESSION['lname'] ?></span>
          </h6>
        </div>
        <div class="info">
          <div class="container-fluid">
            <div class="container">
              <div class="banner-container">
                <img src="img/Admin_Users.png" alt="Banner">
              </div>
              <div class="container mt-4">
                <div class="row align-items-center">
                  <div class="col-md-8">
                    <div class="text-container">
                      <h1>HomeMedix <span class="bordered-blue"><?= getRole($role) ?></span>
                      </h1>
                    </div>
                  </div>
                  <div class="col-md-4 text-md-end">
                    <div class="button-container  d-flex justify-content-end">
                      <button type="button" id="add-btn" class="btn btn-info d-flex align-items-center">
                        <img src="img/Add.png" alt="Icon">
                        <h4 class="white-text">Add <?= substr(getRole($role), 0, -1) ?></h4>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="table-container">
                <div class="p-3 rounded-4 shadow">
                  <table class="table table-striped text-center table-hover">
                    <thead>
                      <tr>
                        <th>User ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone Number</th>
                        <th>Email Address</th>
                        <?php if($role == 2): ?>
                          <th>Specialization</th>
                        <?php endif; ?>
                        <?php if($role == 3 || $role == 2): ?>
                          <th>Hire Date</th>
                        <?php endif; ?>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        $users = getUsersByRole($role); 
                        foreach($users as $user):
                      ?>
                      <tr>
                        <td><?= $user['user_id'] + 100 ?></td>
                        <td><?= $user['fname']?></td>
                        <td><?= $user['lname']?></td>
                        <td><?= $user['phone']?></td>
                        <td><?= $user['email']?></td>
                        <?php if($role == 2): ?>
                          <td><?= $user['specialization']?></td>
                        <?php endif; ?>
                        <?php if($role == 3 || $role == 2): ?>
                          <td><?= $user['hire_date']?></td>
                        <?php endif; ?>
                        <td>
                            <button type="button" data-id="<?= $user['user_id'] ?>"
                                                  data-fname="<?= $user['fname'] ?>"
                                                  data-lname="<?= $user['lname'] ?>"
                                                  data-phone="<?= $user['phone'] ?>"
                                                  data-email="<?= $user['email'] ?>"
                                                  <?php if($role == 2 || $role == 3): ?>
                                                  data-specialization="<?= $user['specialization'] ?>"
                                                  data-hire="<?= $user['hire_date'] ?>"
                                                  <?php endif; ?>
                             class="btn btn-primary edit-btn">
                                <span class="material-symbols-outlined">edit</span>
                            </button>

                            <button type="button" data-id="<?= $user['id'] ?>" class="btn btn-danger del-btn">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
    </div>

    <div class="modal fade user-modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="user-form">
                <div class="modal-body">
                    <input type="hidden" id="user_id" name="user_id">
                    <input type="hidden" id="role" name="role" value="<?= $role ?>">
                    <div class="mb-3">
                        <label>First Name</label>
                        <input type="text" id="fname" name="fname" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Last Name</label>
                        <input type="text" id="lname" name="lname" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" id="phone" name="phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" id="email" name="email" class="form-control">
                    </div>
                    <?php if($role == 2): ?>
                    <div class="mb-3">
                        <label>Specialization</label>
                        <input type="text" id="specialization" name="specialization" class="form-control">
                    </div>
                    <?php endif; ?>
                    <?php if($role == 3 || $role == 2): ?>
                    <div class="mb-3">
                        <label>Hire Date</label>
                        <input type="date" id="hire_date" name="hire_date" class="form-control">
                    </div>
                    <?php endif; ?>
                    <div class="mb-3 add-field">
                        <label for="inputPassword5" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="mb-3 add-field">
                        <label for="inputPassword5" class="form-label">Re-enter Your Password</label>
                        <input type="password" name="cpassword" id="cpassword" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
  </body>
<script>
  $('#add-btn').on('click', function(){
    $('#user_id').val('')
    $('#fname').val('')
    $('#lname').val('')
    $('#email').val('')
    $('#phone').val('')
    $('#specialization').val('')
    $('#hire_date').val('')
    $('.add-field').show()

    $('.modal-title').text("Add <?= substr(getRole($role), 0, -1) ?>")
    $('.user-modal').modal('show')
  })

  $('.edit-btn').on('click', function(){
    const id = $(this).data('id')
    const fname = $(this).data('fname')
    const lname = $(this).data('lname')
    const email = $(this).data('email')
    const phone = $(this).data('phone')
    const specialization = $(this).data('specialization')
    const hire_date = $(this).data('hire')

    $('#user_id').val(id)
    $('#fname').val(fname)
    $('#lname').val(lname)
    $('#email').val(email)
    $('#phone').val(phone)
    $('#specialization').val(specialization)
    $('#hire_date').val(hire_date)
    $('.add-field').hide()

    $('.modal-title').text("Edit <?= substr(getRole($role), 0, -1) ?>")
    $('.user-modal').modal('show')
  })

  $('#user-form').submit(function(e){
    const user_id = $('#user_id').val()

    let action = user_id ? 'update_user' : 'signup'

    e.preventDefault()
    $.ajax({
        url:'../backend/ajax.php?action='+action,
        method:'POST',
        data:$(this).serialize(),
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
                        window.location.reload();
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

  $('.del-btn').on('click', function(){
    const user_id = $(this).data('id')

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if(result.isConfirmed){
            $.ajax({
                url:'../backend/ajax.php?action=delete_user',
                method:'POST',
                data:{ 'user_id': user_id },
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
                            title: resp.message,
                            heightAuto: false
                        });
                    } else if(resp.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: resp.message,
                            heightAuto: false
                        }).then(function(){
                            window.location.reload();
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
        }
    })
  })
</script>
</html>