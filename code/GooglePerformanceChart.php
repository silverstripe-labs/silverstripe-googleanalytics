<?php

class GooglePerformanceChart extends Compositefield {

	protected $page;

	function __construct($page = null) {
		parent::__construct();
		switch(true) {
			case $page instanceof SiteTree: $this->page = $page; break;
			case is_numeric($page): $page = SiteTree::get()->byID((int)$page); break;
		}
	}

	function FieldHolder($properties = array()) {
		return $this->renderWith('GooglePerformanceChart');
	}

	function PageID() {
		if($this->page) return $this->page->ID;
	}
}