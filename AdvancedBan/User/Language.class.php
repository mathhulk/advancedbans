<?php

namespace AdvancedBan\User;

use AdvancedBan;

class Language {
	
	private static $locale;
	private static $collection;
	
	public static function initialize(string $language) {
		$data = json_decode(file_get_contents(AdvancedBan::getRoot( ) . "/static/languages/" . $language . ".json"), true);
		
		self::$locale = $data["locale"];
		self::$collection = $data["collection"];
	}
	
	/*
	public static function getLocale( ) {
		return self::$locale;
	}
	
	public static function getCollection( ) {
		return self::$collection;
	}
	*/
	
	public static function get(string $term, string $default) {
		return isset(self::$collection[$term]) ? self::$collection[$term] : $default;
	}
	
}