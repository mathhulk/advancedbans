<?php

$__root = AdvancedBan::getRoot( );
$__cookie = AdvancedBan::getCookie( );
$__request = AdvancedBan::getRequest( );

if(isset($_GET["set"]) && file_exists($__root . "/static/themes/" . $_GET["set"] . "/configuration.json")) {
	$__cookie->set("theme", $_GET["set"]);
}

if(isset($_GET["default"])) {
	$__cookie->remove("theme");
}

$__request->redirect( );

