<?php

namespace AdvancedBan;

use AdvancedBan;
use AdvancedBan\Constraint;

class Usage {
	
	public static function report( ) {
		if(AdvancedBan::getConfiguration( )->getValue("settings", "usage", "report") == true) {
			file_get_contents("https://mathhulk.me/github/ab-web-addon/report/?uri=" . urlencode($_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]));
		}
	}
	
	public static function update( ) {
		if(AdvancedBan::getConfiguration( )->getValue("settings", "usage", "update") == true) {
			$api = json_decode(file_get_contents("https://api.spiget.org/v2/resources/34078/versions?size=1000"), true);
			
			if($api[count($api) - 1]["name"] == Constraint::VERSION) {
				return false;
			} else {
				return $api[count($api) - 1]["name"];
			}
		}
	}
	
}