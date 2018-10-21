<?php

namespace AdvancedBan\User;

use AdvancedBan;

class Language {
	
	private $language;
	private $collection;
	
	private $discriminator;
	
	public function __construct(string $discriminator) {
		$data = json_decode(file_get_contents(AdvancedBan::getRoot( ) . "/static/languages/" . $discriminator . ".json"), true);
		
		$this->language = $data["language"];
		$this->collection = $data["collection"];
		
		$this->discriminator = $discriminator;
		
		return $this;
	}
	
	public function getLanguage( ) {
		return $this->language;
	}
	
	public function getCollection( ) {
		return $this->collection;
	}
	
	public function getDiscriminator( ) {
		return $this->discriminator;
	}
	
	public function get(string $term, string $default) {
		return isset($this->collection[$term]) ? $this->collection[$term] : $default;
	}
	
}