<?php

namespace AdvancedBan\User;

use AdvancedBan;

class Language {
	
	private static $language;
	private static $collection;
	
	private static $discriminator;
	
	public static function initialize(string $discriminator) {
		$data = json_decode(file_get_contents(AdvancedBan::getRoot( ) . "/static/languages/" . $discriminator . ".json"), true);
		
		self::$language = $data["language"];
		self::$collection = $data["collection"];
		
		self::$discriminator = $discriminator;
	}
	
	/*
	public static function setLanguage(string $language) {
		self::$language = $language;
	}
	
	public static function getLanguage( ) {
		return self::$language;
	}
	
	public static function setCollection(array $collection) {
		self::$collection = $collection;
	}
	
	public static function getCollection( ) {
		return self::$collection;
	}
	
	public static function setDiscriminator(string $discriminator) {
		self::$discriminator = $discriminator;
	}
	
	public static function getDiscriminator( ) {
		return self::$discriminator;
	}
	*/
	
	public static function get(string $term, string $default) {
		return isset(self::$collection[$term]) ? self::$collection[$term] : $default;
	}
	
}