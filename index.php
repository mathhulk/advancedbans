<?php

error_reporting(0);
session_start();

/*
 *	CONFIGURATION / LANGUAGE
 */
 
$info = json_decode(file_get_contents("inc/config.json"), true);
$lang = json_decode(file_get_contents("inc/languages/".(isset($_COOKIE["ab-lang"]) ? $_COOKIE["ab-lang"] : $info["default_language"]).".json"), true)["terms"];

/*
 *	PUNISHMENTS
 *	Could this be improved?
 */
 
$punishments = array("all", "ban", "temp_ban", "mute", "temp_mute", "warning", "temp_warning", "kick"); 
if($info["ip_bans"] == true) {
	$punishments[] = "ip_ban";
}
if($info["compact"] == true) {
	$punishments = array("all", "ban", "mute", "warning", "kick");
}

/*
 *	LOAD REQUIRED FILES
 */
 
require("inc/include/variables.php");
require("inc/include/database.php");
require("inc/include/date.php");
require("inc/include/classes/Pagination.class.php");
require("inc/include/functions.php");

/*
 *	REQUEST
 */
 
require("pages/".(isset($_GET["s"]) && !empty($_GET["s"]) && strlen(getPath($_GET["s"])) && file_exists("pages/".getPath($_GET["s"]).".php") > 0 ? getPath($_GET["s"]).".php" : "index.php"));