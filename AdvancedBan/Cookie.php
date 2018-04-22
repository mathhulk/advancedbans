<?php

namespace AdvancedBan;

use AdvancedBan\Configuration;

class Cookie {
	
	public static function setValue(string $index, string $value) {
		setcookie(AdvancedBan::getConfiguration( )->getValue("cookie", "prefix") . base64_encode($index), base64_encode($value), 2147483647, "/", $_SERVER["HTTP_HOST"]);
	}
	
	public static function getValue(string $index) {
		return isset($_COOKIE[$index]) ? $_COOKIE[$index] : false;
	}
	
	public static function remove(string $index) {
		setcookie(AdvancedBan::getConfiguration( )->getValue("cookie", "prefix") . base64_encode($index), "", 0, "/", $_SERVER["HTTP_HOST"]);
	}
	
}