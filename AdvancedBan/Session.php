<?php

namespace AdvancedBan;

use AdvancedBan;

class Session {
	
	public static function start( ) {
		session_name(AdvancedBan::getConfiguration( )->getValue("session", "name"));
		session_set_cookie_params(0, "/", $_SERVER["HTTP_HOST"]);
		session_start( );
	}
	
	public static function setValue(string $index, string $value) {
		$_SESSION[$index] = $value;
	}
	
	public function getValue(string $index) {
		return $_SESSION["index"];
	}
	
}