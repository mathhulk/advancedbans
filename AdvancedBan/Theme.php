<?php

namespace AdvancedBan;

use AdvancedBan\Configuration;
use AdvancedBan\Cookie;
use AdvancedBan;

class Theme {
	
	private static $identifier;
	private static $name;
	private static $author;
	
	public static function load( ) {
		$template = new Configuration("/include/themes/template/theme.json");
		$default = new Configuration("/include/themes/" . AdvancedBan::getConfiguration( )->getValue("default", "theme") . "/theme.json");
		
		if(Cookie::getValue("theme")) {
			$cookie = new Configuration("/include/themes/" . Cookie::getValue("theme") . "/theme.json");
		}
		
		if(Cookie::getValue("theme") && array_keys($cookie->getDictionary( )) === array_keys($template->getDictionary( ))) {
			self::$identifier = Cookie::getValue("language");
			self::$name = $cookie->getValue("name");
			self::$author = $cookie->getValue("author");
		} else if(array_keys($default->getDictionary( )) === array_keys($template->getDictionary( ))) {
			self::$identifier = AdvancedBan::getConfiguration( )->getValue("default", "language");
			self::$name = $default->getValue("name");
			self::$author = $default->getValue("author");
		} else {
			self::$identifier = "template";
		}
	}
	
	public static function insertCSS( ) {
		foreach(new DirectoryIterator(AdvancedBan::getRoot( ) . "include/themes/" . self::getIdentifier( ) . "/stylesheets") as $stylesheet) {
			?>
			<link rel="stylesheet" type="text/css" href="include/themes/<?= self::getIdentifier( ) ?>/css/<?= $stylesheet ?>">
			<?php
		}
	}
	
	public static function insertJavaScript( ) {
		foreach(new DirectoryIterator(AdvancedBan::getRoot( ) . "include/themes/" . self::getIdentifier( ) . "/scripts") as $stylesheet) {
			?>
			<script type="text/javascript" src="include/themes/<?= self::getIdentifier( ) ?>/js/<?= $stylesheet ?>"></script>
			<?php
		}
	}
	
	public static function getName( ) {
		return self::$name;
	}
	
	public static function getIdentifier( ) {
		return self::$identifier;
	}
	
	public static function getAuthor( ) {
		return self::$author;
	}
	
}