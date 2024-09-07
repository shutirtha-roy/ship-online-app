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

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="admin-panel">
                    <h2 class="text-center mb-4">ShipOnline System Administration</h2>
                    <form>
                        <div class="mb-4">
                            <label class="form-label">Date for Retrieve</label>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <input type="date" class="form-control" id="pickupDate" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Select Date Item for Retrieve</label>
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
                                <i class="bi bi-search me-2"></i>Show Results
                            </button>
                        </div>
                    </form>
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