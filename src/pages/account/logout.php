<?php
/*
Name: Shutirtha Roy
Student ID: 105008711
Course: COS80021 Web Application Development
Function: This file is used to logout the customer.
*/

session_start();

session_unset();
session_destroy();

header("location: login.php");
exit;

?>