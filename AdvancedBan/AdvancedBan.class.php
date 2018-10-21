<?php

use AdvancedBan\User\Language;
use AdvancedBan\User\Theme;

use AdvancedBan\Storage\Cookie;

use AdvancedBan\Database;
use AdvancedBan\Configuration;
use AdvancedBan\Template;
use AdvancedBan\Request;

class AdvancedBan {
	
	private static $root;
	
	private static $database;
	private static $configuration;
	
	private static $language;
	private static $theme;
	
	public static function initialize(string $root) {
		self::$root = $root;
		
		self::$database = new Database(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);
		self::$configuration = new Configuration("/static/configuration.json");
		
		Cookie::initialize("AdvancedBan");
		
		self::$language = new Language(Cookie::get("language") ? Cookie::get("language") : self::$configuration->get(["default", "language"]));
		self::$theme = new Theme(Cookie::get("theme") ? Cookie::get("theme") : self::$configuration->get(["default", "theme"]));
		
		Request::initialize(isset($_GET["request"]) ? $_GET["request"] : "/");
	}
	
	public static function getRoot( ) {
		return self::$root;
	}
	
	public static function getDatabase( ) {
		return self::$database;
	}
	
	public static function getConfiguration( ) {
		return self::$configuration;
	}
	
	public static function getLanguage( ) {
		return self::$language;
	}
	
	public static function getTheme( ) {
		return self::$theme;
	}
	
}
