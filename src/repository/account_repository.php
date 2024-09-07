<?php
    include '../../repository/repository.php';

    function hasCustomer($dbConnect, $email, $password) {
        $customer = "Select * from customer where email_address='$email' AND password='$password'";
        $result = queryResult($dbConnect, $customer);
        $numExistRows = mysqli_num_rows($result);

        return $numExistRows == 1;
    }

    function hasCustomerWithCustomerNumber($dbConnect, $customerNumber, $password) {
        $customer = "Select * from customer where customer_number = '$customerNumber' AND password='$password'";
        $result = queryResult($dbConnect, $customer);
        $numExistRows = mysqli_num_rows($result);

        return $numExistRows == 1;
    }

    function getCustomerNameFromCustomerId($dbConnect, $customerNumber) {
        $customer = "Select * from customer where customer_number = '$customerNumber'";
        $result = queryResult($dbConnect, $customer);

        if ($row = mysqli_fetch_assoc($result)) {
            return $row['name'];
        } else {
            return null;
        }
    }

    function getAllCustomerNumber($dbConnect, $email) {
        $allCustomers = "SELECT * FROM `customer`";
        $result = queryResult($dbConnect, $allCustomers);
        $numExistRows = mysqli_num_rows($result);

        return $numExistRows;
    }

    function doesCustomerExist($dbConnect, $customerNumber) {
        $existsCustomer = "SELECT * FROM `customer` where customer_number = '$customerNumber'";
        $result = queryResult($dbConnect, $existsCustomer);
        $numExistRows = mysqli_num_rows($result);
        return $numExistRows > 0;
    }

?>