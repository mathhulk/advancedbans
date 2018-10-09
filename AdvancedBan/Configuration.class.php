<?php

namespace AdvancedBan;

use AdvancedBan;

class Configuration {
	
	private static $collection;
	
	public static function initialize( ) {
		$data = json_decode(file_get_contents(AdvancedBan::getRoot( ) . "/static/configuration.json"), true);
		
		self::$collection = $data;
	}
	
	/*
	public static function setCollection(array $collection) {
		self::$collection = $collection;
	}
	
	public static function getCollection( ) {
		return self::$collection;
	}
	*/
	
	public static function get(array $indices) {
		$value = self::$collection[array_shift($indices)];
		
		foreach($indices as $index) {
			$value = $value[$index];
		}
		
		return $value;
	}
	
}