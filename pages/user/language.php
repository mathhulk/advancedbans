<?php

use AdvancedBan\Storage\Cookie;

if(isset($_GET["set"]) && file_exists(AdvancedBan::getRoot( ) . "/static/languages/" . $_GET["set"] . ".json")) {
	Cookie::set("language", $_GET["set"]);
} elseif(isset($_GET["default"])) {
	Cookie::remove("language");
}

header("Location: " . ((AdvancedBan::getConfiguration( ))->get(["mod_rewrite"]) === true ? "../../" : "./")); 
die("Redirecting...");
