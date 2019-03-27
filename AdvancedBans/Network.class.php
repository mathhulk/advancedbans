<?php

namespace AdvancedBans;

use AdvancedBans;

class Network {
	
	private $host;
	private $path;
	
	public function __construct(string $url) {
		$url = parse_url($url);
		
		$this->host = $url["host"];
		$this->path = $url["path"];
		
		return $this;
	}
	
	public function getHost( ) {
		return $this->host;
	}
	
	public function getPath( ) {
		return $this->path;
	}
	
	public function send( ) {
		$request = curl_init("https://" . $this->host . $this->path);
		
		curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($request, CURLOPT_POSTFIELDS, "website=" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);

		curl_exec($request);
		curl_close($request);
		
		return $this;
	}
	
}