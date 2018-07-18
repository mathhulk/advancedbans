<?php

if(!empty($_GET["set"]) && file_exists("include/themes/" . $_GET["set"])) {
	setcookie("ab-web-addon_theme", $_GET["set"], time( ) + (30 * 60 * 60 * 24), "/");
} elseif(isset($_GET["default"])) {
	setcookie("ab-web-addon_theme", "", time( ) - (30 * 60 * 60 * 24), "/");
}

header("Location: ../../" . (isset($_GET["redirect"]) ? $_GET["redirect"] : "")); die("Redirecting...");