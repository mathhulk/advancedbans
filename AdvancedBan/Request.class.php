<?php

namespace AdvancedBan;

use AdvancedBan;

class Request {
	
	private static $path;
	
	public static function initialize(string $path) {
		if(empty($path)) {
			require_once AdvancedBan::getRoot( ) . "/pages/index.php";
			
			self::$path = "index.php";
		} else if(file_exists(AdvancedBan::getRoot( ) . "/pages/" . clean($path) . "/index.php")) {
			require_once AdvancedBan::getRoot( ) . "/pages/" . clean($path) . "/index.php";
			
			self::$path = clean($path) . "/index.php";
		} else if(file_exists(AdvancedBan::getRoot( ) . "/pages/" . clean($path) . ".php")) {
			require_once AdvancedBan::getRoot( ) . "/pages/" . clean($path) . ".php";
			
			self::$path = clean($path) . ".php";
		} else {
			http_response_code(404);
			
			self::$path = false;
		}
	}
	
	public static function getPath( ) {
		return self::$path;
	}
	
}