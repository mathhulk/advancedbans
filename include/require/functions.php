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

function fetchResult($category, $username, $day) {
	$query = "SELECT * FROM " . $GLOBALS["__private"]["connection"]["table"]["log"];
	
	if($username || $category || $day || $GLOBALS["__public"]["ip_ban"] === false) $query .= " WHERE 1 = 1";
	
	if($username) $query .= " AND (name = '" . $username . "' OR operator = '" . $username . "')";
	if($category && $GLOBALS["__public"]["compact"] === true) $query .= " AND punishmentType LIKE '%" . strtoupper($category) . "%'";
	else if($category) $query .= " AND punishmentType = '" . strtoupper($category) . "'";
	if($day) $query .= " AND start BETWEEN FROM_UNIXTIME(" . strtotime("-" . $day . " days") . ") AND FROM_UNIXTIME(" . strtotime("-" . ($day - 1) . " days") . ")";
	if($GLOBALS["__public"]["ip_ban"] === false) $query .= " AND punishmentType != 'IP_BAN'";

	return mysqli_query($GLOBALS["__connection"], $query . " ORDER BY id DESC");
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