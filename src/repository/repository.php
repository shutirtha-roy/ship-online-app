<?php
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