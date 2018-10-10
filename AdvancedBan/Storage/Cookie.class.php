<?php

namespace AdvancedBan\Storage;

class Cookie {
	
	private static $prefix;
	
	public static function initialize(string $prefix) {
		self::$prefix = $prefix;
	}
	
	/*
	public static function setPrefix(string $prefix) {
		self::$prefix = $prefix;
	}
	
	public static function getPrefix( ) {
		return self::$prefix;
	}
	*/
	
	public static function get(string $cookie) {
		return isset($_COOKIE[self::$prefix . "_" . $cookie]) ? $_COOKIE[self::$prefix . "_" . $cookie] : false;
	}
	
	public static function set(string $cookie, string $value) {
		setCookie(self::$prefix . "_" . $cookie, $value, time( ) + 3600 * 3600, "/");
	}
	
	public static function remove(string $cookie) {
		setCookie(self::$prefix . "_" . $cookie, "", time( ) - 3600 * 3600, "/");
	}
	
}