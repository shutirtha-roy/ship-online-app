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
        $timeResponse = hasCorrectPickupTime($hour, $min);

        if(!$timeResponse['success']) {
            return $timeResponse;
        }

        $isWithinTwentyFourResponse = isWithinTwentyFourHours($day, $month, $year, $hour, $min);

        if(!$isWithinTwentyFourResponse['success']) {
            return $isWithinTwentyFourResponse;
        }

        return ['success' => true, 'errors' => ''];
    }

    function hasCorrectPickupTime($hour, $min) {
        if($hour < 8 || $hour > 20) {
            return ['success' => false, 'errors' => INVALID_PICKUP_TIME];
        }

        if($hour == 20 && $min > 0) {
            return ['success' => false, 'errors' => INVALID_PICKUP_TIME];
        }

        return ['success' => true, 'errors' => ''];
    }

    function isWithinTwentyFourHours($day, $month, $year, $hour, $min) {
        date_default_timezone_set('Australia/Melbourne');

        $currentTimestamp = time();
        $pickupTimestamp = mktime($hour, $min, 0, $month, $day, $year);
        
        $hoursDifference = ($pickupTimestamp - $currentTimestamp) / 3600;

        if($hoursDifference < 24) {
            return ['success' => false, 'errors' => PICKUP_TOO_SOON];
        }

        return ['success' => true, 'errors' => ''];
    }

    function generateRequestNumber($dbConnect, $customer_number) {
        $customerNumber = $_SESSION['customer_number'];
        //To be implemented
    }
?>