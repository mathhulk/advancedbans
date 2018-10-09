<?php

namespace AdvancedBan\User;

use AdvancedBan\Template;
use AdvancedBan;

class Theme {
	
	private static $theme;
	private static $creator;
	
	private static $discriminator;
	
	public static function initialize(string $discriminator) {
		$data = json_decode(file_get_contents(AdvancedBan::getRoot( ) . "/static/themes/" . $discriminator . "/configuration.json"), true);
		
		self::$theme = $data["theme"];
		self::$creator = $data["creator"];
		
		self::$discriminator = $discriminator;
	}
	
	/*
	public static function getTheme( ) {
		return self::$theme;
	}
	
	public static function getCreator( ) {
		return self::$creator;
	}
	
	public static function getDiscriminator( ) {
		return self::$discriminator;
	}
	*/
	
	public static function loadStatic(string $template, string $type) {
		$template = new Template($template, ["file"]);
		
		foreach(glob(AdvancedBan::getRoot( ) . "/static/themes/" . self::$discriminator . "/" . $type . "/*") as $file) {
			echo $template->replace(["static/themes/" . self::$discriminator . "/" . $type . "/" . basename($file)]);
		}
	}
	
}