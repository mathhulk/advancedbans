<?php

namespace AdvancedBans;

use AdvancedBans;

class Request {
	
	private $relative;
	
	public function __construct(string $path) {
		$__root = AdvancedBans::getRoot( );
		
		$path = clean($path);
		
		if( empty($path) ) $this->relative = "index.php";
		else if( file_exists($__root . "/pages/" . $path . "/index.php") ) $this->relative = $path . "/index.php";
		else if( file_exists($__root . "/pages/" . $path . ".php") ) $this->relative = $path . ".php";
		else $this->relative = false;
		
		return $this;
	}
	
	public function getRelative( ) {
		return $this->relative;
	}
	
	public function getAbsolute( ) {
		if($this->relative) {
			$__root = AdvancedBans::getRoot( );
		
			return $__root . "/pages/" . $this->relative;
		} else {
			return false;
		}
	}
	
	public function redirect( ) {
		$__configuration = AdvancedBans::getConfiguration( );
		
		if($__configuration->get(["mod_rewrite"]) === true) {
			$location = "./";
			$depth = count( explode("/", $this->relative) );
			
			for($i = 0; $i < $depth; $i++) $location .= "../";
			
			header("Location: " . $location);
			die("Redirecting...");
		} else {
			header("Location: ./");
			die("Redirecting...");
		}
	}
	
}