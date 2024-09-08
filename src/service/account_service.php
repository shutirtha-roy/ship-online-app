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

        $customerExists = hasCustomer($dbConnect, $email, $password);

        if($customerExists) {
            return ['success' => false, 'errors' => CUSTOMER_ALREADY_EXISTS];
        }

        $customerNumber = generateCustomerNumber($dbConnect, $email);
        $data = prepareUserData($customerNumber, $name, $email, $password, $phone);

        $result = insertQuery($dbConnect, 'customer', $data);

        if(!$result) {
            return ['success' => false, 'errors' => ERROR_REGISTRATION];
        }

        setRegistrationSession($email, $customerNumber, $name);
        

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

    function hasLoginCustomer($dbConnect, $customerNumber) {
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
        $customerNumber = CUSTOMER_NUMBER_INDEX. ($totalCustomer + 1);
        return $customerNumber;
    }

    function setRegistrationSession($email, $customerNumber, $name) {
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        $_SESSION['customer_number'] = $customerNumber;
        $_SESSION['name'] = $name;
        $_SESSION['just_registered'] = true;
    }

    function setLoginSession($customerNumber, $name) {
        session_start();
        $_SESSION['name'] = $name;
        $_SESSION['loggedin'] = true;
        $_SESSION['customer_number'] = $customerNumber;
    }

    function loginUser($dbConnect, $customerNumber, $password) {
        if(!hasCustomerWithCustomerNumber($dbConnect, $customerNumber, $password)) {
            return ['success' => false, 'errors' => CUSTOMER_ALREADY_EXISTS];
        }

        $loginUser = hasLoginCustomer($dbConnect, $customerNumber, $password);
        if($loginUser) {
            $name = getCustomerNameFromCustomerId($dbConnect, $customerNumber);
            setLoginSession($customerNumber, $name);
            header("location: ../request_shipment/request-shipment.php");
        };
    }
?>