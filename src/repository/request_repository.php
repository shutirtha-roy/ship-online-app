<?php
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