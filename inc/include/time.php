<?php 

/*
 *	DATE AND TIME
 */
if(!isset($_SESSION["time_zone"])) {
	$_SESSION["time_zone"] = "America/Los_Angeles";
	$geo = json_decode(file_get_contents("http://freegeoip.net/json/".$_SERVER["REMOTE_ADDR"]), true);
	if(isset($geo["time_zone"]) && in_array($geo["time_zone"], timezone_identifiers_list())) {
		$_SESSION["time_zone"] = $geo["time_zone"];
	}
}