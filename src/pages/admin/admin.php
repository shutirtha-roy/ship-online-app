<?php
/*
Name: Shutirtha Roy
Student ID: 105008711
Course: COS80021 Web Application Development
Function: This file is used to show the results of the request date and pickup date 
depending on the date entered by the user.
*/

include '../../../src/service/admin_service.php';
include '../../../src/configuration/connection/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $day = $_POST['pickupDay'];
    $month = $_POST['pickupMonth'];
    $year = $_POST['pickupYear'];
    $dateType = $_POST['dateItem'];

    $adminResponse = adminResults($dbConnect, $dateType, $day, $month, $year);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShipOnline System - Administration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/css/admin.css">
</head>
<body>
    <?php require '../common/nav.php' ?>

    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST" && !$adminResponse['success']) {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <i class='bi bi-exclamation-triangle-fill me-2'></i>
            " . $adminResponse['errors'] . "
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        }
    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="admin-panel">
                    <h2 class="text-center mb-4">ShipOnline System Administration</h2>
                    <form method="post" action="admin.php">
                        <div class="row mb-4">
                            <label class="form-label">Date for Retrieve:</label>
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
                        <div class="mb-4">
                            <label class="form-label">Select Date Item for Retrieve:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="dateItem" id="requestDate" value="requestDate" checked>
                                <label class="form-check-label" for="requestDate">
                                    Request Date
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="dateItem" id="pickupDate" value="pickupDate">
                                <label class="form-check-label" for="pickupDate">
                                    Pick-up Date
                                </label>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-show">
                                <i class="bi bi-search me-2"></i>Show
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $adminResponse['success']): ?>
            <div class="mt-5">
                <h3>Results</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <?php foreach (array_keys($adminResponse['result'][0]) as $header): ?>
                                <th><?= ucwords(str_replace('_', ' ', $header)) ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($adminResponse['result'] as $row): ?>
                            <tr>
                                <?php foreach ($row as $value): ?>
                                    <td><?= $value ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="mt-3">
                    <p>Total Requests: <?= $adminResponse['totalRequest'] ?>
                    ,       
                    <?php if ($_POST['dateItem'] == 'pickupDate'): ?>
                        Total Weight: <?= $adminResponse['totalWeight'] ?> kg
                    <?php endif; ?></p>
                    
                </div>
            </div>

        <?php endif; ?>
    </div>

    <footer class="bg-light text-center text-muted py-3 mt-5">
        <div class="container">
            &copy; 2024 ShipOnline System. All rights reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>