<?php

$__root = AdvancedBans::getRoot( );
$__cookie = AdvancedBans::getCookie( );
$__request = AdvancedBans::getRequest( );

if(isset($_GET["set"]) && file_exists($__root . "/static/themes/" . $_GET["set"] . "/configuration.json")) {
	$__cookie->set("theme", $_GET["set"]);
}

if(isset($_GET["default"])) {
	$__cookie->remove("theme");
}

$__request->redirect( );

