<?php
include '../../../src/service/request_service.php';
include '../../../src/configuration/connection/connect.php';

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
     header("location: ../account/login.php");
     exit;
}

$name = $_SESSION['name'];
$customer_number = $_SESSION['customer_number'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $requestData = array(
        'customer_number' => $customer_number,
        'description' => $_POST['description'],
        'weight' => (int)$_POST['weight'],
        'pickupAddress' => $_POST['pickupAddress'],
        'pickupSuburb' => $_POST['pickupSuburb'],
        'pickupDay' => (int)$_POST['pickupDay'],
        'pickupMonth' => (int)$_POST['pickupMonth'],
        'pickupYear' => (int)$_POST['pickupYear'],
        'pickupTime' => $_POST['pickupTime'],
        'receiverName' => $_POST['receiverName'],
        'deliveryAddress' => $_POST['deliveryAddress'],
        'deliverySuburb' => $_POST['deliverySuburb'],
        'deliveryState' => $_POST['deliveryState']
    );

    $requestResponse = requestShipment($dbConnect, $requestData);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShipOnline System - Shipping Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/css/request-shipment.css">
</head>
<body>
    <?php require '../common/nav.php' ?>

    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST" && !$requestResponse['success']) {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
              <i class='bi bi-exclamation-triangle-fill me-2'></i>
              " . $requestResponse['errors'] . "
              <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
        }
    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="shipping-form">
                    <h2 class="text-center mb-4">Shipping Request Form</h2>
                    <form method="post" action="request-shipment.php">
                        <div class="form-section">
                            <h4>Item Information</h4>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control description-area" id="description" name="description" rows="6" placeholder="Please provide a detailed description of your item(s). Include information such as contents, fragility, special handling instructions, or any other relevant details." required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="weight" class="form-label">Weight</label>
                                <select class="form-select" id="weight" name="weight" required>
                                    <option value="" disabled selected>Select Weight</option>
                                    <option value="2">0-2 kg</option>
                                    <option value="3">3 kg</option>
                                    <option value="4">4 kg</option>
                                    <option value="5">5 kg</option>
                                    <option value="6">6 kg</option>
                                    <option value="7">7 kg</option>
                                    <option value="8">8 kg</option>
                                    <option value="9">9 kg</option>
                                    <option value="10">10 kg</option>
                                    <option value="11">11 kg</option>
                                    <option value="12">12 kg</option>
                                    <option value="13">13 kg</option>
                                    <option value="14">14 kg</option>
                                    <option value="15">15 kg</option>
                                    <option value="16">16 kg</option>
                                    <option value="17">17 kg</option>
                                    <option value="18">18 kg</option>
                                    <option value="19">19 kg</option>
                                    <option value="20">20 kg</option>
                                </select>
                                <small class="text-muted mt-2 d-block">
                                    <strong>Pricing:</strong> $20 for 0-2 kg and $3 for each additional kg
                                </small>
                            </div>
                        </div>

                        <div class="form-section">
                            <h4>Pick-up Information</h4>
                            <div class="mb-3">
                                <label for="pickupAddress" class="form-label">Address</label>
                                <input type="text" class="form-control" id="pickupAddress" name="pickupAddress" required>
                            </div>
                            <div class="mb-3">
                                <label for="pickupSuburb" class="form-label">Suburb</label>
                                <input type="text" class="form-control" id="pickupSuburb" name="pickupSuburb" required>
                            </div>
                            <div class="row mb-3">
                                <label class="form-label">Preferred Pickup Date</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="pickupDay" name="pickupDay" placeholder="Day" required>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-select" id="pickupMonth" name="pickupMonth" required>
                                        <option value="" selected disabled>Select Month</option>
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" id="pickupYear" name="pickupYear" required>
                                        <option value="" selected disabled>Select Year</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="pickupTime" class="form-label">Preferred Time (8:00 - 20:00)</label>
                                    <input type="time" class="form-control" id="pickupTime" name="pickupTime" required>
                                </div>
                                <small class="text-muted mt-2 d-block col-md-12">
                                    The preferred pick-up date and time are at least 24 hours after the current time.
                                </small>
                            </div>
                        </div>

                        <div class="form-section">
                            <h4>Delivery Information</h4>
                            <div class="mb-3">
                                <label for="receiverName" class="form-label">Receiver Name</label>
                                <input type="text" class="form-control" id="receiverName" name="receiverName" required>
                            </div>
                            <div class="mb-3">
                                <label for="deliveryAddress" class="form-label">Address</label>
                                <input type="text" class="form-control" id="deliveryAddress" name="deliveryAddress" required>
                            </div>
                            <div class="mb-3">
                                <label for="deliverySuburb" class="form-label">Suburb</label>
                                <input type="text" class="form-control" id="deliverySuburb" name="deliverySuburb" required>
                            </div>
                            <div class="mb-3">
                                <label for="deliveryState" class="form-label">State</label>
                                <select class="form-select" id="deliveryState" name="deliveryState" required>
                                    <option value="" disabled selected>Select State</option>
                                    <option value="NSW">New South Wales</option>
                                    <option value="VIC">Victoria</option>
                                    <option value="QLD">Queensland</option>
                                    <option value="WA">Western Australia</option>
                                    <option value="SA">South Australia</option>
                                    <option value="TAS">Tasmania</option>
                                    <option value="ACT">Australian Capital Territory</option>
                                    <option value="NT">Northern Territory</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-request">Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-light text-center text-muted py-3">
        <div class="container">
            &copy; 2024 ShipOnline System. All rights reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>