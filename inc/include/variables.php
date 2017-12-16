<?php

/*
 *	VARIABLES
 */
 
$__global = array(

	// Do not touch this unless you really want to break something.
	"version"=>"3.0.1",
	
	// MySQL Connection
	"mysql"=>array(
	
		// Connection : Host
		"host"=>"localhost",
		
		// User : Username
		"user"=>"username",
		
		// User: Password
		"password"=>"password",
		
		// Connection : Database
		"database"=>"database"
		
		),
		
	// Do not touch this unless you know what you are doing. ({UUID} and {USERNAME} are placeholders)
	"api"=>array(
		
		// API : Skull
		"skull"=>"https://visage.surgeplay.com/head/48/{UUID}",
		
		// API : Body
		"body"=>"https://visage.surgeplay.com/full/512/{UUID}",
		
		// API : UUID
		"uuid"=>"https://mcapi.cloudprotected.net/uuid/{USERNAME}"
		
		)
		
	);