<?php
session_start();

$DB_DSN = 'mysql:dbname=camagru;host=localhost';
$DB_USER = 'root';
$DB_PASSWORD = 'sabelo';
// Connecting database
try {
	$connect = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
	echo $e->getMessage();
}

?>