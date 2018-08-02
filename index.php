<?php

// Change to E_ALL for debug purposes.
error_reporting(E_ALL);

ob_start( );

// CONFIGURATION
$__public = json_decode(file_get_contents("include/public.json"), true);
$__language = json_decode(file_get_contents("include/languages/" . (isset($_COOKIE["advancedban-panel_language"]) ? $_COOKIE["advancedban-panel_language"] : $__public["default"]["language"]) . ".json"), true);

require("include/private.php");

// REQUIREMENTS
require("include/require/functions.php");

// DATABASE
$__connection = new PDO("mysql:host=" . $__private["connection"]["host"] . ";dbname=" . $__private["connection"]["database"] . ";port=3306;charset=utf8mb4", $__private["connection"]["user"], $__private["connection"]["password"]);
$__connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

// REQUEST
if(empty($_GET["path"])) require("pages/index.php");
else if(file_exists("pages/" . cleanPath($_GET["path"]) . ".php")) require("pages/" . cleanPath($_GET["path"]) . ".php");
else http_response_code(404);