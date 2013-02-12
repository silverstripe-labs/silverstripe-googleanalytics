<?php

class GoogleCampaignRedirector extends RedirectorPage {
	
	/*
	 * The standard campaign tracking codes available
	 */
	public static $db = array(
		"CampaignSource" => "Text",
		"CampaignMedium" => "Text",
		"CampaignTerm" => "Text",
		"CampaignContent" => "Text",
		"CampaignName" => "Text"
	);
	
	/*
	 * Typically, these won't form part of a menu.
	 */
	public static $defaults = array(
		"ShowInMenus" => 0,
		"ShowInSearch" => 0
	);
	
	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Main', new LiteralField("ga_heading", "<hr /><h2>Google Analytics Campaign Settings</h2>"));
		//TODO: Add a description of the /meaning/ of these to help users (or link through to Google's docs?)
		$fields->addFieldToTab('Root.Main', new TextField('CampaignSource'));
		$fields->addFieldToTab('Root.Main', new TextField('CampaignMedium'));
		$fields->addFieldToTab('Root.Main', new TextField('CampaignTerm'));
		$fields->addFieldToTab('Root.Main', new TextField('CampaignContent'));
		$fields->addFieldToTab('Root.Main', new TextField('CampaignName'));
		return $fields;
	}
	
	/**
	 * For a given request, get the GA-ready query string that can be appended
	 */
	public function getQueryString() {
		//These three are required no matter what
		$cs = urlencode($this->CampaignSource);
		$cm = urlencode($this->CampaignMedium);
		$cn = urlencode($this->CampaignName);
		$ret = "utm_source=$cs&utm_medium=$cm&utm_campaign=$cn";
		
		//The next two are optional so let's only set them if there's a value there.
		if($this->CampaignTerm){
			$ct = urlencode($this->CampaignTerm);
			$ret .= "&utm_term=$ct";
		}
		if($this->CampaignContent){
			$cc = urlencode($this->CampaignContent);
			$ret .= "&utm_content=$cc";
		}
		return $ret;
	}
	
	/**
	 * @override
	 * @return the link with query string
	 */
	public function redirectionLink() {
		if($link = parent::redirectionLink()) {
			return self::addQueryString($link,$this->getQueryString());
		}
		return null;
	}
	
	/**
	 * Helper function to add a query string to a URL in different ways depending on
	 * the original URL. I.e. avoid example.com?a=b&c=d?e=f&g=h
	 */
	private static function addQueryString($link, $query){
		if(strpos($link, "?") === FALSE){
			return "$link?$query";
		} else {
			return "$link&$query";
		}
	}
}

class GoogleCampaignRedirector_Controller extends RedirectorPage_Controller {
	
}