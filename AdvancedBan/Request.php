<?php

namespace AdvancedBan;

use AdvancedBan;

class Request {
	
	public static function handle( ) {
		$request = ltrim(rtrim($_GET["request"], "/"), "/");
		
		if(empty($request)) {
			require_once AdvancedBan::getRoot( ) . "/pages/index.php";
		} else if(file_exists(AdvancedBan::getRoot( ) . "/pages/" . $request . ".php")) {
			require_once AdvancedBan::getRoot( ) . "/pages/" . $request . ".php";
		} else {
			http_response_code(404);
			require_once AdvancedBan::getRoot( ) . "/pages/error.php";
		}
	}
	
	public static function respond(int $code, string $status, string $message, array $extra) {
		http_response_code($code);
		header("Content-Type: application/json");
		
		$content = [
			"code"=>$code,
			"status"=>$status,
			"message"=>$message
			];
			
		foreach($extra as $index => $value) {
			$content[$index] = $value;
		}
		
		die(json_encode($content));
	}
	
}