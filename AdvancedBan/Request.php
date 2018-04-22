<?php

namespace AdvancedBan;

use AdvancedBan;

class Request {
	
	public static function handle( ) {
		$request = ltrim(rtrim($_GET["request"], "/"), "/");
		
		if(empty($request)) {
			require_once AdvancedBan::getRoot( ) . "/content/index.php";
		} else if(file_exists(AdvancedBan::getRoot( ) . "/content/" . $request . ".php")) {
			require_once AdvancedBan::getRoot( ) . "/content/" . $request . ".php";
		} else {
			http_response_code(404);
			require_once AdvancedBan::getRoot( ) . "/content/error.php";
		}
	}
	
	public static function respond(int $code, string $status, string $message, array $extra) {
		http_response_code($code);
		
		$response = [
			"code"=>$code,
			"status"=>$status,
			"message"=>$message
			];
			
		foreach($extra as $index => $value) {
			$response[$index] = $value;
		}
		
		die(json_encode($response));
	}
	
}