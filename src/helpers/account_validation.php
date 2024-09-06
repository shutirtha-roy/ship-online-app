<?php
    function matchName($name) {
        return ctype_alpha($name);
    }

    function matchEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function matchPassword($password, $confirmPassword) {
        return $password == $confirmPassword;
    }

    function matchPhoneNumber($phoneNumber) {
        if (preg_match('/^\+61/', $phoneNumber)) {
            return strlen($phoneNumber) === 12;
        } 
        
        if (preg_match('/^0/', $phoneNumber)) {
            return strlen($phoneNumber) === 10;
        }

        return false;
    }
?>