<?php

// namespace

use AdvancedBan\Database;
use AdvancedBan\Request;
use AdvancedBan\Session;
use AdvancedBan\Configuration;
use AdvancedBan\Language;
use AdvancedBan\Theme;
use AdvancedBan\UserCache;
use AdvancedBan\Usage;

class AdvancedBan {
	
	private static $root;
	private static $configuration;
	private static $database;
	
	public static function initialize(string $root) {
		self::$root = $root;
		self::$configuration = new Configuration("/include/configuration.json");
		self::$database = new Database(DATABASE_HOST, DATABASE_NAME, DATABASE_USER, DATABASE_PASSWORD);
		
		Session::start( );
		Language::load( );
		Theme::load( );
		UserCache::load( );
		Usage::report( );
		
		Request::handle( );
	}
	
	public static function getRoot( ) {
		return self::$root;
	}
	
	public static function getConfiguration( ) {
		return self::$configuration;
	}
	
	public static function getDatabase( ) {
		return self::$database;
	}
	
}