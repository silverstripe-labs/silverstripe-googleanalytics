<?php

class GoogleCampaignRedirector extends RedirectorPage {
	public static $db = array(
		"CampaignSource" => "Text",
		"CampaignMedium" => "Text",
		"CampaignTerm" => "Text",
		"CampaignContent" => "Text",
		"CampaignName" => "Text"
	);
	
	public static $defaults = array(
		"ShowInMenus" => 0,
		"ShowInSearch" => 0
	);
	
	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Main', new LiteralField("ga_heading", "<hr /><h2>Google Analytics Campaign Settings</h2>"));
		$fields->addFieldToTab('Root.Main', new TextField('CampaignSource'));
		$fields->addFieldToTab('Root.Main', new TextField('CampaignMedium'));
		$fields->addFieldToTab('Root.Main', new TextField('CampaignTerm'));
		$fields->addFieldToTab('Root.Main', new TextField('CampaignContent'));
		$fields->addFieldToTab('Root.Main', new TextField('CampaignName'));
		
		return $fields;
	}
	
	public function getQueryString() {
		$cs = urlencode($this->CampaignSource);
		$cm = urlencode($this->CampaignMedium);
		$cn = urlencode($this->CampaignName);
		$ret = "utm_source=$cs&utm_medium=$cm&utm_campaign=$cn";
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
}

class GoogleCampaignRedirector_Controller extends RedirectorPage_Controller {
	
	public function init() {
		if($link = self::addQueryString($this->redirectionLink(),$this->getQueryString())) {
			$this->redirect($link, 301);
			return;
		}
	}
	
	public static function addQueryString($link, $query){
		if(strpos("?", $link) === FALSE){
			return "$link?$query";
		} else {
			return "$link&$query";
		}
	}
}