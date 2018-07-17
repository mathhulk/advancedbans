<?php

// FUNCTIONS
function getPath($string) {
	return trim(str_replace(".", "", $string), "/");
}