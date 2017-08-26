<?php

/*
 *	ERRORS
 */
error_reporting(0);
 
/*
 *	MYSQL CONNECTION (host, user, password, database)
 */
if(mysqli_connect_errno()) {
	die('Failed to connect to database: '.mysqli_connect_error);
}

/*
 *	PAGINATION
 */
$page = array('max'=>10, 'min'=>0, 'number'=>1, 'posts'=>0, 'count'=>0); 
if(isset($_GET['p']) && is_numeric($_GET['p'])) {
	$page = array('max'=>$_GET['p']*10,'min'=>($_GET['p'] - 1)*10,'number'=>$_GET['p'],'posts'=>0,'count'=>0); 
}

/*
 *	CONFIGURATION
 */
$info = json_decode(file_get_contents((in_array(array_pop(explode("/", $_SERVER['REQUEST_URI'])), array("user", "graphs")) ? "../config.json" : "config.json"), FILE_USE_INCLUDE_PATH), true);
$lang = json_decode(file_get_contents((in_array(array_pop(explode("/", $_SERVER['REQUEST_URI'])), array("user", "graphs")) ? "../language/".$info['language'].".json" : "language/".$info['language'].".json"), FILE_USE_INCLUDE_PATH), true)["terms"];
$types = array('all','ban','temp_ban','mute','temp_mute','warning','temp_warning','kick'); 
if($info['ip-bans'] == true) {
	$types[] = 'ip_ban';
}
if($info['compact'] == true) {
	$types = array('all','ban','mute','warning','kick');
}

/*
 *	DATE AND TIME
 */
if(!isset($_SESSION['time_zone'])) {
	$_SESSION['time_zone'] = "America/Los_Angeles";
	$tz_api = json_decode(file_get_contents('http://freegeoip.net/json/'.$_SERVER['REMOTE_ADDR']), true);
	if(isset($tz_api['time_zone']) && in_array($tz_api['time_zone'], timezone_identifiers_list())) {
		$_SESSION['time_zone'] = $tz_api['time_zone'];
	}
}

/*
 *	FUNCTIONS
 */
function formatDate($format, $ms) {
	$date = new DateTime(gmdate("F jS, Y g:i A", $ms / 1000));
	$date->setTimezone(new DateTimeZone($_SESSION['time_zone']));
	return $date->format($format);
}