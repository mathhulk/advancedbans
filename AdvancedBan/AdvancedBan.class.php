<?php

use AdvancedBan\User\Language;
use AdvancedBan\User\Theme;

use AdvancedBan\Storage\Cookie;

use AdvancedBan\Database;
use AdvancedBan\Configuration;
use AdvancedBan\Template;

class AdvancedBan {
	
	private static $root;
	
	public static function initialize(string $root) {
		self::$root = $root;
		
		Database::initialize(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);
		Configuration::initialize( );
		
		Cookie::initialize("AdvancedBan");
		
		Language::initialize(Cookie::get("language") ? Cookie::get("language") : Configuration::get(["default", "language"]));
		Theme::initialize(Cookie::get("theme") ? Cookie::get("theme") : Configuration::get(["default", "theme"]));
		
		self::request( );
	}

	// Better method for handling a request?
	public static function request( ) {
		if(isset($_GET["request"])) {
			if(file_exists(self::$root . "/pages/" . cleanPath($_GET["request"]) . "/index.php")) {
				require_once self::$root . "/pages/" . cleanPath($_GET["request"]) . "/index.php";
			} else if(file_exists(self::$root . "/pages/" . cleanPath($_GET["request"]) . ".php")) {
				require_once self::$root . "/pages/" . cleanPath($_GET["request"]) . ".php";
			} else {
				http_response_code(404);
				
				/*
				require_once self::$root . "/pages/error.php";
				*/
			}
		} else {
			require_once self::$root . "/pages/index.php";
		}
	}
	
	public static function getRoot( ) {
		return self::$root;
	}
	
}
