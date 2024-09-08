<?php
/* 
    Name: Shutirtha Roy
    Student ID: 105008711
    Course: COS80021 Web Application Development
    Function: This file contains all the constants of connect.php. 
*/

define("SERVER_NAME", "feenix-mariadb.swin.edu.au");
define("LOCAL_SERVER_NAME", "localhost");
define("LOCAL_USERNAME", "root");
define("LOCAL_PASSWORD", "");
define("USERNAME", "s105008711");
define("PASSWORD", "060499");
define("DATABASE", "s105008711_db");
define("DATABASE_ERROR_MESSAGE", "<p>Unable to connect to the database server.</p>". "<p>Error code ". mysqli_connect_errno().": ". mysqli_connect_error())
?>