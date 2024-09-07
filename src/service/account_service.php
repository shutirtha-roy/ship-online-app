<?php
    include '../../repository/account_repository.php';
    include '../../helpers/account_validation.php';
    include '../../configuration/constants/account-service-contants.php';

    function registerUser($dbConnect, $name, $email, $password, $confirmPassword, 
        $phone) {
        // hasUserEnteredCorrectInputs($name, 
        //     $email, $password, 
        //     $confirmPassword, $phone);

        //doesCustomerExist($dbConnect, $email)
            //Or die(USER_ALREADY_EXISTS);

        $data = prepareUserData($name, $email, $password, $phone);

        $result = insertQuery($dbConnect, 'customer', $data);

        if($result) {

        }

        if(!$result) {
            die(ERROR_REGISTRATION);
        }
    }

    function hasUserEnteredCorrectInputs($name, $email, $password, $confirmPassword, 
        $phone) {
        matchName($name) OR die(ERROR_NAME_REQUIRED);
        matchEmail($email) OR die(ERROR_EMAIL_INVALID);
        matchPassword($password, $confirmPassword) OR die(ERROR_PASSWORDS_DO_NOT_MATCH);
        matchPhoneNumber($phone) OR die(ERROR_PHONE_INVALID);
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