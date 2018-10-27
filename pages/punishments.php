<?php

$__database = AdvancedBan::getDatabase( );

$response = json_encode([
	"PunishmentHistory" => $__database->getData("PunishmentHistory"),
	"Punishments" => $__database->getData("Punishments")
]);

die($response);