<?php
    include '../../repository/repository.php';

    function doesCustomerExist($dbConnect, $email) {
        $existsCustomer = "SELECT * FROM `customer` where email_address = '$email'";
        $result = queryResult($dbConnect, $existsCustomer);
        $numExistRows = mysqli_num_rows($result);
        return $numExistRows > 0;
    }

?>