<?php

// LOCAL DATE AND TIME
function getLocalDate($time, $format) {
	$date = new DateTime(gmdate("F jS, Y g:i A", strtotime($time)));
	$date->setTimezone(new DateTimeZone($_SESSION["time_zone"]));
	return $date->format($format);
}

if(!isset($_SESSION["ab-web-addon"]["time_zone"])) {
	$_SESSION["ab-web-addon"]["time_zone"] = $info["default_time_zone"];
	$api = json_decode(file_get_contents("http://freegeoip.net/json/".$_SERVER["REMOTE_ADDR"]), true);
	if(isset($api["time_zone"]) && in_array($api["time_zone"], timezone_identifiers_list( ))) {
		$_SESSION["ab-web-addon"]["time_zone"] = $api["time_zone"];
	}
}