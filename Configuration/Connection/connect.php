<?php 
	include '../Constants/database-server-constants.php';

	$servername = LOCAL_SERVER_NAME;
	$username = LOCAL_USERNAME;
	$password = LOCAL_PASSWORD;
	$database = DATABASE;

	$dbConnect = @mysqli_connect($servername, $username, $password, $database)
		Or die (DATABASE_ERROR_MESSAGE);
?>