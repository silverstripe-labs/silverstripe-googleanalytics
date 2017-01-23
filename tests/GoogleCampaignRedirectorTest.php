<?php

class GoogleCampaignRedirectorTest extends SapphireTest {
	static $fixture_file = 'GoogleCampaignRedirectorTest.yml';
	static $use_draft_site = true;

	public function testCampaignUrlBuilding() {
		$this->assertEquals("http://www.example.com/?a=b&utm_source=source&utm_medium=medium&utm_campaign=name&utm_term=term&utm_content=content", $this->objFromFixture('GoogleCampaignRedirector','witheverything')->redirectionLink());
	}
	
	public function testPartialCampaignUrlBuilding() {
		$this->assertEquals(Director::baseURL() . 'redirection-dest/?utm_source=source&utm_medium=medium&utm_campaign=name', $this->objFromFixture('GoogleCampaignRedirector','withminimalfields')->redirectionLink());
	}
}