<?php
    function matchName($name) {
        return !empty($name) && preg_match("/^[a-zA-Z ]+$/", trim($name));
    }

    function matchEmail($email) {
        return !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function matchPassword($password, $confirmPassword) {
        return !empty($password) && $password == $confirmPassword;
    }

    function matchPhoneNumber($phoneNumber) {
        // echo $phoneNumber . "\n";

        if(empty($phoneNumber)) {
            return false;
        }
        // echo strpos($phoneNumber, '0');
        // if(strpos($phoneNumber, '0') === 0
        //     && strlen($phoneNumber) === 10) {
        //         echo "IT IS IN";
        //     };
        // //$cleanNumber = preg_replace('/[^0-9+]/', '', $phoneNumber);

        if (strpos($phoneNumber, '+61') == 0
            && strlen($phoneNumber) === 12) {
            return true;
        }
        
        // Check for domestic format (0)
        if (strpos($phoneNumber, '0') === 0
            && strlen($phoneNumber) === 10) {
            return true;
        }

        return false;
    }
?>