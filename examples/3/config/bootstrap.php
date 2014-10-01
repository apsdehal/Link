<?php

//Load the autoload class provided by the composer
require("vendor/autoload.php");

global $config;
//Get the config and json decode it to get an array with the required config
$config  = json_decode(file_get_contents("config/config.json"), true);

$dbconfig = array(
	'host' => "localhost",
	'user' => "blah",
	'password' => "",
	'db' => "link",
);

global $dbh;

try{
	$host = $dbconfig['host'];
	$dbname = $dbconfig['db'];
	$dbh = new PDO("mysql:host=$host;dbname=$dbname", $dbconfig['user'], $dbconfig['password']);
	$dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
} catch(PDOException $e) { 
	echo $e->getMessage();
}

//Check for the development environment if yes set error display on
if ($config["environment"] === "development") {
    error_reporting("-1");
    ini_set("display_errors", "On");
}