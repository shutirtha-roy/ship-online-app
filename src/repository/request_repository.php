<?php
    /* 
        Name: Shutirtha Roy
        Student ID: 105008711
        Course: COS80021 Web Application Development
        Function: This file contains all the database query logic which
         contains the getTotalRowsFromCustomerId which calculates the total
         entries of the requests per customer. The getCustomerNameAndEmail
         returns the name and email of the customer with the customer number.
    */

    include '../../repository/repository.php';

    function getTotalRowsFromCustomerId($dbConnect, $customerNumber) {
        $request = "Select * from shipping_request where customer_number = '$customerNumber'";
        $result = queryResult($dbConnect, $request);
        $numExistRows = mysqli_num_rows($result);

        return $numExistRows;
    }

    function getCustomerNameAndEmail($dbConnect, $customerNumber) {
        $customer = "Select * from customer where customer_number = '$customerNumber'";
        $result = queryResult($dbConnect, $customer);
        if ($row = mysqli_fetch_assoc($result)) {
            return [
                'name' => $row['name'],
                'email' => $row['email_address']
            ];
        } else {
            return null;
        }
    }
?>