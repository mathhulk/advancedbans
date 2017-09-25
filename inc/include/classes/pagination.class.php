<?php 

class Pagination {
	
	public $key;
	public $multiplier;
	public $total;
	
	public $maximum;
	public $minimum;
	
	public $count;
	public $list;
	
	public $current;
	
	public function __construct($key, $multiplier, $total) {
		$this->key = $key;
		$this->multiplier = $multiplier;
		
		$this->total = floor($total / $this->multiplier);
		if($total % $this->multiplier != 0 || $total = 0) {
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
			$pages["minimum"] = 1; 
			$pages["maximum"] = $length;
		} elseif($this->current > $this->total - ($length - 1)) {
			$pages["minimum"] = $this->total - ($length - 1); 
			$pages["maximum"] = $this->total;
		} else {
			$pages["minimum"] = $this->current - ($length - 1) / 2; 
			$pages["maximum"] = $this->current + ($length - 1) / 2; 
		}
		if($pages["maximum"] > $this->total) {
			$pages["maximum"] = $this->total;
			
		}
		if($pages["minimum"] < 1) {
			$pages["minimum"] = 1;
			
		}
		for(; $pages["minimum"] <= $pages["maximum"]; ++$pages["minimum"]) {
			$response[] = $pages["minimum"];
		}
		return $response;
	}
	
}

?>