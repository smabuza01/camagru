<?php
	session_start();
	$DB_DBN="mysql:host=localhost;dbname=camagru";
	$DB_USER="root";
	$DB_PASSWORD="sabelo";

	$conn = new PDO($DB_DBN, $DB_USER, $DB_PASSWORD);
	
?>