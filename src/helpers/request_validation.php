<?php
    function matchEmptyItem($value) {
        return !empty($value); 
    }

    function matchWeight($weight) {
        return is_numeric($weight) 
            && $weight >= 0 
            && $weight <= 20;
    }

    
?>