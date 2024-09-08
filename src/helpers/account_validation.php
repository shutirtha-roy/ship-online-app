<?php
    /* 
        Name: Shutirtha Roy
        Student ID: 105008711
        Course: COS80021 Web Application Development
        Function: This file contains all the account validations of 
        account_service.php. 
    */

    function matchName($name) {
        return !empty($name);
    }

    function matchEmail($email) {
        return !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function matchPassword($password, $confirmPassword) {
        return !empty($password) && $password == $confirmPassword;
    }

    function matchPhoneNumber($phoneNumber) {
        if(empty($phoneNumber)) {
            return false;
        }

        if (strpos($phoneNumber, '+61') == 0
            && strlen($phoneNumber) === 12) {
            return true;
        }
        
        if (strpos($phoneNumber, '0') === 0
            && strlen($phoneNumber) === 10) {
            return true;
        }

        return false;
    }
?>