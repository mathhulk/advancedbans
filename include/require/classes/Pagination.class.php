<?php 

class Pagination {
	
	public $page;
	public $limit;
	public $results;
	
	public $pages;
	
	public $count = 0;
	
	public $minimum;
	public $maximum;
	
	private $pagination;
	
	public function __construct($page = 1, $limit = 10, $results) {
		if($limit > 100) $limit = 100;
		
		$this->limit = $limit;
		$this->results = $results;
		
		$this->pages = floor($results / $limit);
		if($results % $limit != 0 || $results == 0) ++$this->pages;
		
		if(is_numeric($page)) {
			$this->minimum = ($page - 1) * $limit;
			$this->maximum = $this->minimum + $limit;
			
			$this->page = intval($page);
		} else {
			$this->minimum = 0;
			$this->maximum = $limit;
			
			$this->page = 1;
		}
	}
	
	public function getPages($length) {
		if($this->page < ($length - 1) / 2 + 1) {
			$this->pagination["minimum"] = 1; 
			$this->pagination["maximum"] = $length;
		} elseif($this->page > $this->pages - ($length - 1)) {
			$this->pagination["minimum"] = $this->pages - ($length - 1); 
			$this->pagination["maximum"] = $this->pages;
		} else {
			$this->pagination["minimum"] = $this->page - ($length - 1) / 2; 
			$this->pagination["maximum"] = $this->page + ($length - 1) / 2; 
		}
		
		if($this->pagination["maximum"] > $this->pages) $this->pagination["maximum"] = $this->pages;
		if($this->pagination["minimum"] < 1) $this->pagination["minimum"] = 1;
		
		$this->pagination["list"] = array( );
		
		for(; $this->pagination["minimum"] <= $this->pagination["maximum"]; ++$this->pagination["minimum"]) $this->pagination["list"][ ] = $this->pagination["minimum"];
		
		return $this->pagination["list"];
	}
	
}