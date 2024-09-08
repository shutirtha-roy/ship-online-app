<?php 
	/* 
		Name: Shutirtha Roy
		Student ID: 105008711
		Course: COS80021 Web Application Development
		Function: This file is used to connect with the database. 
	*/

	include '../../configuration/constants/database-server-constants.php';

	$servername = LOCAL_SERVER_NAME;
	$username = LOCAL_USERNAME;
	$password = LOCAL_PASSWORD;
	$database = DATABASE;

	$dbConnect = @mysqli_connect($servername, $username, $password, $database)
		Or die (DATABASE_ERROR_MESSAGE);
?>