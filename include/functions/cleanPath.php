<?php

function cleanPath(string $path) {
	return trim(str_replace(".", "", $path), "/");
}