<?php

$__configuration = AdvancedBans::getConfiguration( );
$__database = AdvancedBans::getDatabase( );

/*
 *	Support legacy version 1.2.5
 *	Table `PunishmentHistory` does not exist
 */

if($__configuration->get(["version"]) === "legacy") {
	$response = [
		"Punishments" => $__database->getData("Punishments")
	];
	
/*
 *	Support beta version 2.1.6
 */
 
} else if($__configuration->get(["version"]) === "beta") {
	$response = [
		"PunishmentHistory" => $__database->getData("PunishmentHistory"),
		"Punishments" => $__database->getData("Punishments")
	];
	
/*
 *	Support stable version 2.1.5
 */
 
} else if($__configuration->get(["version"]) === "stable") {
	$response = [
		"PunishmentHistory" => $__database->getData("PunishmentHistory"),
		"Punishments" => $__database->getData("Punishments")
	];
}

header("Content-Type: application/json");
die( json_encode(isset($response) ? $response : [ ]) );