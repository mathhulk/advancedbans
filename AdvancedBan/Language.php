<?php

namespace AdvancedBan;

use AdvancedBan\Configuration;
use AdvancedBan\Cookie;
use AdvancedBan;

class Language {
	
	private static $identifier;
	private static $name;
	private static $translation;

	public static function load( ) {
		$template = new Configuration("/include/languages/template.json");
		$default = new Configuration("/include/languages/" . AdvancedBan::getConfiguration( )->getValue("default", "language") . "/language.json");
		
		if(Cookie::getValue("language")) {
			$cookie = new Configuration("/include/languages/" . Cookie::getValue("language") . "/language.json");
		}
		
		if(Cookie::getValue("language") && array_keys($cookie->getDictionary( )) === array_keys($template->getDictionary( ))) {
			self::$identifier = Cookie::getValue("language");
			self::$name = $cookie->getValue("name");
			self::$translation = $cookie->getValue("translation");
		} else if(array_keys($default->getDictionary( )) === array_keys($template->getDictionary( ))) {
			self::$identifier = AdvancedBan::getConfiguration( )->getValue("default", "language");
			self::$name = $default->getValue("name");
			self::$translation = $default->getValue("translation");
		} else {
			self::$translation = $template->getValue("translation");
		}
	}
	
	public static function getValue(string $index) {
		return self::$translation[$index];
	}
	
	public static function getName( ) {
		return self::$name;
	}
	
	public static function getIdentifier( ) {
		return self::$identifier;
	}
	
	public static function getDictionary( ) {
		return self::$translation;
	}

}