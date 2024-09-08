<?php
/*
    Name: Shutirtha Roy
    Student ID: 105008711
    Course: COS80021 Web Application Development
    Function: This file is used to show the User Interface when the user registers.
    Further it is also a dashboard which can be used to redirect to the request page. 
*/

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
     header("location: ../account/login.php");
     exit;
}

$name = $_SESSION['name'];
$customer_number = $_SESSION['customer_number'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to ShipOnline - Start Your Shipment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/css/pre-request.shipment.css">
</head>
<body>
    <?php 
    
        require '../common/nav.php';
    
        if (isset($_SESSION['just_registered'])) {
            $showConfirmation = true;
            // Remove the flag so the message won't be shown again

            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Registration Successful!</h4>
                <p>Dear <strong>' . 
                $name . 
                '</strong>, you are successfully registered into ShipOnline, 
                and your customer number is <strong>' . $customer_number . 
                '</strong>, which will be used to get into the system.</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';


            unset($_SESSION['just_registered']);
        }
    
    
    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="welcome-section">
                    <h2 class="text-center mb-4">Welcome to Your ShipOnline Dashboard</h2>
                    <p class="lead text-center mb-5">Ready to send your package? Start your shipment now and enjoy our fast, reliable service!</p>
                    
                    <div class="row mb-5">
                        <div class="col-md-4 text-center mb-3">
                            <div class="feature-icon mb-2">
                                <i class="bi bi-clock"></i>
                            </div>
                            <h5>Quick Processing</h5>
                            <p>Your shipment will be on its way in no time</p>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <div class="feature-icon mb-2">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <h5>Secure Shipping</h5>
                            <p>Your items are protected throughout their journey</p>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <div class="feature-icon mb-2">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <h5>Real-time Tracking</h5>
                            <p>Stay updated on your shipment's location</p>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <a href="request-shipment.php" class="btn btn-primary btn-lg">
                            <i class="bi bi-box-seam me-2"></i>Start Your Shipment
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-light text-center text-muted py-3 mt-5">
        <div class="container">
            &copy; 2024 ShipOnline System. All rights reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>