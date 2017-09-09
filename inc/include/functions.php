<?php

/*
 *	FUNCTIONS
 */
function formatDate($format, $ms) {
	$date = new DateTime(gmdate("F jS, Y g:i A", $ms / 1000));
	$date->setTimezone(new DateTimeZone($_SESSION["time_zone"]));
	return $date->format($format);
}