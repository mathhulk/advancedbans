<?php

if(!empty($_GET["set"]) && file_exists("include/languages/" . $_GET["set"] . ".json")) {
	setcookie("advancedban-panel_language", $_GET["set"], time( ) + (30 * 60 * 60 * 24), "/");
} elseif(isset($_GET["default"])) {
	setcookie("advancedban-panel_language", "", time( ) - (30 * 60 * 60 * 24), "/");
}

header("Location: ../../" . (isset($_GET["redirect"]) ? $_GET["redirect"] : "")); die("Redirecting...");