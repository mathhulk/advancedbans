<?php

namespace AdvancedBan;

use AdvancedBan;

class Page {
	
	private $current;
	private $final;
	private $pagination;
	
	public function __construct(int $current, int $list) {
		$this->current = $current;
		
		$this->final = ceil($list / AdvancedBan::getConfiguration( )->getValue("pagination", "limit"));
		if($this->final < 1) {
			$this->final = 1;
		}
		
		if($this->current < (AdvancedBan::getConfiguration( )->getValue("pagination", "pages") - 1) / 2 + 1) {
			$minimum = 1;
			$maximum = AdvancedBan::getConfiguration( )->getValue("pagination", "pages");
		} else if($current > $this->final - (AdvancedBan::getConfiguration( )->getValue("pagination", "pages") - 1)) {
			$minimum = $this->final - (AdvancedBan::getConfiguration( )->getValue("pagination", "pages") - 1); 
			$maximum = $this->final;
		} else {
			$minimum = $current - (AdvancedBan::getConfiguration( )->getValue("pagination", "pages") - 1) / 2; 
			$maximum = $current + (AdvancedBan::getConfiguration( )->getValue("pagination", "pages") - 1) / 2; 
		}
		
		if($maximum > $this->final) {
			$maximum = $this->final;
		}
		
		if($minimum < 1) {
			$minimum = 1;
		}
		
		$this->pagination = range($minimum, $maximum);
	}
	
	public function getCurrent( ) {
		return $this->current;
	}
	
	public function getFinal( ) {
		return $this->final;
	}
	
	public function getPagination( ) {
		return $this->pagination;
	}
	
}