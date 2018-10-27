<?php

namespace AdvancedBan\User;

use AdvancedBan\Template;
use AdvancedBan;

class Theme {
	
	private $theme;
	private $creator;
	
	private $discriminator;
	
	public function __construct(string $discriminator) {
		$__root = AdvancedBan::getRoot( );
		
		$data = json_decode(file_get_contents($__root . "/static/themes/" . $discriminator . "/configuration.json"), true);
		
		$this->theme = $data["theme"];
		$this->creator = $data["creator"];
		
		$this->discriminator = $discriminator;
		
		return $this;
	}
	
	public function getTheme( ) {
		return $this->theme;
	}
	
	public function getCreator( ) {
		return $this->$creator;
	}
	
	public function getDiscriminator( ) {
		return $this->discriminator;
	}
	
	public function get(string $template, string $type) {
		$__root = AdvancedBan::getRoot( );
		
		$response = " ";
		$template = new Template($template, ["file"]);
		
		foreach(glob($__root . "/static/themes/" . $this->discriminator . "/" . $type . "/*") as $file) {
			$response .= $template->replace(["static/themes/" . $this->discriminator . "/" . $type . "/" . basename($file)]);
		}
		
		return $response;
	}
	
}