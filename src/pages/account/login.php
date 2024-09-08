<?php
include '../../../src/service/account_service.php';
include '../../../src/configuration/connection/connect.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $customerNumber = $_POST["customerNumber"];
    $password = $_POST["password"];
    
    $userResponse = loginUser($dbConnect, $customerNumber, $password);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/css/login.css">
</head>
<body>
    <?php require '../common/nav.php' ?>

    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST" && !$userResponse['success']) {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
              <i class='bi bi-exclamation-triangle-fill me-2'></i>
              " . $userResponse['errors'] . "
              <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
        }
    ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-form">
                    <h2 class="text-center mb-4">Login</h2>
                    <form action="login.php" method="post">
                        <div class="mb-3">
                            <label for="customerNumber" class="form-label">Customer Number</label>
                            <input type="text" class="form-control" id="customerNumber" name="customerNumber"  required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password"  name="password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-login">Login</button>
                        </div>
                    </form>
                </div>
                <div class="text-center mt-3">
                    <a href="#" class="text-decoration-none">Back to Home</a>
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