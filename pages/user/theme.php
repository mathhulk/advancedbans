<?php

use AdvancedBan\Storage\Cookie;

use AdvancedBan\Configuration;

// Better method for handling user selection and redirection?
if(isset($_GET["set"]) && file_exists(AdvancedBan::getRoot( ) . "/static/themes/" . $_GET["set"] . "/configuration.json")) {
	Cookie::set("theme", $_GET["set"]);
} elseif(isset($_GET["default"])) {
	Cookie::remove("theme");
}

header("Location: " . (Configuration::get(["mod_rewrite"]) === true ? "../../" : "./")); 
die("Redirecting...");
