<?php
/*
Name: Shutirtha Roy
Student ID: 105008711
Course: COS80021 Web Application Development
Function: This file is used to register the user's name, email, password, phone. Also 
it checks the validation of the inputs. After registering, the data is stored in the 
customer table.
*/

include '../../../src/service/account_service.php';
include '../../../src/configuration/connection/connect.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];
    $phone = $_POST["phone"];
    
    $userResponse = registerUser($dbConnect, $name, $email, $password, $confirmPassword, $phone);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/css/register.css">
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
                <div class="registration-form">
                    <h2 class="text-center mb-4">Registration</h2>
                    <form action="register.php" method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Contact Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-register">Register</button>
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