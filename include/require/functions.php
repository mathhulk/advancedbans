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
	if($GLOBALS["__public"]["compact"] === true) return array("all", "ban", "mute", "warning", "kick");
	else if($GLOBALS["__public"]["ip_ban"] === true) return array("all", "ban", "temp_ban", "mute", "temp_mute", "warning", "temp_warning", "kick", "ip_ban");
	return array("all", "ban", "temp_ban", "mute", "temp_mute", "warning", "temp_warning", "kick");
}

function getLocale($index, $default) {
	return isset($GLOBALS["__language"]["terms"][$index]) ? $GLOBALS["__language"]["terms"][$index] : $default; 
}

function fetchResult($page, $date, $name, $punishmentType, $operator, $reason) {
	$parameters = [ ];
	$query = "SELECT * FROM " . $GLOBALS["__private"]["connection"]["table"]["log"];
	
	if($name || $punishmentType || $date || $operator || $reason || $GLOBALS["__public"]["ip_ban"] === false) $query .= " WHERE 1 = 1";
	
	if($name) {
		$query .= " AND name = ?";
		$parameters[ ] = $name;
	}
		
	if($reason) {
		$query .= " AND reason LIKE ?";
		$parameters[ ] = "%" . $reason . "%";
	}
	
	if($operator) {
		$query .= " AND operator = ?";
		$parameters[ ] = $operator;
	}
	
	if($punishmentType && $GLOBALS["__public"]["compact"] === true) {
		$query .= " AND punishmentType LIKE ?";
		$parameters[ ] = "%" . strtoupper($punishmentType) . "%";
	} else if($punishmentType) {
		$query .= " AND punishmentType = ?";
		$parameters[ ] = strtoupper($punishmentType);
	}
	
	if($date) {
		$query .= " AND start BETWEEN FROM_UNIXTIME(?) AND FROM_UNIXTIME(?)";
		array_push($parameters, strtotime("-" . $date . " days"), strtotime("-" . ($date - 1) . " days"));
	}
	
	if($GLOBALS["__public"]["ip_ban"] === false) $query .= " AND punishmentType != 'IP_BAN'";
	
	$query .= " ORDER BY id DESC";
	
	if($page) {
		$query .= " LIMIT ?, 25";
		$parameters[ ] = 25 * ($page - 1);
	}
	
	$statement = $GLOBALS["__connection"]->prepare($query);
	$statement->execute($parameters);

	return $statement;
}

function isActive($start, $end) {
	if(!isset($GLOBALS["__log"])) $GLOBALS["__log"] = $GLOBALS["__connection"]->query("SELECT * FROM " . $GLOBALS["__private"]["connection"]["table"]["punishment"])->fetchAll( );
	foreach($GLOBALS["__log"] as $index => $value) {
		if($value["start"] === $start && $value["end"] === $end) return true;
	}
	return false;
}