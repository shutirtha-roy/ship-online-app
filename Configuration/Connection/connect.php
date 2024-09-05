<?php 
	include '../Constants/database-server-constants.php';

	$servername = SERVER_NAME;
	$username = USERNAME;
	$password = PASSWORD;
	$database = DATABASE;

	$dbConnect = @mysqli_connect($servername, $username, $password, $database)
		Or die (DATABASE_ERROR_MESSAGE);
?>