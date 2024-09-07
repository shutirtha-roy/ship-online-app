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

        //$customerExists = doesCustomerExist($dbConnect, $email);
        //Or die(USER_ALREADY_EXISTS);
        //$data = prepareUserData($name, $email, $password, $phone);

        //$result = insertQuery($dbConnect, 'customer', $data);

        // if($result) {

        // }

        // if(!$result) {
        //     return ['success' => true, 'errors' => ERROR_REGISTRATION];
        // }

        return ['success' => true, 'errors' => ''];
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

    function prepareUserData($name, $email, $password, $phone) {
        return [
            'name' => "'" . $name . "'",
            'password' => "'" . $password . "'",
            'email_address' => "'" . $email . "'",
            'phone_number' => "'" . $phone . "'",
        ];
    }
?>