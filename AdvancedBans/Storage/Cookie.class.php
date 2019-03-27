<?php

namespace AdvancedBans\Storage;

class Cookie {
	
	private $prefix;
	
	public function __construct(string $prefix) {
		$this->prefix = $prefix;
		
		return $this;
	}
	
	public function getPrefix( ) {
		return $this->prefix;
	}
	
	public function get(string $cookie) {
		return isset($_COOKIE[$this->prefix . "_" . $cookie]) ? $_COOKIE[$this->prefix . "_" . $cookie] : false;
	}
	
	public function set(string $cookie, string $value) {
		setCookie($this->prefix . "_" . $cookie, $value, time( ) + 3600 * 3600, "/");
	}
	
	public function remove(string $cookie) {
		setCookie($this->prefix . "_" . $cookie, "", time( ) - 3600 * 3600, "/");
	}
	
}