<?php
    include '../../repository/account_repository.php';
    include '../../helpers/request_validation.php';
    include '../../configuration/constants/request-service-contants.php';

    function requestShipment($dbConnect, $requestData) {
        $hasCorrectInput = hasCorrectRequest($requestData); 

        if(!$hasCorrectInput['success']) {
            return $hasCorrectInput;
        }

        return $hasCorrectInput;
    }

    function hasCorrectRequest($requestData) {
        print_r($requestData);
        echo $requestData['description'];
        if(!matchEmptyItem($requestData['description'])) {
            echo "IT IS HERE";
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

        calculatePickupDateTime($requestData['pickupDay'] , $requestData['pickupMonth'], 
            $requestData['pickupYear'], $requestData['pickupTime']);

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
        $currentDateTime = new DateTime();
        $pickupDateTime = DateTime::createFromFormat('Y-m-d H:i', "$year-$month-$day $time");
        
        echo $pickupDateTime === false;
        if ($pickupDateTime === false) {
            return ['success' => false, 'errors' => INVALID_PICKUP_DATE];
        }
    
        $interval = $currentDateTime->diff($pickupDateTime);
        $hoursDifference = $interval->days * 24 + $interval->h;
        if ($hoursDifference < 24) {
            return ['success' => false, 'errors' => PICKUP_TOO_SOON];
        }
    
        $pickupHour = $pickupDateTime->format('H');
        if ($pickupHour < 8 || $pickupHour >= 20) {
            return ['success' => false, 'errors' => PICKUP_TIME_OUT_OF_RANGE];
        }
    
        return true; 
    }

    function generateRequestNumber($dbConnect, $customer_number) {
        $customerNumber = $_SESSION['customer_number'];
        //To be implemented
    }
?>