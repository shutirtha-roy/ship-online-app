<?php
    include '../../repository/repository.php';

    function getTotalRowsFromCustomerId($dbConnect, $customerNumber) {
        $request = "Select * from shipping_request where customer_number = '$customerNumber'";
        $result = queryResult($dbConnect, $request);
        $numExistRows = mysqli_num_rows($result);

        return $numExistRows;
    }
?>