<?php
    $DB_DBN="mysql:host=localhost";
	$DB_USER="root";
	$DB_PASSWORD="sabelo";

    $connect = new PDO($DB_DBN, $DB_USER, $DB_PASSWORD);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $database_check = "DROP DATABASE IF EXISTS camagru";
    $database = "CREATE DATABASE IF NOT EXISTS camagru";
    $use_db = "USE camagru";
    $table_1 = "CREATE TABLE IF NOT EXISTS users
    (
        id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
        username VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL,
        password VARCHAR(100) NOT NULL,
        confirm_email int(1) default 0,
        notifications VARCHAR(3) NOT NULL,
        token VARCHAR(10) NOT NULL
    )";
    $table_2 = "CREATE TABLE IF NOT EXISTS gallery
    (
        id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
        image LONGTEXT NOT NULL,
        username VARCHAR(16) NOT NULL,
        imgdate TIMESTAMP NOT NULL,
        name VARCHAR(16) NOT NULL
    )";
    
    
    $sab = $connect->prepare($database_check);
    if ($sab->execute()){
        print "database deleted".PHP_EOL;
    }
    $sab = $connect->prepare($database);
    if ($sab->execute()){
        print "database camagru created".PHP_EOL;
    }
    $sab = $connect->prepare($use_db);
    if ($sab->execute()){
        print "database camagru in use".PHP_EOL;
    }
    $sab = $connect->prepare($table_1);
    if ($sab->execute()){
        print " users table created".PHP_EOL;
    }
    header("Refresh: 2; url=../index.php");
?>