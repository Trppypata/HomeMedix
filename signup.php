    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="login.css">
        <title>Sign Up - HomeMedix</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="user/LandingPage.php">
                    <img src="user/img/logo.png" alt="Bootstrap" width="150" height="75">
                </a>
                <div class="d-flex">
                    <div class="navbar-nav">
                        <a class="nav-link" aria-current="page" href="index.php">Log In</a>
                        <a class="nav-link" href="signup.php">Sign Up</a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="marquee-container-fluid">
            <div class="marquee-left">
                <h3 style="background-color: #004AAD;">HomeMedix</h3>
                <h3 style="background-color: #5271ff;">HomeMedix</h3>
                <h3 style="background-color: #38b6ff;">HomeMedix</h3>
                <h3 style="background-color: #004AAD;">HomeMedix</h3>
                <h3 style="background-color: #5271ff;">HomeMedix</h3>
                <h3 style="background-color: #38b6ff;">HomeMedix</h3>
                <h3 style="background-color: #004AAD;">HomeMedix</h3>
                <h3 style="background-color: #5271ff;">HomeMedix</h3>
                <h3 style="background-color: #38b6ff;">HomeMedix</h3>
                <h3 style="background-color: #004AAD;">HomeMedix</h3>
                <h3 style="background-color: #5271ff;">HomeMedix</h3>
            </div>

            <div class="marquee-right" style="margin-top: 65px;">
                <h3 style="background-color: #0097b2;">We Care Like Family</h3>
                <h3 style="background-color: #0cc0df;">We Care Like Family</h3>
                <h3 style="background-color: #5ce1e6;">We Care Like Family</h3>
                <h3 style="background-color: #0097b2;">We Care Like Family</h3>
                <h3 style="background-color: #0cc0df;">We Care Like Family</h3>
                <h3 style="background-color: #5ce1e6;">We Care Like Family</h3>
                <h3 style="background-color: #0097b2;">We Care Like Family</h3>
                <h3 style="background-color: #0cc0df;">We Care Like Family</h3>
                <h3 style="background-color: #5ce1e6;">We Care Like Family</h3>
                <h3 style="background-color: #0097b2;">We Care Like Family</h3>
                <h3 style="background-color: #0cc0df;">We Care Like Family</h3>
            </div>

            <div class="marquee-left" style="margin-top: 130px;">
                <h3 style="background-color: #004AAD;">Physical Therapy</h3>
                <h3 style="background-color: #5271ff;">Physical Therapy</h3>
                <h3 style="background-color: #38b6ff;">Physical Therapy</h3>
                <h3 style="background-color: #004AAD;">Physical Therapy</h3>
                <h3 style="background-color: #5271ff;">Physical Therapy</h3>
                <h3 style="background-color: #38b6ff;">Physical Therapy</h3>
                <h3 style="background-color: #004AAD">Physical Therapy</h3>
                <h3 style="background-color: #5271ff;">Physical Therapy</h3>
                <h3 style="background-color: #38b6ff;">Physical Therapy</h3>
                <h3 style="background-color: #004AAD;">Physical Therapy</h3>
                <h3 style="background-color: #5271ff;">Physical Therapy</h3>
            </div>

            <div class="marquee-right" style="margin-top: 195px;">
                <h3 style="background-color: #0097b2;">Hope & Heal</h3>
                <h3 style="background-color: #0cc0df;">Hope & Heal</h3>
                <h3 style="background-color: #5ce1e6;">Hope & Heal</h3>
                <h3 style="background-color: #0097b2;">Hope & Heal</h3>
                <h3 style="background-color: #0cc0df;">Hope & Heal</h3>
                <h3 style="background-color: #5ce1e6;">Hope & Heal</h3>
                <h3 style="background-color: #0097b2;">Hope & Heal</h3>
                <h3 style="background-color: #0cc0df;">Hope & Heal</h3>
                <h3 style="background-color: #5ce1e6;">Hope & Heal</h3>
                <h3 style="background-color: #0097b2;">Hope & Heal</h3>
                <h3 style="background-color: #0cc0df;">Hope & Heal</h3>
            </div>

            <div class="marquee-left" style="margin-top: 260px;">
                <h3 style="background-color: #004AAD;">Caregiving</h3>
                <h3 style="background-color: #5271ff;">Caregiving</h3>
                <h3 style="background-color: #38b6ff;">Caregiving</h3>
                <h3 style="background-color: #004AAD;">Caregiving</h3>
                <h3 style="background-color: #5271ff;">Caregiving</h3>
                <h3 style="background-color: #38b6ff;">Caregiving</h3>
                <h3 style="background-color: #004AAD">Caregiving</h3>
                <h3 style="background-color: #5271ff;">Caregiving</h3>
                <h3 style="background-color: #38b6ff;">Caregiving</h3>
                <h3 style="background-color: #004AAD;">Caregiving</h3>
                <h3 style="background-color: #5271ff;">Caregiving</h3>
            </div>

            <div class="marquee-right" style="margin-top: 325px;">
                <h3 style="background-color: #0097b2;">Caring Heart</h3>
                <h3 style="background-color: #0cc0df;">Caring Heart</h3>
                <h3 style="background-color: #5ce1e6;">Caring Heart</h3>
                <h3 style="background-color: #0097b2;">Caring Heart</h3>
                <h3 style="background-color: #0cc0df;">Caring Heart</h3>
                <h3 style="background-color: #5ce1e6;">Caring Heart</h3>
                <h3 style="background-color: #0097b2;">Caring Heart</h3>
                <h3 style="background-color: #0cc0df;">Caring Heart</h3>
                <h3 style="background-color: #5ce1e6;">Caring Heart</h3>
                <h3 style="background-color: #0097b2;">Caring Heart</h3>
                <h3 style="background-color: #0cc0df;">Caring Heart</h3>
            </div>

            <div class="marquee-left" style="margin-top: 390px;">
                <h3 style="background-color: #004AAD;">Nursing Home</h3>
                <h3 style="background-color: #5271ff;">Nursing Home</h3>
                <h3 style="background-color: #38b6ff;">Nursing Home</h3>
                <h3 style="background-color: #004AAD;">Nursing Home</h3>
                <h3 style="background-color: #5271ff;">Nursing Home</h3>
                <h3 style="background-color: #38b6ff;">Nursing Home</h3>
                <h3 style="background-color: #004AAD">Nursing Home</h3>
                <h3 style="background-color: #5271ff;">Nursing Home</h3>
                <h3 style="background-color: #38b6ff;">Nursing Home</h3>
                <h3 style="background-color: #004AAD;">Nursing Home</h3>
                <h3 style="background-color: #5271ff;">Nursing Home</h3>
            </div>

            <div class="marquee-right" style="margin-top: 455px;">
                <h3 style="background-color: #0097b2;">Strength regained</h3>
                <h3 style="background-color: #0cc0df;">Strength regained</h3>
                <h3 style="background-color: #5ce1e6;">Strength regained</h3>
                <h3 style="background-color: #0097b2;">Strength regained</h3>
                <h3 style="background-color: #0cc0df;">Strength regained</h3>
                <h3 style="background-color: #5ce1e6;">Strength regained</h3>
                <h3 style="background-color: #0097b2;">Strength regained</h3>
                <h3 style="background-color: #0cc0df;">Strength regained</h3>
                <h3 style="background-color: #5ce1e6;">Strength regained</h3>
                <h3 style="background-color: #0097b2;">Strength regained</h3>
                <h3 style="background-color: #0cc0df;">Strength regained</h3>
            </div>

            <div class="marquee-left" style="margin-top: 520px;">
                <h3 style="background-color: #004AAD;">HomeMedix</h3>
                <h3 style="background-color: #5271ff;">HomeMedix</h3>
                <h3 style="background-color: #38b6ff;">HomeMedix</h3>
                <h3 style="background-color: #004AAD;">HomeMedix</h3>
                <h3 style="background-color: #5271ff;">HomeMedix</h3>
                <h3 style="background-color: #38b6ff;">HomeMedix</h3>
                <h3 style="background-color: #004AAD;">HomeMedix</h3>
                <h3 style="background-color: #5271ff;">HomeMedix</h3>
                <h3 style="background-color: #38b6ff;">HomeMedix</h3>
                <h3 style="background-color: #004AAD;">HomeMedix</h3>
                <h3 style="background-color: #5271ff;">HomeMedix</h3>
            </div>

            <div class="marquee-right" style="margin-top: 585px;">
                <h3 style="background-color: #0097b2;">We Care Like Family</h3>
                <h3 style="background-color: #0cc0df;">We Care Like Family</h3>
                <h3 style="background-color: #5ce1e6;">We Care Like Family</h3>
                <h3 style="background-color: #0097b2;">We Care Like Family</h3>
                <h3 style="background-color: #0cc0df;">We Care Like Family</h3>
                <h3 style="background-color: #5ce1e6;">We Care Like Family</h3>
                <h3 style="background-color: #0097b2;">We Care Like Family</h3>
                <h3 style="background-color: #0cc0df;">We Care Like Family</h3>
                <h3 style="background-color: #5ce1e6;">We Care Like Family</h3>
                <h3 style="background-color: #0097b2;">We Care Like Family</h3>
                <h3 style="background-color: #0cc0df;">We Care Like Family</h3>
            </div>
            <div class="marquee-left" style="margin-top: 650px;">
                <h3 style="background-color: #004AAD;">Physical Therapy</h3>
                <h3 style="background-color: #5271ff;">Physical Therapy</h3>
                <h3 style="background-color: #38b6ff;">Physical Therapy</h3>
                <h3 style="background-color: #004AAD;">Physical Therapy</h3>
                <h3 style="background-color: #5271ff;">Physical Therapy</h3>
                <h3 style="background-color: #38b6ff;">Physical Therapy</h3>
                <h3 style="background-color: #004AAD">Physical Therapy</h3>
                <h3 style="background-color: #5271ff;">Physical Therapy</h3>
                <h3 style="background-color: #38b6ff;">Physical Therapy</h3>
                <h3 style="background-color: #004AAD;">Physical Therapy</h3>
                <h3 style="background-color: #5271ff;">Physical Therapy</h3>
            </div>

            <div class="marquee-right" style="margin-top: 715px;">
                <h3 style="background-color: #0097b2;">Hope & Heal</h3>
                <h3 style="background-color: #0cc0df;">Hope & Heal</h3>
                <h3 style="background-color: #5ce1e6;">Hope & Heal</h3>
                <h3 style="background-color: #0097b2;">Hope & Heal</h3>
                <h3 style="background-color: #0cc0df;">Hope & Heal</h3>
                <h3 style="background-color: #5ce1e6;">Hope & Heal</h3>
                <h3 style="background-color: #0097b2;">Hope & Heal</h3>
                <h3 style="background-color: #0cc0df;">Hope & Heal</h3>
                <h3 style="background-color: #5ce1e6;">Hope & Heal</h3>
                <h3 style="background-color: #0097b2;">Hope & Heal</h3>
                <h3 style="background-color: #0cc0df;">Hope & Heal</h3>
            </div>

            <div class="marquee-left" style="margin-top: 780px;">
                <h3 style="background-color: #004AAD;">Caregiving</h3>
                <h3 style="background-color: #5271ff;">Caregiving</h3>
                <h3 style="background-color: #38b6ff;">Caregiving</h3>
                <h3 style="background-color: #004AAD;">Caregiving</h3>
                <h3 style="background-color: #5271ff;">Caregiving</h3>
                <h3 style="background-color: #38b6ff;">Caregiving</h3>
                <h3 style="background-color: #004AAD">Caregiving</h3>
                <h3 style="background-color: #5271ff;">Caregiving</h3>
                <h3 style="background-color: #38b6ff;">Caregiving</h3>
                <h3 style="background-color: #004AAD;">Caregiving</h3>
                <h3 style="background-color: #5271ff;">Caregiving</h3>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row container-xxl align-items-center">
                <div class="col-md-6 d-flex justify-content-center">
                    <img src="user/img/Therapist.png" alt="Therapist Image" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <div class="text-container">
                        <h1><span class="blue">Create An Account</span></h1>
                        <p>Sign up today and start your journey to experience the warmth and care of family, right at your fingertips.</p>
                    </div>
                    <form id="signup-form">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">First Name</label>
                            <input type="text" name="fname" class="form-control" id="FirstName" placeholder="Enter your First Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Last Name</label>
                            <input type="text" name="lname" class="form-control" id="LastName" placeholder="Enter your Last Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" id="PhoneNumber" placeholder="Enter your Phone Number" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="Enter your Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="inputPassword5" class="form-label">Password</label>
                            <input type="password" name="password" id="inputPassword5" class="form-control" placeholder="Enter your Password" required>
                        </div>
                        <div class="mb-3">
                            <label for="inputPassword5" class="form-label">Re-enter Your Password</label>
                            <input type="password" name="cpassword" id="ReenterPassword" class="form-control" placeholder="Enter your Password" required>
                        </div>
                        <div class="button-container">
                            <button type="submit" class="btn btn-primary">Sign Up</button>
                        </div>
                    </form>
                    <div class="text-container">
                        <p>Already Have An Account? <a href="./index.php"><span class="blue">Log In</span></a></p>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
        $('#signup-form').submit(function(e) {
            e.preventDefault()
            $.ajax({
                url: 'backend/ajax.php?action=signup',
                method: 'POST',
                data: $(this).serialize(),
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
                success: function(resp) {
                    console.log(resp)
                    resp = JSON.parse(resp)
                    if (resp.status === 'error') {
                        Swal.fire({
                            icon: 'error',
                            text: resp.message,
                            heightAuto: false
                        });
                    } else if (resp.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            text: resp.message,
                            heightAuto: false
                        }).then(function() {
                            window.location.href = './index.php';
                        })
                    } else {
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