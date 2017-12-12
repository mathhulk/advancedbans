<?php

/*
 *	THEMES
 */
 
if(isset($_GET["change"]) && !empty($_GET["change"]) && file_exists("inc/themes/".$_GET["change"]."/config.json") && json_decode(file_get_contents("inc/themes/".$_GET["change"]."/config.json"), true)["version"] == $__global["version"]) {
	setcookie("ab-theme", $_GET["change"], time() + (30 * 60 * 60 * 24), "/");
} elseif(isset($_GET["reset"]) && $_GET["reset"] == "true") {
	setcookie("ab-theme", "", time() - (30 * 60 * 60 * 24), "/");
}
header("Location: ".(isset($_GET["redirect"]) ? $_GET["redirect"] : "./")); die("Redirecting...");