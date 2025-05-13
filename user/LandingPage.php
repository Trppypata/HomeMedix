<?php
session_start();
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
    <link rel="stylesheet" href="LandingPage.css">
    <title>Home - HomeMedix</title>
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
                <?php if (isset($_SESSION['id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="Profile.php">Hello <?= $_SESSION['fname'] ?></a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
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
            <h3 style="background-color: #5ce1e6;">Hope & Healy</h3>
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

        <div class="container-fluid">
            <div class="row container-xxl">
                <div class="col container-lg">
                    <div class="text-container text-center">
                        <h1><span class="blue">Welcome to HomeMedix!</span></h1>
                        <p>Your trusted partner in quality caregiving, physical therapy, and nursing home services.
                            At Homemedix, we are committed to providing compassionate, personalized care that helps you or your loved ones live healthier, more comfortable lives. Whether you're seeking rehabilitation, assistance with daily tasks, or long-term support, our team of dedicated experts is here to make every day a little easier.</p>
                        <div class="button-container">
                            <a href="Appointment.php">
                                <button type="button" class="btn btn-primary">Book an Appointment Now!</button>
                            </a>
                            <a href="ContactUs.php">
                                <button type="button" class="btn btn-outline-primary">Contact Us</button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col container-lg">
                    <img src="img/Therapist.png" alt="Medical Professional" style="width: 500px; height: 550px;">
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row borderless-container-xxl">
            <div class="text-container text-center">
                <h1>Why Should You <span class="blue">Choose Us</span>?</h1>
            </div>

            <div class="col">
                <div class="container-lg" style="background-color: #004AAD; border-radius: 20px; box-shadow: 0px 4px 8px rgba(0.3,0.3,0.3,0.3);">
                    <div class="sign-container animated-card">
                        <img src="img/Excellent_Expert.png" alt="Medical Professional" style="width: 150px; height: 150px; border-radius: 100%;">
                    </div>
                    <div class="text-container animated-card">
                        <h4 style="color: white;"><strong>Excellent Expertise</strong></h4>
                        <p style="color: white;">Homemedix delivers top-tier expertise, ensuring every patient receives care from certified professionals who prioritize health and well-being. Their skilled team stays updated with the latest medical knowledge, providing quality services tailored to individual needs.</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="container-lg" style="background-color: #5271ff; border-radius: 20px; box-shadow: 0px 4px 8px rgba(0.3,0.3,0.3,0.3);">
                    <div class="sign-container animated-card">
                        <img src="img/247_Care.png" alt="Medical Professional" style="width: 150px; height: 150px; border-radius: 100%;">
                    </div>
                    <div class="text-container animated-card">
                        <h4 style="color: white;"><strong>24/7 Patient Care</strong></h4>
                        <p style="color: white;">Homemedix provides round-the-clock care, ensuring patients receive continuous support and attention at any hour of the day or night. This 24/7 availability helps meet the unique needs of each individual, promoting comfort, safety, and peace of mind for both patients and their families.</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="container-lg" style="background-color: #38b6ff; border-radius: 20px; box-shadow: 0px 4px 8px rgba(0.3,0.3,0.3,0.3);">
                    <div class="sign-container animated-card">
                        <img src="img/Reputable_Service.png" alt="Medical Professional" style="width: 150px; height: 150px; border-radius: 100%;">
                    </div>
                    <div class="text-container animated-card">
                        <h4 style="color: white;"><strong>Reputable Services</strong></h4>
                        <p style="color: white;">Homemedix offers trusted healthcare, connecting patients with licensed experts committed to compassionate and personalized care. Their dedicated professionals leverage modern practices to deliver quality services, addressing each patient's unique health needs.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row borderless-container-xxl ">
            <div class="col container-lg animated-card">
                <div class="text-container">
                    <h1><span class="blue">Quality Care</span> Starts With <span class="blue">Quality Expertise</span></h1>
                    <p>Homemedix provides high-quality care because they prioritize selecting top-tier professionals in physical therapy, caregiving, and nursing home services. By choosing experts with advanced training, experience, and dedication to patient-centered care, they ensure that every client receives personalized attention and effective treatments. Their commitment to quality experts translates into better outcomes, whether it's in rehabilitation, long-term care, or day-to-day assistance. This focus on skilled professionals allows Homemedix to consistently meet the needs of patients and families, fostering trust and enhancing the overall care experience.</p>
                </div>
            </div>
            <div class="col container-lg animated-card">
                <img src="img/Therapy2.jpg" alt="Medical Professional" style="width: 850px; height: 600px; border-radius: 20px;">
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row borderless-container-xxl">
            <div class="text-container text-center">
                <h1><span class="bordered-blue">HomeMedix</span> <span class="blue">Services</span></h1>
            </div>

            <div class="col container-lg">
                <a href="#" class="card-link">
                    <div class="card" style="width: 18rem;">
                        <img src="img/PhysicalTherapy.jpeg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Physical Therapy</h5>
                            <p class="card-text">Expert physical therapists provide personalized care for mobility and recovery.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col container-lg">
                <a href="#" class="card-link">
                    <div class="card" style="width: 18rem;">
                        <img src="img/Caregiving.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Caregiving Services</h5>
                            <p class="card-text">Expert caregivers providing compassionate, personalized care for seniors and patients.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col container-lg">
                <a href="#" class="card-link">
                    <div class="card" style="width: 18rem;">
                        <img src="img/NursingHome.jpeg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Nursing Home</h5>
                            <p class="card-text">Expert nursing care with compassion, personalized support, and trusted service.</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>



    <div class="blue-container-fluid">
        <div class="custom-shape-divider-top-1729530239">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="shape-fill"></path>
            </svg>
        </div>
        <div class="row borderless-container-xxl" style="background-image: linear-gradient(#38b6ff, #38b6ff)" ;>
            <div class="col container-lg animated-card">
                <div class="text-container text-center white-text">
                    <h1>Physical Therapy</h1>
                    <p>At HomeMedix, we are dedicated to enhancing your quality of life through personalized physical therapy services delivered in the comfort of your home. Our team of skilled therapists specializes in a wide range of conditions, ensuring you receive tailored care that meets your unique needs.</p>
                </div>
            </div>
            <div class="col container-lg animated-card">
                <img src="img/PhysicalTherapy2.jpeg" alt="picture-container">
            </div>
        </div>
    </div>

    <div class="blue-container-fluid">
        <div class="row borderless-container-xxl" style="background-image: linear-gradient( #38b6ff, #3867ff, #3867ff)">
            <div class="col container-lg animated-card">
                <img src="img/Caregiving.png" alt="picture-container">
            </div>

            <div class="col container-lg animated-card">
                <div class="text-container text-center white-text">
                    <h1>Caregiving Services</h1>
                    <p>At HomeMedix, we understand that every individual has unique needs when it comes to caregiving. Our compassionate team is dedicated to providing high-quality, personalized care in the comfort of your home, allowing you or your loved ones to maintain independence while receiving the support necessary for a fulfilling life.</p>
                </div>
            </div>

        </div>
    </div>

    <div class="blue-container-fluid">
        <div class="row borderless-container-xxl" style="background-image: linear-gradient(#3867ff, #004aad, #004aad)" ;>
            <div class="col container-lg animated-card">
                <div class="text-container text-center white-text">
                    <h1>Nursing Home</h1>
                    <p>At HomeMedix, we are committed to providing exceptional nursing home services designed to deliver compassionate, comprehensive care in a nurturing environment. Our facility is dedicated to enhancing the quality of life for our residents, ensuring their physical, emotional, and social needs are met with dignity and respect.</p>
                </div>
            </div>
            <div class="col container-lg animated-card">
                <img src="img/NursingHome2.jpg" alt="picture-container">
            </div>
        </div>

        <div class="custom-shape-divider-bottom-1729533122">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
            </svg>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row borderless-container-xxl">
            <div class="text-container text-center">
                <h1>Our <span class="blue">Expert Practitioners</span></h1>
                <p class="text-center">Homemedix's expert practitioners consist of highly qualified physical therapists, caregivers, and nursing professionals who are dedicated to providing exceptional in-home care. Their team is known for its commitment to personalized treatment plans and compassionate service, ensuring each patient receives the highest quality of care tailored to their specific needs.</p>
            </div>

            <div class="col picture-container animated-card">
                <img src="img/Practitioners2.png" alt="picture-container">
            </div>

            <div class="col picture-container animated-card">
                <img src="img/Practitioners1.png" alt="picture-container">
            </div>

            <div class="col picture-container animated-card">
                <img src="img/Practitioners3.png" alt="picture-container">
            </div>

            <div class="col picture-container animated-card">
                <img src="img/Practitioners5.png" alt="picture-container">
            </div>

            <div class="col picture-container animated-card">
                <img src="img/Practitioners4.png" alt="picture-container">
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row borderless-container-xxl">
            <div class="col review-container animated-card">
                <div class="text-container text-center">
                    <h1><span class="blue">Customer Reviews</span></h1>
                    <p>Check our customers' insights about our service</p>
                </div>
                <div class="card-container">
                    <div class="review-card">
                        <div class="customer-info">
                            <div class="avatar"></div>
                            <div class="customer-name">Chris Evans</div>
                        </div>

                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>

                        <div class="review-text">
                            <p>Homemedix provided exceptional care and support, making recovery comfortable and stress-free.</p>
                        </div>

                        <div class="emojis">
                            <i class="fas fa-thumbs-up"></i>
                            <i class="far fa-comment"></i>
                        </div>
                    </div>

                    <div class="review-card">
                        <div class="customer-info">
                            <div class="avatar"></div>
                            <div class="customer-name">Mike Stephens</div>
                        </div>

                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>

                        <div class="review-text">
                            <p>The caregivers from Homemedix were professional, kind, and truly dedicated to improving my loved one's quality of life.</p>
                        </div>

                        <div class="emojis">
                            <i class="fas fa-thumbs-up"></i>
                            <i class="far fa-comment"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col container-lg animated-card">
                <img src="img/old-peeps.jpg" alt="Medical Professional" style="width: 100%; border-radius: 20px;">
            </div>

        </div>
    </div>

    <div class="container-fluid">
        <div class="row borderless-container-xxl">
            <div class="col container-lg animated-card">
                <img src="img/NursingHome2.jpg" alt="picture-container" style="width: 100%; border-radius: 20px;">
            </div>
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

        </div>
    </div>

    <div class="container-fluid">
        <div class="row borderless-container-xxl">
            <div class="text-container text-center">
                <h1><span class="bordered-blue">HMO</span> <span class="blue">Accredited Partners</span></h1>
            </div>
            <div class="col container-lg animated-card">
                <img src="img/AmaphilLogo.png" alt="Medical Professional" style="width: 300px; height: 100px;">
            </div>
            <div class="col container-lg animated-card">
                <img src="img/SunlifeGrepaLogo.png" alt="Medical Professional" style="width: 200px; height: 150px;">
            </div>
            <div class="col container-lg animated-card">
                <img src="img/WellCareLogo.jpg" alt="Medical Professional" style="width: 250px; height: 100px;">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="home.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const animatedCards = document.querySelectorAll(".animated-card");

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("show");
                        observer.unobserve(entry.target); // Stop observing once animation is triggered
                    }
                });
            }, {
                threshold: 0.1
            });

            animatedCards.forEach(card => observer.observe(card));
        });
    </script>
    
    <!-- HomeMedix Chatbot -->
    <script src="../assets/js/chatbot.js"></script>

</body>

</html>