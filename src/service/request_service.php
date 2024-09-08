<?php
    include '../../repository/request_repository.php';
    include '../../helpers/request_validation.php';
    include '../../configuration/constants/request-service-contants.php';

    function requestShipment($dbConnect, $requestData) {
        $hasCorrectInput = hasCorrectRequest($requestData); 
        if(!$hasCorrectInput['success']) {
            return $hasCorrectInput;
        }

        $requestNumber = generateRequestNumber($dbConnect, $requestData['customer_number']);
        $data = prepareRequestData($requestData, $requestNumber);
        $result = insertQuery($dbConnect, 'shipping_request', $data);

        if(!$result) {
            return ['success' => false, 'errors' => INVALID_REQUEST];
        }

        $cost = calculateCost($requestData['weight']);
        $pickupDate = sprintf('%04d-%02d-%02d', 
            $requestData['pickupYear'], 
            $requestData['pickupMonth'], 
            $requestData['pickupDay']);
        $message = 'Thank you!' . printRequestMessage($requestNumber, $cost, 
            $requestData['pickupTime'], $pickupDate);

        sendConfirmationEmail($dbConnect, $requestData['customer_number'], 
            $requestNumber, $cost, $requestData['pickupTime'], $pickupDate);

        return ['success' => true, 'errors' => INVALID_REQUEST, 
            'message' => $message];
    }

    function sendConfirmationEmail($dbConnect, $customerNumber,
        $requestNumber, $cost, $pickupTime, $pickupDate) {
        $userDetails = getCustomerNameAndEmail($dbConnect, $customerNumber);
        $name = $userDetails['name'];
        $to = $userDetails['email'];
        $subject = "shipping request with ShipOnline";
        $message = printEmailMessage($name, $requestNumber, $cost, 
            $pickupTime , $pickupDate);
        $headers = 'From: info@shiponline.com';
        mail($to, $subject, $message, $headers, "-r 105008711@student.swin.edu.au");
    }

    function printEmailMessage($name, $requestNumber, $cost, $pickupTime , $pickupDate) {
        return "Dear $name, Thank you for using ShipOnline!" 
         .  printRequestMessage($requestNumber, 
                $cost, $pickupTime , 
                $pickupDate);
    }

    function printRequestMessage($requestNumber, $cost, $pickupTime , $pickupDate) {
        return "Your request number is $requestNumber.
            The cost is $$cost.We will pick-up the item at $pickupTime on $pickupDate.";
    }

    function calculateCost($weight) {
        $baseWeight = 2;
        $baseCost = 20;
        $additionalCost = 3;

        if($weight == $baseWeight) {
            return $baseCost;
        }

        return $baseCost + ($weight - $baseWeight) * $additionalCost;
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

    function prepareRequestData($requestData, $requestNumber) {
        date_default_timezone_set('Australia/Melbourne');
        $requestDate = date('Y-m-d');
        $pickupDate = sprintf('%04d-%02d-%02d', 
            $requestData['pickupYear'], 
            $requestData['pickupMonth'], 
            $requestData['pickupDay']);
        $pickupTime = $requestData['pickupTime'];
            
        return [
            'request_number' => "'" . $requestNumber . "'",
            'customer_number' => "'" . $requestData['customer_number'] . "'",
            'request_date' => "'" .$requestDate . "'",
            'item_description' => "'" .$requestData['description'] . "'",
            'weight' => $requestData['weight'],
            'pickup_address' => "'" . $requestData['pickupAddress'] . "'",
            'pickup_suburb' => "'" . $requestData['pickupSuburb'] . "'",
            'preferred_pickup_date' => "'" .$pickupDate . "'",
            'preferred_pickup_time' => "'" .$pickupTime . "'",
            'receiver_name' => "'" . $requestData['receiverName'] . "'",
            'delivery_address' => "'" . $requestData['deliveryAddress'] . "'",
            'delivery_suburb' => "'" . $requestData['deliverySuburb'] . "'",
            'delivery_state' => "'" . $requestData['deliveryState'] . "'"
        ];
    }

    function generateRequestNumber($dbConnect, $customerNumber) {
        $customerNumber = $_SESSION['customer_number'];
        $totalCustomerRows = getTotalRowsFromCustomerId($dbConnect, $customerNumber);
        $requestNumber = $customerNumber . REQUEST_INDEX. ($totalCustomerRows + 1);
        return $requestNumber;
    }
?>