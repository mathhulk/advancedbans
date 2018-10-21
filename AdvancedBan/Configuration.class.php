<?php

namespace AdvancedBan;

use AdvancedBan;

class Configuration {
	
	private $collection;
	
	public function __construct(string $path) {
		$data = json_decode(file_get_contents(AdvancedBan::getRoot( ) . $path), true);
		
		$this->collection = $data;
		
		return $this;
	}
	
	public function getCollection( ) {
		return $this->collection;
	}
	
	public function get(array $indices) {
		$value = $this->collection[array_shift($indices)];
		
		foreach($indices as $index) {
			$value = $value[$index];
		}
		
		return $value;
	}
	
}