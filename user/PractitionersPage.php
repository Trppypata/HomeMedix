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
    <link rel="stylesheet" href="PractitionersPage.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="styles.css">
    <title>Practitioners - HomeMedix</title>
</head>

<body>

    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo-container">
                <img src="img/logo.png" alt="Logo" class="logo" />
            </div>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="./LandingPage.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./Services.php">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./PractitionersPage.php">Practitioners</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./AboutUs.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./ContactUs.php">Contact Us</a>
                </li>
                <?php if (isset($_SESSION['id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./Profile.php">Hello <?= $_SESSION['fname'] ?></a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="banner-container">
        <img src="img/PractitionerBanner.png" alt="banner-container">
        <div class="banner-text">
            <h1>Meet our <span class="bordered-blue">Practitioners</span></h1>
        </div>
    </div>

    <div class="container-fluid">
        <div class="text-container text-center">
            <h1>Our <span class="blue">Physical Therapists</span></h1>
        </div>
        <div class="row borderless-container-xxl">
            <div class="col picture-container">
                <img src="img/Practitioners2.png" alt="picture-container">
            </div>

            <div class="col picture-container">
                <img src="img/Practitioners1.png" alt="picture-container">
            </div>

            <div class="col picture-container">
                <img src="img/Practitioners3.png" alt="picture-container">
            </div>

            <div class="col picture-container">
                <img src="img/Practitioners5.png" alt="picture-container">
            </div>

            <div class="col picture-container">
                <img src="img/Practitioners4.png" alt="picture-container">
            </div>
        </div>

        <div class="row borderless-container-xxl">
            <div class="col picture-container">
                <img src="img/Practitioners2.png" alt="picture-container">
            </div>

            <div class="col picture-container">
                <img src="img/Practitioners1.png" alt="picture-container">
            </div>

            <div class="col picture-container">
                <img src="img/Practitioners3.png" alt="picture-container">
            </div>

            <div class="col picture-container">
                <img src="img/Practitioners5.png" alt="picture-container">
            </div>

            <div class="col picture-container">
                <img src="img/Practitioners4.png" alt="picture-container">
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="text-container text-center">
            <h1>Our <span class="blue">Caregivers</span></h1>
        </div>
        <div class="row borderless-container-xxl">
            <div class="col picture-container">
                <img src="img/Practitioners2.png" alt="picture-container">
            </div>

            <div class="col picture-container">
                <img src="img/Practitioners1.png" alt="picture-container">
            </div>

            <div class="col picture-container">
                <img src="img/Practitioners3.png" alt="picture-container">
            </div>

            <div class="col picture-container">
                <img src="img/Practitioners5.png" alt="picture-container">
            </div>

            <div class="col picture-container">
                <img src="img/Practitioners4.png" alt="picture-container">
            </div>
        </div>

        <div class="row borderless-container-xxl">
            <div class="col picture-container">
                <img src="img/Practitioners2.png" alt="picture-container">
            </div>

            <div class="col picture-container">
                <img src="img/Practitioners1.png" alt="picture-container">
            </div>

            <div class="col picture-container">
                <img src="img/Practitioners3.png" alt="picture-container">
            </div>

            <div class="col picture-container">
                <img src="img/Practitioners5.png" alt="picture-container">
            </div>

            <div class="col picture-container">
                <img src="img/Practitioners4.png" alt="picture-container">
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="text-container text-center">
            <h1>Our <span class="blue">Nurses</span></h1>
        </div>
        <div class="row borderless-container-xxl">
            <div class="col picture-container">
                <img src="img/Practitioners2.png" alt="picture-container">
            </div>

            <div class="col picture-container">
                <img src="img/Practitioners1.png" alt="picture-container">
            </div>

            <div class="col picture-container">
                <img src="img/Practitioners3.png" alt="picture-container">
            </div>

            <div class="col picture-container">
                <img src="img/Practitioners5.png" alt="picture-container">
            </div>

            <div class="col picture-container">
                <img src="img/Practitioners4.png" alt="picture-container">
            </div>
        </div>

        <div class="row borderless-container-xxl">
            <div class="col picture-container">
                <img src="img/Practitioners2.png" alt="picture-container">
            </div>

            <div class="col picture-container">
                <img src="img/Practitioners1.png" alt="picture-container">
            </div>

            <div class="col picture-container">
                <img src="img/Practitioners3.png" alt="picture-container">
            </div>

            <div class="col picture-container">
                <img src="img/Practitioners5.png" alt="picture-container">
            </div>

            <div class="col picture-container">
                <img src="img/Practitioners4.png" alt="picture-container">
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

</html>