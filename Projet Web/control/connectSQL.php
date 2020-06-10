<?php
	$hostname = "localhost";	
	$database= "ftf";
	$login= "root";		
	$password="";
	try {
		$pdo = new PDO ("mysql:host=$hostname;dbname=$database",$login, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $e) {
		echo utf8_encode("Erreur de connexion : " . $e->getMessage() . "\n");
		die();
	}
?>	