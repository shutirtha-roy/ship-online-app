<?php
    /* 
        Name: Shutirtha Roy
        Student ID: 105008711
        Course: COS80021 Web Application Development
        Function: This file contains all the logics 
        admin.php. The function adminResults is used to see the output of the details 
        of the requests based on the date and the Date Item selected. Different results 
        with different keys are generated for Request Date and Pick-up Date.
    */ 

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

        if (!$results) {
            return ['success' => false, 'errors' => NO_RECORDS_FOUND];
        }

        $totalRequests = count($results);
        $totalWeight = getTotalWeight($results);
      
        return ['success' => true, 'errors' => INVALID_REQUEST, 
            'result' => $results,
            'totalRequest' => $totalRequests,
            'totalWeight' => $totalWeight];
    }

    function getTotalWeight($results) {
        $totalWeight = 0;

        foreach ($results as $result) {
            $totalWeight += intval($result['weight']);
        }

        return $totalWeight;
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

        return $results;
    }
?>