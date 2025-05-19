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
    <link rel="stylesheet" href="Services.css">
    <title>Services - HomeMedix</title>
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
            <img src="img/ServicesBanner.png" alt="banner-container">
            <div class="banner-text">
                <h1>HomeMedix <span class="bordered-blue">Services</span></h1>
            </div>
        </div>

        <section class="services" id="services">
            <div class="heading">
                <h1><span class="bordered-blue">Physical Therapy</span> Services</h1>
            </div>

            <div class="box-container container">
                <div class="box card">
                    <img src="img/lowbackpain.png" class="card-img" alt="Low Back Pain Image">
                    <div class="card-body">
                        <h3 class="card-title">Low Back Pain</h3>
                        <p class="card-subtitle">Hot Moist Pack</p>
                        <p class="card-text">A therapeutic method using heat and moisture to relieve pain and relax muscles in the lower back.</p>
                    </div>
                </div>
        
                <div class="box card">
                    <img src="img/stroke.png" class="card-img" alt="Stroke Image">
                    <div class="card-body">
                        <h3 class="card-title">Stroke</h3>
                        <p class="card-subtitle">PNF exercises</p>
                        <p class="card-text">Proprioceptive Neuromuscular Facilitation (PNF) exercises involve stretching and strengthening techniques to improve motor function and coordination after a stroke.</p>
                    </div>
                </div>
    
                <div class="box card">
                    <img src="img/spinalcordinjury.png" class="card-img" alt="Spinal Cord Injury Image">
                    <div class="card-body">
                        <h3 class="card-title">Spinal Cord Injury</h3>
                        <p class="card-subtitle">Bed mobility exercise</p>
                        <p class="card-text">Exercises designed to enhance movement and independence in bed for individuals with spinal cord injuries.</p>
                    </div>
                </div>
    
                <div class="box card">
                    <img src="img/frozenshoulder.png" class="card-img" alt="Frozen Shoulder Image">
                    <div class="card-body">
                        <h3 class="card-title">Frozen Shoulder</h3>
                        <p class="card-subtitle">Joint mobilization</p>
                        <p class="card-text">A technique that involves moving the shoulder joint in specific ways to improve range of motion and reduce stiffness.</p>
                    </div>
                </div>
    
                <div class="box card">
                    <img src="img/deconditioning.png" class="card-img" alt="Deconditioning Image">
                    <div class="card-body">
                        <h3 class="card-title">Deconditioning</h3>
                        <p class="card-subtitle">Strengthening and Endurance exercise</p>
                        <p class="card-text">A regimen of exercises aimed at rebuilding muscle strength and cardiovascular endurance following a period of inactivity.</p>
                    </div>
                </div>
    
                <div class="box card">
                    <img src="img/pneumonia.png" class="card-img" alt="Pneumonia Image">
                    <div class="card-body">
                        <h3 class="card-title">Pneumonia</h3>
                        <p class="card-subtitle">Chest tapping and postural drainage</p>
                        <p class="card-text">Techniques used to clear mucus from the lungs by tapping on the chest and positioning the body to facilitate drainage.</p>
                    </div>
                </div>
                
                <div class="box card">
                    <img src="img/myocardial.png" class="card-img" alt="Myocardial Infarction Image">
                    <div class="card-body">
                        <h3 class="card-title">Myocardial Infarction</h3>
                        <p class="card-subtitle">Endurance exercise</p>
                        <p class="card-text">Low to moderate-intensity physical activities designed to improve cardiovascular health and endurance after a heart attack.</p>
                    </div>
                </div>
    
                <div class="box card">
                    <img src="img/peripheral.png" class="card-img" alt="Peripheral Vascular Diseases Image">
                    <div class="card-body">
                        <h3 class="card-title">Peripheral Vascular Diseases</h3>
                        <p class="card-subtitle">Ambulation</p>
                        <p class="card-text">Walking exercises that promote circulation and improve blood flow in individuals with peripheral vascular disease.</p>
                    </div>
                </div>
    
                <div class="box card">
                    <img src="img/carpal.png" class="card-img" alt="Carpal Tunnel Syndrome Image">
                    <div class="card-body">
                        <h3 class="card-title">Carpal Tunnel Syndrome</h3>
                        <p class="card-subtitle">Ultrasound and TENS (Electrotherapy)</p>
                        <p class="card-text">Therapeutic modalities using ultrasound and Transcutaneous Electrical Nerve Stimulation (TENS) to alleviate pain and promote healing in the wrist.</p>
                    </div>
                </div>
    
                <div class="box card">
                    <img src="img/osteo.png" class="card-img" alt="Osteoarthritis Image">
                    <div class="card-body">
                        <h3 class="card-title">Osteoarthritis</h3>
                        <p class="card-subtitle">Closed Kinematic chain exercises</p>
                        <p class="card-text">Weight-bearing exercises that involve movements where the distal segment (foot or hand) is fixed, aimed at strengthening muscles around the affected joints while minimizing stress.</p>
                    </div>
                </div>
    
            </div>
        </section>

        <section class="services" id="services">
            <div class="heading">
                <h1><span class="bordered-blue">Physical Therapy</span> Services</h1>
            </div>
        
            <div class="box-container container">
                <div class="box card">
                    <img src="img/8hour.png" class="card-img" alt="Caregiver 8-Hour Shift">
                    <div class="card-body">
                        <h3 class="card-title">Caregiver</h3>
                        <h3 class="card-title">(8-Hour Shift)</h3>
                        <p class="card-text">A caregiver who provides personal care and assistance to individuals for a standard 8-hour period, typically covering daily activities such as bathing, grooming, and meal preparation.</p>
                    </div>
                </div>
        
               
                <div class="box card">
                    <img src="img/12hour.png" class="card-img" alt="Caregiver 12-Hour Shift">
                    <div class="card-body">
                        <h3 class="card-title">Caregiver</h3>
                        <h3 class="card-title">(12-Hour Shift)</h3>
                        <p class="card-text">A caregiver who works for 12 hours at a time, offering extensive support and care to clients, often involved in more complex tasks and providing continuous monitoring and assistance.</p>
                    </div>
                </div>
        
              
                <div class="box card">
                    <img src="img/24hour.png" class="card-img" alt="Caregiver 24-Hour Shift">
                    <div class="card-body">
                        <h3 class="card-title">Caregiver</h3>
                        <h3 class="card-title">(24-Hour Shift)</h3>
                        <p class="card-text">A caregiver who is responsible for providing round-the-clock care for a full day, ensuring that the individual receives constant support, supervision, and assistance with daily living activities.</p>
                    </div>
                </div>
        
            </div>
        </section>

        <section class="services" id="services">
            <div class="heading">
                <h1><span class="bordered-blue">Physical Therapy</span> Services</h1>
            </div>

            <div class="box-container container">

                <div class="box card">
                    <img src="img/nursingcare.png" class="card-img" alt="Nursing Care">
                    <div class="card-body">
                        <h3 class="card-title">Nursing Care</h3>
                        <p class="card-text">Includes licensed nurses providing services like assessment, planning, intervention, evaluation, and emotional support tailored to patients' needs.</p>
                    </div>
                </div>
    
            </div>
        </section>

        <section>
            <div class="book-banner-container">
                <img src="img/booknowBanner.png" alt="banner-container">
                    <div class="book-text text-center">
                        <h1><span class="blue">Ready to</span> <span class="blue">Book Your Service?</span></h1>
                        <p class="book-description">we Care like Family.</p>

                        <a href="Appointment.php">
                            <button type="button" class="btn btn-primary">Book an Appointment Now!</button>
                          </a>
                    </div>
                </div> 
        </section>

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
                <li><a href="#!" class="text-dark">About Us</a></li>
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
    <script src="../assets/js/chatbot.js"></script>
</body>
</html>