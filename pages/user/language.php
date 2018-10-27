<?php

$__root = AdvancedBan::getRoot( );
$__cookie = AdvancedBan::getCookie( );
$__request = AdvancedBan::getRequest( );

if(isset($_GET["set"]) && file_exists($__root . "/static/languages/" . $_GET["set"] . ".json")) {
	$__cookie->set("language", $_GET["set"]);
}
	
if(isset($_GET["default"])) {
	$__cookie->remove("language");
}

$__request->redirect( );
