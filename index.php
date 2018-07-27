<?php

// Change to E_ALL for debug purposes.
error_reporting(E_ALL);

ob_start( );

// CONFIGURATION
$__public = json_decode(file_get_contents("include/public.json"), true);
$__language = json_decode(file_get_contents("include/languages/" . (isset($_COOKIE["ab-web-addon_language"]) ? $_COOKIE["ab-web-addon_language"] : $__public["default"]["language"]) . ".json"), true);

require("include/private.php");

// REQUIREMENTS
require("include/require/classes/Pagination.class.php");
require("include/require/functions.php");

// SESSION
session_start( );

if(!isset($_SESSION["ab-web-addon"]["time_zone"])) {
	$_SESSION["ab-web-addon"]["time_zone"] = $__public["default"]["time_zone"];
	$api = json_decode(file_get_contents("http://geoip.nekudo.com/api/" . $_SERVER["REMOTE_ADDR"]), true);
	if(isset($api["location"]["time_zone"]) && in_array($api["location"]["time_zone"], timezone_identifiers_list( ))) {
		$_SESSION["ab-web-addon"]["time_zone"] = $api["location"]["time_zone"];
	}
}

// DATABASE
$__connection = new PDO("mysql:host=" . $__private["connection"]["host"] . ";dbname=" . $__private["connection"]["database"] . ";port=3306;charset=utf8mb4", $__private["connection"]["user"], $__private["connection"]["password"]);
$__connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

// REQUEST
if(empty($_GET["path"])) require("pages/index.php");
else if(file_exists("pages/" . cleanPath($_GET["path"]) . ".php")) require("pages/" . cleanPath($_GET["path"]) . ".php");
else require("pages/error.php");