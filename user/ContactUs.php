<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="ContactUs.css">
    
    <title>Contact Us - HomeMedix</title>
</head>
<body>
<nav class="navbar">
        <div class="navbar-container">
            <div class="logo-container">
                <img src="img/logo.png" alt="Logo" class="logo" />
            </div>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="LandingPage.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Services.php">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="PractitionersPage.php">Practitioners</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="AboutUs.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ContactUs.php">Contact Us</a>
                </li>
                <?php if(isset($_SESSION['id'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="Profile.php">Hello <?= $_SESSION['fname'] ?></a>
                </li>
                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="Login.php">Login</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    
    <div class="banner-container">
        <img src="img/ContactUsBanner.png" alt="banner-container">
        <div class="banner-text">
            <h1>Contact <span class="bordered-blue">HomeMedix</span></h1>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row borderless-container-xl" style="width: 76.5%; height: 100%;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m19!1m8!1m3!1d61766.65540388807!2d121.06670411645509!3d14.632313647807912!3m2!1i1024!2i768!4f13.1!4m8!3e0!4m0!4m5!1s0x3397b961a200631b%3A0xadaacd8ffd67d7e4!2sHomeMedix%20Physical%20Therapy%2C%20Caregiving%20%26%20Nursing%20Services%2C%20124%20A.%20Flores%20St%2C%20Marikina%2C%201804%20Metro%20Manila!3m2!1d14.636408!2d121.0916341!5e0!3m2!1sen!2sph!4v1729782241920!5m2!1sen!2sph" width="800" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row container-xxl">
            <div class="text-container text-center" style=" margin-top: 25px; margin-bottom: 25px;">
                <h1>Have questions?<span class="blue"> We're just a call away.</span></h1>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Full Name</label>
                <input type="name" class="form-control" id="name" placeholder=" ">
              </div>
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
              </div>
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Subject</label>
                <input type="subject" class="form-control" id="subject" placeholder=" ">
              </div>
              <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Message/ Concern</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
              </div>

              <div class="mb-3">
                
                            <!-- I'm not a robot-->
            <div class="g-recaptcha" data-sitekey="YOUR_SITE_KEY" data-callback="recaptchaCallback"></div>
              </div>

              <div class="mb-3">
                <button type="submit" id="submitButton" disabled>Submit</button>
              </div>
        </div>
    </div>

    <div class="custom-shape-divider-top-1729850021">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="shape-fill"></path>
        </svg>
    </div>

    <div class="container-fluid" style="background-image:linear-gradient(135deg, white, #38b6ff, #5271ff,#004aad); height: 70vh;">
        <div class="row" style="padding: 20px; z-index: 1;">
            <div class="col">
                <div class="card-container animated-card">
                    <div class="text-container text-center" style="margin-top: 25px; margin-bottom: 25px;">
                        <h4>You can <span class="blue">Contact Us</span> at:</h4>
                    </div>
                    <div class="list-container">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="icon-container">
                                    <i class="fa-solid fa-phone" style="color: #004aad;"></i>
                                </div>
                                <div class="ms-2 me-auto" style="width: 100%;">
                                    <div class="fw-bold">HomeMedix Phone Number</div>
                                    <p>0917 102 8250</p>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="icon-container">
                                    <i class="fa-solid fa-envelope" style="color: #004aad;"></i>
                                </div>
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">HomeMedix Email Address</div>
                                    <p>HomeMedix.ptcaregiving@gmail.com</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
    
            <div class="col">
                <div class="card-container animated-card">
                    <div class="text-container text-center" style="margin-top: 25px; margin-bottom: 25px;">
                        <h4>Stay <span class="blue">Connect</span> with us <span class="blue">Online</span></h4>
                    </div>
                    <div class="list-container">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <a href="https://www.facebook.com/share/6kcL2JAHYosonj3A/" class="list-group-item list-group-item-action">
                                    <div class="icon-container">
                                        <i class="fa-brands fa-square-facebook"></i>
                                    </div>
                                    <div class="ms-2 me-auto" style="width: 100%;">
                                        <div class="fw-bold">HomeMedix Physical Therapy, Caregiving & Nursing Services</div>
                                    </div>
                                </a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <a href="https://www.facebook.com/homemedixofficial?mibextid=ZbWKwL" class="list-group-item list-group-item-action">
                                    <div class="icon-container">
                                        <i class="fa-brands fa-square-facebook"></i>
                                    </div>
                                    <div class="ms-2 me-auto" style="width: 100%;">
                                        <div class="fw-bold">HomeMedix Official Account</div>
                                    </div>
                                </a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <a href="https://www.instagram.com/homemedix.ph?igsh=YWhqemthcmttd3ds" class="list-group-item list-group-item-action">
                                    <div class="icon-container">
                                        <i class="fa-brands fa-instagram"></i>
                                    </div>
                                    <div class="ms-2 me-auto" style="width: 100%;">
                                        <div class="fw-bold">HomeMedix Physical Therapy, Caregiving & Nursing Services</div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
    
            <div class="col">
                <div class="card-container animated-card">
                    <div class="text-container text-center" style="margin-top: 25px; margin-bottom: 25px;">
                        <h4><span class="blue">HomeMedix</span> Clinics</h4>
                    </div>
                    <div class="list-container">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">HomeMedix Physical Therapy, Caregiving & Nursing Services</div>
                                    <p>124 A. Flores St, Marikina, 1804 Metro Manila</p>
                                </div>
                                <span class="badge text-bg-success rounded-pill">Open 24 hours</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">HomeMedix Nursing Home for the Aged</div>
                                    <p>28 6th St, Marikina, 1807 Metro Manila</p>
                                </div>
                                <span class="badge text-bg-success rounded-pill">Open 24 hours</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">HomeMedix Nursing Home Malanday</div>
                                    <p>24 Sampaguita St, Marikina, 1805 Metro Manila</p>
                                </div>
                                <span class="badge text-bg-success rounded-pill ">Open 24 hours</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="custom-shape-divider-bottom-1729850465">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="shape-fill"></path>
        </svg>
    </div>
    
    <div class="container-fluid">
        <div class="row borderless-container-xxl">
            <div class="col col-container animated-card">
                <div class="text-container text-center">
                    <h1><span class="blue">Subscribe</span> To Our <span class="blue">Newsletter</span></h1>
                    <p class="text-center">Stay updated with our latest offers and promotions</p>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                </div>
                <div class="button-container">
                    <button class="btn btn-primary" style="width: 250px; height: 50px;">Subscribe</button>
                </div>
            </div>
            <div class="col col-container animated-card">
                <img src="img/NursingHome.jpeg" alt="..." style="width: 100%; border-radius: 20px;">
            </div>
        </div>
    </div>
    
    <!--footer-->
    <footer class="bg-light text-center text-lg-start">
        <div class="container p-4">
          <!-- Row -->
          <div class="row">
            <!-- Column 1 -->
            <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
              <h5 class="text-uppercase">About HomeMedix</h5>
              <p class="text-justify">
                HomeMedix is dedicated to providing quality in-home healthcare services, including physical therapy, caregiving, and nursing. We prioritize compassionate, personalized care to help individuals lead healthier lives.
              </p>
            </div>
            <!-- Column 2 -->
            <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
              <h5 class="text-uppercase">Quick Links</h5>
              <ul class="list-unstyled">
                <li><a href="LandingPage.php" class="text-dark">Home</a></li>
                <li><a href="Services.php" class="text-dark">Services</a></li>
                <li><a href="PractitionersPage.php" class="text-dark">Practitioners</a></li>
                <li><a href="AboutUs.php" class="text-dark">About Us</a></li>
                <li><a href="ContactUs.php" class="text-dark">Contact Us</a></li>
              </ul>
            </div>
            <!-- Column 3 -->
            <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
              <h5 class="text-uppercase">Contact Information</h5>
              <ul class="list-unstyled">
                <li><i class="fas fa-map-marker-alt"></i> <strong>124 A. Flores St, Marikina, 1804 Metro Manila</strong></li>
                <li><i class="fas fa-map-marker-alt"></i> <strong>28 6th St, Marikina, 1807 Metro Manila</strong></li>
                <li><i class="fas fa-map-marker-alt"></i><strong>24 Sampaguita St, Marikina, 1805 Metro Manila</strong></li>
                <li><i class="fas fa-phone"></i> 0917 102 8250</li>
                <li><i class="fas fa-envelope"></i> HomeMedix.ptcaregiving@gmail.com</li>
              </ul>
            </div>
          </div>

          <!-- Row End -->
        </div>
      
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: #f1f1f1;">
          © 2024 HomeMedix. All rights reserved.
        </div>
      </footer>

    <!-- HomeMedix Chatbot -->
    <script src="assets/js/chatbot.js"></script>
</body>
  <!-- Load Google's reCAPTCHA API -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script>
    // This function is called once the user successfully solves the CAPTCHA
    function recaptchaCallback() {
      document.getElementById("submitButton").disabled = false;
    }

    // Optionally, you can disable the button if the CAPTCHA expires or is incomplete
    function recaptchaExpired() {
      document.getElementById("submitButton").disabled = true;
    }
  </script>
  <script>
    function isElementInViewport(el) {
        const rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    function handleScroll() {
        const cards = document.querySelectorAll('.animated-card');
        cards.forEach(card => {
            if (isElementInViewport(card)) {
                card.classList.add('visible');
            }
        });
    }

    window.addEventListener('scroll', handleScroll);

    window.addEventListener('load', handleScroll);
</script>

</html>