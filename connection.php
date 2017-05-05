<?php
	error_reporting(-1);
	$servername = 'localhost';
	$serverusername = 'root';
	$serverpassword = 'root';
	$dbname = 'CrowdFund';
	date_default_timezone_set('America/New_York');
	//Create Connection
	$conn = new mysqli($servername, $serverusername, $serverpassword, $dbname);

	//Check Connection
	if($conn->connect_error) {
		die("Connection Failed:" . $conn->connect_error);
	}

