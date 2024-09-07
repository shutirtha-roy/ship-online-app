<?php
    include '../../repository/account_repository.php';
    include '../../helpers/account_validation.php';
    include '../../configuration/constants/account-service-contants.php';

    function registerUser($dbConnect, $name, $email, $password, $confirmPassword, 
        $phone) {
        $hasCorrectInput = hasUserEnteredCorrectInputs($name, 
            $email, $password, 
            $confirmPassword, $phone); 

        if(!$hasCorrectInput['success']) {
            return $hasCorrectInput;
        }

        $customerExists = hasCustomer($dbConnect, $email);

        if(!$customerExists['success']) {
            return $customerExists;
        }

        $customerNumber = generateCustomerNumber($dbConnect, $email);
        $data = prepareUserData($customerNumber, $name, $email, $password, $phone);

        $result = insertQuery($dbConnect, 'customer', $data);

        if(!$result) {
            return ['success' => false, 'errors' => ERROR_REGISTRATION];
        }

        setSession($email, $customerNumber);

        header("location: ../request_shipment/pre-request-shipment.php");
    }

    function hasUserEnteredCorrectInputs($name, $email, $password, $confirmPassword, 
        $phone) {
        if(!matchName($name)) {
            return ['success' => false, 'errors' => ERROR_NAME_REQUIRED];
        }
        
        if(!matchEmail($email)) {
            return ['success' => false, 'errors' => ERROR_EMAIL_INVALID];
        }

        if (!matchPassword($password, $confirmPassword)) {
            return ['success' => false, 'errors' => ERROR_PASSWORDS_DO_NOT_MATCH];
        }

        if (!matchPhoneNumber($phone)) {
            return ['success' => false, 'errors' => ERROR_PHONE_INVALID];
        }

        return ['success' => true, 'errors' => ''];
    }

    function hasLoginCustomer($dbConnect, $email) {
        if(doesCustomerExist($dbConnect, $email)) {
            return ['success' => false, 'errors' => USER_ALREADY_EXISTS];
        }

        return ['success' => true, 'errors' => ''];
    }

    function prepareUserData($customerNumber, $name, $email, $password, $phone) {
        return [
            'customer_number' => "'" . $customerNumber . "'",
            'name' => "'" . $name . "'",
            'password' => "'" . $password . "'",
            'email_address' => "'" . $email . "'",
            'phone_number' => "'" . $phone . "'",
        ];
    }

    function generateCustomerNumber($dbConnect, $email) {
        $totalCustomer = getAllCustomerNumber($dbConnect, $email);
        $customerNumber = DATABASE_ERROR_MESSAGE. ($totalCustomer + 1);
        return $customerNumber;
    }

    function setSession($email, $customerNumber) {
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        $_SESSION['customer_number'] = $customerNumber;
    }

    function loginUser($dbConnect, $email, $password) {
        if(!matchEmail($email)) {
            return ['success' => false, 'errors' => ERROR_EMAIL_INVALID];
        }

        $loginUser = hasLoginCustomer($dbConnect, $email, $password);
        if($loginUser) {
            $customerNumber = getCustomerNumberFromCustomer($dbConnect, $email);
            setSession($email, $customerNumber);
            header("location: ../request_shipment/pre-request-shipment.php");
        };
    }
?>