<?php

class RakeAPI {

	private $user_service;
	private $scraper_service;
	
	function __construct() {
		$this->user_service = new UserService();
		$this->scraper_service = new ScraperService();
	}
	
	function query($data) {
		
		$data_array = json_decode($data);

		
		$service = $data_array->Service;
		$method = $data_array->Method;
		$param = $data_array->Parameters;
		
		if($service == "User") {
			if($method == "authenticate")
				echo $this->user_service->authenticate($param);
				
			else if($method == "create")
				echo $this->user_service->create($param);
				
			else if($method == "requestPasswordChange")
				echo $this->user_service->requestPasswordChange($param);
				
			else if($method == "changePassword")
				echo $this->user_service->changePassword($param);
				
			else
			;
		} else if($service == "Scraper") {
			if($method == "search")
				echo $this->scraper_service->search($param);
				
			else if($method == "getScrapersByUser")
				echo $this->scraper_service->getScrapersByUser($param);
				
			else if($method == "getScraper")
				echo $this->scraper_service->getScraper($param);
				
			else if($method == "setScraper")
				echo $this->scraper_service->setScraper($param);
				
			else if($method == "getGlobalInformation")
				echo $this->scraper_service->getGlobalInformation($param);
				
			else if($method == "getItemInformation")
				echo $this->scraper_service->getItemInformation($param);
			
			else if($method == "getScraperByUserAndScraper")
				echo $this->scraper_service->getScraperByUserAndScraper($param);
				
			else if($method == "setRating")
				echo $this->scraper_service->setRating($param);
				
			else if($method == "changePrivacy")
				echo $this->scraper_service->changePrivacy($param);
				
			else if($method == "removeUser")
				echo $this->scraper_service->removeUser($param);
				
			else if($method == "addUser")
				echo $this->scraper_service->addUser($param);
				
			else if($method == "delete")
				echo $this->scraper_service->delete($param);
			
			else if($method == "create")
				echo $this->scraper_service->create($param);
			else
			;
		}
		
	}
}
	