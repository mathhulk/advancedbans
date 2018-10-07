<?php

use AdvancedBan\Storage\Cookie;

use AdvancedBan\Configuration;

// Better method for handling user selection and redirection?
if(isset($_GET["set"]) && file_exists(AdvancedBan::getRoot( ) . "/static/languages/" . $_GET["set"] . ".json")) {
	Cookie::set("language", $_GET["set"]);
} elseif(isset($_GET["default"])) {
	Cookie::remove("language");
}

header("Location: " . (Configuration::get(["mod_rewrite"]) === true ? "../../" : "./")); 
die("Redirecting...");
