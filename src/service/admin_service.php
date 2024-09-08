<?php
    include '../../repository/admin_repository.php';
    include '../../helpers/request_validation.php';
    include '../../configuration/constants/request-service-contants.php';

    function adminResults($dbConnect, $dateType, $day, $month, $year) {
        $results = [];
        $hasCorrectInput = hasCorrectRequest($dateType, $day, $month, $year); 
        if(!$hasCorrectInput['success']) {
            return $hasCorrectInput;
        }

        $date = sprintf('%04d-%02d-%02d', 
            $year, $month, $day);

        if($dateType == REQUEST_DATE) {
            $results = requestRequestDate($dbConnect, $date);
        }

        if($dateType == PICKUP_DATE) {
            $results = requestPickupDate($dbConnect, $date);
        }

        $totalRequests = count($results);
        $totalWeight = array_sum(array_column($results, 'weight'));
      
        return ['success' => true, 'errors' => INVALID_REQUEST, 
            'result' => $results,
            'totalRequest' => $totalRequests,
            'totalWeight' => $totalWeight];
    }

    function hasCorrectRequest($dateType, $day, $month, $year) {
        if(!matchEmptyItem($dateType)) {
            return ['success' => false, 'errors' => NO_DATE_TYPE];
        }

        if(!checkdate($month, $day, $year)) {
            return ['success' => false, 'errors' => INVALID_PICKUP_DATE];
        }

        return ['success' => true, 'errors' => ''];
    }

    function requestRequestDate($dbConnect, $date) {
        $result = requestDateDetailsFromDB($dbConnect, $date);
        return prepareResult($result);
    }

    function requestPickupDate($dbConnect, $date) {
        $result = requestPickupDateDetailsFromDB($dbConnect, $date);
        return prepareResult($result);
    }

    function prepareResult($result) {
        $totalRequests = 0;
        $totalWeight = 0;
        $results = [];

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $results[] = $row;
            }

            return $results;
        }
    }
?>