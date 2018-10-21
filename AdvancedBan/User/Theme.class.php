<?php

namespace AdvancedBan\User;

use AdvancedBan\Template;
use AdvancedBan;

class Theme {
	
	private $theme;
	private $creator;
	
	private $discriminator;
	
	public function __construct(string $discriminator) {
		$data = json_decode(file_get_contents(AdvancedBan::getRoot( ) . "/static/themes/" . $discriminator . "/configuration.json"), true);
		
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
	
	public function load(string $template, string $type) {
		$template = new Template($template, ["file"]);
		
		foreach(glob(AdvancedBan::getRoot( ) . "/static/themes/" . $this->discriminator . "/" . $type . "/*") as $file) {
			echo $template->replace(["static/themes/" . $this->discriminator . "/" . $type . "/" . basename($file)]);
		}
	}
	
}