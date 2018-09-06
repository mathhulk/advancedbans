<?php

if(!empty($_GET["set"]) && file_exists("include/themes/" . $_GET["set"])) {
	setcookie("advancedban-panel_theme", $_GET["set"], time( ) + (30 * 60 * 60 * 24), "/");
} elseif(isset($_GET["default"])) {
	setcookie("advancedban-panel_theme", "", time( ) - (30 * 60 * 60 * 24), "/");
}

header("Location: " . ($__public["mod_rewrite"] === true ? "../../" : "./")); die("Redirecting...");
