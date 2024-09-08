<?php
    /* 
        Name: Shutirtha Roy
        Student ID: 105008711
        Course: COS80021 Web Application Development
        Function: This file contains all the database query logic of 
        admin_service.php. Here requestDateDetailsFromDB finds all details if the
        customer selected the Request Date from the Date Item. Also, requestPickupDateDetailsFromDB
        finds all details if the customer selected the Pick-up Date from the Date Item.
    */   

    include '../../repository/repository.php';

    function requestDateDetailsFromDB($dbConnect, $date) {
        $query = "SELECT c.customer_number, r.request_number, r.item_description, r.weight, 
                     r.pickup_suburb, r.preferred_pickup_date, r.delivery_suburb, r.delivery_state
                    FROM shipping_request r
                    JOIN customer c ON r.customer_number = c.customer_number
                    WHERE DATE(r.request_date) = '$date'";
        $result = queryResult($dbConnect, $query);
        
        return $result;
    }

    function requestPickupDateDetailsFromDB($dbConnect, $date) {
        $query = "SELECT c.customer_number, c.name, c.phone_number, r.request_number, r.item_description, 
                     r.weight, r.pickup_address, r.pickup_suburb, r.preferred_pickup_time, 
                        r.delivery_suburb, r.delivery_state
                FROM shipping_request r
                JOIN customer c ON r.customer_number = c.customer_number
                WHERE DATE(r.preferred_pickup_date) = '$date'
                ORDER BY r.pickup_suburb, r.delivery_state, r.delivery_suburb";
        $result = queryResult($dbConnect, $query);

        return $result;
    }
?>