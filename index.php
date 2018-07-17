<?php

// Change to E_ALL for debug purposes.
error_reporting(0);

session_start( );

// CONFIGURATION
$info = json_decode(file_get_contents("include/configuration.json"), true);
$language = json_decode(file_get_contents("include/languages/".($_COOKIE["ab-lang"] ? $_COOKIE["ab-lang"] : $info["default_language"]).".json"), true);

// PUNISHMENTS
$punishments = array("all", "ban", "temp_ban", "mute", "temp_mute", "warning", "temp_warning", "kick"); 
if($info["ip_bans"] == true) $punishments[ ] = "ip_ban";
if($info["compact"] == true) $punishments = array("all", "ban", "mute", "warning", "kick");

// REQUIREMENTS
require("include/require/variables.php");
require("include/require/date.php");
require("include/require/classes/Pagination.class.php");
require("include/require/functions.php");

// REQUEST
require("pages/".(!empty($_GET["page"]) && file_exists("pages/".getPath($_GET["page"]).".php") ? getPath($_GET["page"]).".php" : "index.php"));