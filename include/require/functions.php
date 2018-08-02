<?php

// FUNCTIONS
function cleanPath($path) {
	return trim(str_replace(".", "", $path), "/");
}

function getLocale($index, $default) {
	return isset($GLOBALS["__language"]["terms"][$index]) ? $GLOBALS["__language"]["terms"][$index] : $default; 
}