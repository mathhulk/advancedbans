<?php

namespace AdvancedBan;

use AdvancedBan;

class Asset {

	public static function getStylesheet(string $file) {
		$content = self::get(AdvancedBan::getRoot( ) . "/")
	}
	
	public static function get(string $path) {
		$content = file_get_contents($path);
		
		$content = str_replace("{{configuration.api.server.path}}", implode(", ", AdvancedBan::getConfiguration( )->getValue("api", "server", "path")), $content);
		$content = str_replace("{{configuration.api.server.uri}}", str_replace("{{ip}}", AdvancedBan::getConfiguration( )->getValue("settings", "server", "ip"), str_replace("{{port}}", AdvancedBan::getConfiguration( )->getValue("settings", "server", "port"), AdvancedBan::getConfiguration( )->getValue("api", "server", "path"))), $content);
		$content = str_replace("{{configuration.settings.server.show}}", AdvancedBan::getConfiguration( )->getValue("settings", "server", "show"), $content);
		$content = str_replace("{{configuration.settings.server.ip}}", AdvancedBan::getConfiguration( )->getValue("settings", "server", "ip"), $content);
		$content = str_replace("{{configuration.settings.server.port}}", AdvancedBan::getConfiguration( )->getValue("settings", "server", "port"), $content);
		
		return $content;
	}

}