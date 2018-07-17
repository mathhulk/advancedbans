<?php

/*
 *	LANGUAGES
 */
 
if(isset($_GET["change"]) && !empty($_GET["change"]) && file_exists("inc/languages/".$_GET["change"].".json") && json_decode(file_get_contents("inc/languages/".$_GET["change"].".json"), true)["version"] == $__global["version"]) {
	setcookie("ab-lang", $_GET["change"], time() + (30 * 60 * 60 * 24), "/");
} elseif(isset($_GET["reset"]) && $_GET["reset"] == "true") {
	setcookie("ab-lang", "", time() - (30 * 60 * 60 * 24), "/");
}
header("Location: ".(isset($_GET["redirect"]) ? $_GET["redirect"] : "./")); die("Redirecting...");