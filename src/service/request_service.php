<?php
    include '../../repository/account_repository.php';
    include '../../helpers/request_validation.php';
    include '../../configuration/constants/request-service-contants.php';

    function requestShipment($dbConnect, $requestData) {
        $hasCorrectInput = hasCorrectRequest($requestData); 
        //print_r($hasCorrectInput);
        if(!$hasCorrectInput['success']) {
            return $hasCorrectInput;
        }

        return $hasCorrectInput;
    }

    function hasCorrectRequest($requestData) {
        if(!matchEmptyItem($requestData['description'])) {
            return ['success' => false, 'errors' => EMPTY_DESCRIPTION];
        }

        if(!matchWeight($requestData['weight'])) {
            return ['success' => false, 'errors' => INVALID_WEIGHT];
        }

        if(!matchEmptyItem($requestData['pickupAddress'])) {
            return ['success' => false, 'errors' => EMPTY_PICKUP_ADDRESS];
        }

        if(!matchEmptyItem($requestData['pickupSuburb'])) {
            return ['success' => false, 'errors' => EMPTY_PICKUP_SUBURB];
        }

        $timeResponse = calculatePickupDateTime($requestData['pickupDay'] , 
            $requestData['pickupMonth'], 
            $requestData['pickupYear'], $requestData['pickupTime']);

        if(!$timeResponse['success']) {
            return $timeResponse;
        }

        if(!matchEmptyItem($requestData['pickupSuburb'])) {
            return ['success' => false, 'errors' => EMPTY_PICKUP_SUBURB];
        }

        if(!matchEmptyItem($requestData['deliveryAddress'])) {
            return ['success' => false, 'errors' => EMPTY_DELIVERY_ADDRESS];
        }

        if(!matchEmptyItem($requestData['deliverySuburb'])) {
            return ['success' => false, 'errors' => EMPTY_DELIVERY_SUBURB];
        }

        if(!matchEmptyItem($requestData['deliveryState'])) {
            return ['success' => false, 'errors' => INVALID_DELIVERY_STATE];
        }

        return ['success' => true, 'errors' => ''];
    }

    function calculatePickupDateTime($day, $month, $year, $time) {
        if(!checkdate($month, $day, $year)) {
            return ['success' => false, 'errors' => INVALID_PICKUP_DATE];
        }

        $parts = explode(':', $time);
        $hour = (int)$parts[0];
        $min = (int)$parts[1];
        $timeResponse = hasCorrectPickupTime($hour);

        if(!$timeResponse['success']) {
            return $timeResponse;
        }



        return ['success' => true, 'errors' => ''];
    }

    function hasCorrectPickupTime($hour) {
        if($hour < 8 || $hour > 20) {
            return ['success' => false, 'errors' => INVALID_PICKUP_TIME];
        }

        return ['success' => true, 'errors' => ''];
    }

    

    function generateRequestNumber($dbConnect, $customer_number) {
        $customerNumber = $_SESSION['customer_number'];
        //To be implemented
    }
?>