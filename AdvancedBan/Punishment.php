<?php

namespace AdvancedBan;

use AdvancedBan;
use AdvancedBan\External\PtcQueryBuilder;
use AdvancedBan\Constraint;

class Punishment {
	
	public static function count(array $conditions) {
		$conditions = self::filter($conditions);
		
		$statement = new PtcQueryBuilder(AdvancedBan::getDatabase( ));
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$statement->table(DATABASE_TABLE_HISTORY);
		
		foreach($conditions as $index => $value) {
			$statement->where($index, "LIKE", $value);
		}
		
		return count($statement->run( ));
	}
	
	public static function fetch(array $conditions, int $page) {
		$conditions = self::filter($conditions);
		
		$statement = new PtcQueryBuilder(AdvancedBan::getDatabase( ));
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$statement->table(DATABASE_TABLE_HISTORY);
		$statement->order("id", "DESC");
		
		foreach($conditions as $index => $value) {
			$statement->where($index, "LIKE", $value);
		}
		
		$minimum = 0;
		$limit = Constraint::LIMIT_MAXIMUM;
		if($page > 0) {
			$minimum = ($page - 1) * AdvancedBan::getConfiguration( )->getValue("pagination", "limit") + 1;
			$limit = AdvancedBan::getConfiguration( )->getValue("pagination", "limit");
		}
		
		$statement->limit($minimum, $limit);
		
		$results = $statement->run( );
		
		foreach($results as $index => $value) {
			$statement = new PtcQueryBuilder(AdvancedBan::getDatabase( ));
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$statement->table(DATABASE_TABLE);
			
			$conditions = $value;
			unset($conditions["id"]);
			
			foreach($conditions as $item => $object) {
				$statement->where($item, "=", $object);
			}
			
			$results[$index]["active"] = false;
			if($statement->run( )) {
				$results[$index]["active"] = true;
			}
		}
		
		return $results;
	}
	
	private static function filter(array $conditions) {
		foreach($conditions as $index => $value) {
			if(!in_array($index, Constraint::FILTER)) {
				unset($conditions[$index]);
			}
		}
		return $conditions;
	}

}