<?php

namespace AdvancedBan;

use AdvancedBan;

class UserCache {
	
	private static $cache;
	
	public static function load( ) {
		self::$cache = json_decode(file_get_contents(AdvancedBan::getRoot( ) . "/cache/user.json"), true);
	}
	
	public static function setUser(string $username) {
		$api = json_decode(file_get_contents(str_replace("{{username}}", $username, AdvancedBan::getConfiguration( )->getValue("api", "uuid", "uri"))), true);
		$path = AdvancedBan::getConfiguration( )->getValue("api", "uuid", "path");
		
		if(count($path) == 0) {
			$uuid = $api;
		} else {
			while(count($path) > 0) {
				if($index) {
					$index = $index[array_shift($path)];
				} else {
					$index = $api[array_shift($path)];
				}
			}
			$uuid = $index;
		}
		
		self::$cache[$username]["uuid"] = $uuid;
		self::$cache[$username]["time"] = time( );
		
		file_put_contents(AdvancedBan::getRoot( ) . "/cache/user.json", json_encode(self::$cache));
	}
	
	public static function getUser(string $username) {
		if(time( ) - self::$cache[$username]["time"] > AdvancedBan::getConfiguration( )->getValue("cache", "time")) {
			setUser($username);
		}
		return self::$cache[$username]["uuid"];
	}
	
}