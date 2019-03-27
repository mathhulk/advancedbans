<?php

namespace AdvancedBans;

use PDO;

class Database {
	
	private $host;
	private $user;
	private $password;
	private $database;
	
	private $connection;
	
	public function __construct(string $host, string $user, string $password, string $database) {
		$this->host = $host;
		$this->user = $user;
		$this->password = $password;
		$this->database = $database;
		
		$this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database . ";port=3306;charset=utf8mb4", $this->user, $this->password);
		$this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		
		return $this;
	}
	
	public function getHost( ) {
		return $this->host;
	}
	
	public function getUser( ) {
		return $this->user;
	}
	
	public function getPassword( ) {
		return $this->password;
	}
	
	public function getLanguage( ) {
		return $this->database;
	}
	
	public function getConnection( ) {
		return self::$connection;
	}
	
	public function getData(string $table) {
		$statement = $this->connection->query("SELECT * FROM " . $table);
		
		return $statement ? $statement->fetchAll(PDO::FETCH_ASSOC) : [ ];
	}
	
}