<?php

namespace AdvancedBan;

use AdvancedBan;

class Database extends \PDO {
	
	public function __construct(string $host, string $name, string $user, string $password) {
		parent::__construct("mysql:host=".$host.";dbname=".$name.";charset=utf8mb4", $user, $password, [\PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION, \PDO::ATTR_DEFAULT_FETCH_MODE=>\PDO::FETCH_ASSOC, \PDO::ATTR_EMULATE_PREPARES=>false]);
	}
	
}