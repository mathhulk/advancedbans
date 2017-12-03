<?php

/*
 *	ERRORS
 */
error_reporting(0);

/*
 *	SESSION
 */
session_start();

/*
 *	CONFIGURATION
 */
$info = json_decode(file_get_contents((in_array(array_pop(explode("/", $_SERVER["REQUEST_URI"])), array("user", "graphs")) ? "../config.json" : "config.json"), FILE_USE_INCLUDE_PATH), true);

/*
 *	LANGUAGE
 */
$lang = json_decode(file_get_contents((in_array(array_pop(explode("/", $_SERVER["REQUEST_URI"])), array("user", "graphs")) ? "../inc/languages/".(isset($_COOKIE["ab-lang"]) ? $_COOKIE["ab-lang"] : $info["default_language"]).".json" : "inc/languages/".(isset($_COOKIE["ab-lang"]) ? $_COOKIE["ab-lang"] : $info["default_language"]).".json"), FILE_USE_INCLUDE_PATH), true)["terms"];

/*
 *	FILES
 */
require((in_array(array_pop(explode("/", $_SERVER["REQUEST_URI"])), array("user", "graphs")) ? "../inc/" : "inc/")."include/database.php");
require((in_array(array_pop(explode("/", $_SERVER["REQUEST_URI"])), array("user", "graphs")) ? "../inc/" : "inc/")."include/info.php");
require((in_array(array_pop(explode("/", $_SERVER["REQUEST_URI"])), array("user", "graphs")) ? "../inc/" : "inc/")."include/classes/pagination.class.php");
require((in_array(array_pop(explode("/", $_SERVER["REQUEST_URI"])), array("user", "graphs")) ? "../inc/" : "inc/")."include/other/date.php");
 
/*
 *	PUNISHMENTS
 */
$punishments = array("all", "ban", "temp_ban", "mute", "temp_mute", "warning", "temp_warning", "kick"); 
if($info["ip_bans"] == true) {
	$punishments[] = "ip_ban";
}
if($info["compact"] == true) {
	$punishments = array("all", "ban", "mute", "warning", "kick");
}