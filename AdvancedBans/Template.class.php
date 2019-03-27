<?php

namespace AdvancedBans;

use AdvancedBans;

class Template {
	
	private $template;
	private $indices;
	
	public function __construct(string $template, array $indices) {
		$__root = AdvancedBans::getRoot( );
		
		$data = file_get_contents($__root . "/static/templates/internal/" . $template . ".txt");
		
		$this->template = $data;
		
		foreach($indices as $index => $value) $indices[$index] = "{{ " . $value . " }}";
		
		$this->indices = $indices;
		
		return $this;
	}
	
	public function getTemplate( ) {
		return $this->template;
	}
	
	public function getIndices( ) {
		return $this->indices;
	}
	
	public function replace(array $values) {
		$template = $this->template;
		
		foreach($values as $index => $value) $template = str_replace($this->indices[$index], $value, $template);
		
		return $template;
	}
	
}