<?php

use AdvancedBans\User\Language;
use AdvancedBans\User\Theme;

use AdvancedBans\Storage\Cookie;

use AdvancedBans\Database;
use AdvancedBans\Configuration;
use AdvancedBans\Template;
use AdvancedBans\Request;
use AdvancedBans\Network;

class AdvancedBans {
	
	private static $root;
	
	private static $database;
	private static $configuration;
	
	private static $cookie;
	
	private static $language;
	private static $theme;
	
	private static $network;
	
	private static $request;
	
	public static function initialize(string $root) {
		self::$root = $root;
		
		self::$database = new Database(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);
		self::$configuration = new Configuration("/static/configuration.json");
		
		self::$cookie = new Cookie("AdvancedBan");
		
		self::$language = new Language( self::$cookie->get("language") ? self::$cookie->get("language") : self::$configuration->get(["default", "language"]) );
		self::$theme = new Theme( self::$cookie->get("theme") ? self::$cookie->get("theme") : self::$configuration->get(["default", "theme"]) );
		
		self::$network = new Network("https://mathhulk.me/advancedbans/global/");
		
		self::$request = new Request(isset($_GET["request"]) ? $_GET["request"] : "/");
		
		if( self::$request->getAbsolute( ) ) require_once self::$request->getAbsolute( );
		else http_response_code(404);
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
	
	public static function getCookie( ) {
		return self::$cookie;
	}
	
	public static function getLanguage( ) {
		return self::$language;
	}
	
	public static function getTheme( ) {
		return self::$theme;
	}
	
	public static function getNetwork( ) {
		return self::$network;
	}
	
	public static function getRequest( ) {
		return self::$request;
	}
	
}
