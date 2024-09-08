<?php
    /* 
        Name: Shutirtha Roy
        Student ID: 105008711
        Course: COS80021 Web Application Development
        Function: This file contains all the general database query logic which
         contains the insert Query so that long query insert statements do not 
         need to be written and reusable queryResult is also used. 
    */   

    include '../../configuration/constants/database-constants.php';
    
    function insertQuery($dbConnect, $table, $data) {
        $columns = array_keys($data);
        $values = array_values($data);

        $columnString = implode(', ', $columns);
        $valueString = implode(', ', $values);

        $sqlString = "INSERT INTO $table ($columnString) VALUES ($valueString)";

        $result = queryResult($dbConnect, $sqlString);

        return $result;
    }
    
    function queryResult($dbConnect, $sqlString) {
        $result = @mysqli_query($dbConnect, $sqlString) 
            Or die(TABLE_QUERY_ERROR."<p>Error code ". mysqli_errno($dbConnect). 
            ": ". mysqli_error($dbConnect)."</p>");

        return $result;
    }
?>