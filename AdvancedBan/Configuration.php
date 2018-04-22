<?php

namespace AdvancedBan;

use AdvancedBan;

class Configuration {
	
	private $configuration;
	
	public function __construct(string $path) {
		$this->configuration = json_decode(file_get_contents(AdvancedBan::getRoot( ) . $path), true);
	}
	
	public function getValue( ) {
		$arguments = func_get_args( );
		
		if(func_num_args( ) == 0) {
			return false;
		} else {
			while(count($arguments) > 0) {
				if(isset($index)) {
					$index = $index[array_shift($arguments)];
				} else {
					$index = $this->configuration[array_shift($arguments)];
				}
			}
			return $index;
		}
	}
	
	public function getDictionary( ) {
		return $this->configuration;
	}
	
}