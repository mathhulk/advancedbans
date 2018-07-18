<?php

// FUNCTIONS
function cleanPath($path) {
	return trim(str_replace(".", "", $path), "/");
}

function convertDateTime($time, $format) {
	$date = new DateTime(gmdate("F jS, Y g:i A", strtotime($time)));
	$date->setTimezone(new DateTimeZone($_SESSION["ab-web-addon"]["time_zone"]));
	return $date->format($format);
}

function getCategories( ) {
	if($GLOBALS["__public"]["compact"] === true) $punishments = array("all", "ban", "mute", "warning", "kick");
	else if($GLOBALS["__public"]["ip_ban"] === true) return array("all", "ban", "temp_ban", "mute", "temp_mute", "warning", "temp_warning", "kick", "ip_ban");
	return array("all", "ban", "temp_ban", "mute", "temp_mute", "warning", "temp_warning", "kick");
}

function getLocale($index, $default) {
	return isset($GLOBALS["__language"]["terms"][$index]) ? $GLOBALS["__language"]["terms"][$index] : $default; 
}

function fetchResult($category) {
	if($category && $GLOBALS["__public"]["compact"] === true && $GLOBALS["__public"]["ip_ban"] === true) {
		return mysqli_query($GLOBALS["__connection"], "SELECT * FROM " . $GLOBALS["__private"]["connection"]["table"]["log"] . " WHERE punishmentType LIKE '%" . strtoupper($category) . "%' ORDER BY id DESC");
	} else if($category && $GLOBALS["__public"]["compact"] === true) {
		return mysqli_query($GLOBALS["__connection"], "SELECT * FROM " . $GLOBALS["__private"]["connection"]["table"]["log"] . " WHERE punishmentType LIKE '%" . strtoupper($category) . "%' AND punishmentType != 'IP_BAN' ORDER BY id DESC");
	} else if($category && $GLOBALS["__public"]["ip_ban"] === true) {
		return mysqli_query($GLOBALS["__connection"], "SELECT * FROM " . $GLOBALS["__private"]["connection"]["table"]["log"] . " WHERE punishmentType = '" . strtoupper($category) . "' ORDER BY id DESC");
	} else if($category) {
		return mysqli_query($GLOBALS["__connection"], "SELECT * FROM " . $GLOBALS["__private"]["connection"]["table"]["log"] . " WHERE punishmentType = '" . strtoupper($category) . "' AND punishmentType != 'IP_BAN' ORDER BY id DESC");	
	} else if($GLOBALS["__public"]["ip_ban"] === true) {
		return mysqli_query($GLOBALS["__connection"], "SELECT * FROM " . $GLOBALS["__private"]["connection"]["table"]["log"] . " ORDER BY id DESC");
	} else {
		return mysqli_query($GLOBALS["__connection"], "SELECT * FROM " . $GLOBALS["__private"]["connection"]["table"]["log"] . " WHERE punishmentType != 'IP_BAN' ORDER BY id DESC");
	}
}

function getUuid($username) {
	$api = json_decode(file_get_contents("https://mcapi.cloudprotected.net/uuid/" . $username), true);
	return isset($api["result"][0]["uuid"]) ? $api["result"][0]["uuid"] : "8667ba71b85a4004af54457a9734eed7";
}

function getSkull($uuid, $size) {
	return "https://mc-heads.net/head/" . $uuid . "/" . $size;
}

function getBody($uuid) {
	return "https://mc-heads.net/body/" + $uuid;
}

function isActive($start, $end) {
	if(!isset($GLOBALS["__log"])) $GLOBALS["__log"] = mysqli_fetch_all(mysqli_query($GLOBALS["__connection"], "SELECT * FROM " . $GLOBALS["__private"]["connection"]["table"]["punishment"]), MYSQLI_ASSOC);
	foreach($GLOBALS["__log"] as $index => $value) {
		if($value["start"] === $start && $value["end"]) return true;
	}
	return false;
}