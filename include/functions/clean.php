<?php

function clean(string $path) {
	return trim(str_replace(".", " ", $path), "/");
}