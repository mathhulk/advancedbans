<?php 

/*
 *	CLASS: PAGINATION
 */

class Pagination {
	
	public $key;
	public $multiplier;
	public $total;
	
	public $maximum;
	public $minimum;
	
	public $count;
	public $list;
	
	public $current;
	
	private $pages;
	
	public function __construct($key, $multiplier, $total) {
		$this->key = $key;
		$this->multiplier = $multiplier;
		
		$this->total = floor($total / $this->multiplier);
		if($total % $this->multiplier != 0 || $total == 0) {
			++$this->total;
		}
		
		$this->count = 0;
		
		if(isset($_GET[$this->key]) && is_numeric($_GET[$this->key])) {
			$this->minimum = ($_GET[$this->key] - 1) * $this->multiplier;
			$this->maximum = $this->minimum + $multiplier;
			
			$this->current = $_GET[$this->key];
		} else {
			$this->minimum = 0;
			$this->maximum = $this->multiplier;
			
			$this->current = 1;
		}
	}
	
	public function pages($length) {
		if($this->current < ($length - 1) / 2 + 1) {
			$this->pages["minimum"] = 1; 
			$this->pages["maximum"] = $length;
		} elseif($this->current > $this->total - ($length - 1)) {
			$this->pages["minimum"] = $this->total - ($length - 1); 
			$this->pages["maximum"] = $this->total;
		} else {
			$this->pages["minimum"] = $this->current - ($length - 1) / 2; 
			$this->pages["maximum"] = $this->current + ($length - 1) / 2; 
		}
		if($this->pages["maximum"] > $this->total) {
			$this->pages["maximum"] = $this->total;
			
		}
		if($this->pages["minimum"] < 1) {
			$this->pages["minimum"] = 1;
			
		}
		for(; $this->pages["minimum"] <= $this->pages["maximum"]; ++$this->pages["minimum"]) {
			$response[] = $this->pages["minimum"];
		}
		return $response;
	}
	
}
