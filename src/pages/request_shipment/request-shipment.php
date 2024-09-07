<?php
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
    <title>ShipOnline System - Shipping Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/css/request-shipment.css">
</head>
<body>
    <?php require '../common/nav.php' ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="shipping-form">
                    <h2 class="text-center mb-4">Shipping Request Form</h2>
                    <form>
                        <div class="form-section">
                            <h4>Item Information</h4>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description (up to 200 words)</label>
                                <textarea class="form-control description-area" id="description" rows="6" placeholder="Please provide a detailed description of your item(s). Include information such as contents, fragility, special handling instructions, or any other relevant details." required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="weight" class="form-label">Weight</label>
                                <select class="form-select" id="weight" required>
                                    <option value="">Select Weight</option>
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
                            </div>
                        </div>

                        <div class="form-section">
                            <h4>Pick-up Information</h4>
                            <div class="mb-3">
                                <label for="pickupAddress" class="form-label">Address</label>
                                <input type="text" class="form-control" id="pickupAddress" required>
                            </div>
                            <div class="mb-3">
                                <label for="pickupSuburb" class="form-label">Suburb</label>
                                <input type="text" class="form-control" id="pickupSuburb" required>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="pickupDate" class="form-label">Preferred Date</label>
                                    <input type="date" class="form-control" id="pickupDate" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="pickupTime" class="form-label">Preferred Time</label>
                                    <input type="time" class="form-control" id="pickupTime" required>
                                </div>
                            </div>
                            <small class="text-muted">If you don't mind when your shipment will be picked up you can leave these fields empty</small>
                        </div>

                        <div class="form-section">
                            <h4>Delivery Information</h4>
                            <div class="mb-3">
                                <label for="receiverName" class="form-label">Receiver Name</label>
                                <input type="text" class="form-control" id="receiverName" required>
                            </div>
                            <div class="mb-3">
                                <label for="deliveryAddress" class="form-label">Address</label>
                                <input type="text" class="form-control" id="deliveryAddress" required>
                            </div>
                            <div class="mb-3">
                                <label for="deliverySuburb" class="form-label">Suburb</label>
                                <input type="text" class="form-control" id="deliverySuburb" required>
                            </div>
                            <div class="mb-3">
                                <label for="deliveryState" class="form-label">State</label>
                                <select class="form-select" id="deliveryState" required>
                                    <option value="">Select State</option>
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
                            <button type="submit" class="btn btn-primary btn-request">Request Shipment</button>
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