<?php

class Scraper {

	private $rake_crud;
	private $rake_helpers;
	
	private $Id;
	private $last_error_msg;
	
	private $scraper_table;
	private $scraper_meta_table;
	private $scraper_user_table;
	
	private $user_table;
	
	public function __construct($id = 0) {
		$this->rake_crud = new RakeCRUD();
		$this->rake_helpers = new RakeHelpers();
		$this->Id = $id;
		$this->last_error_msg = "";
		
		$this->scraper_table = SCRAPERS;
		$this->scraper_meta_table = SCRAPER_META;
		$this->scraper_user_table = SCRAPER_USERS;
		
		$this->user_table = USERS;
		
	}
	
	public function setId($id) {
		 $this->Id = $id;
	}
	
	public function getId() {
		return $this->Id;
	}
	
	public function getLastErrorMsg() {
		return $this->last_error_msg;
	}
	
	public function create($author, $url, $encoding, $nice_name) {
		if($author != "" && $url != "" && $encoding != "" && $nice_name != "") {
			$values = array(
				"scraper_id" => "",
				"scraper_author" => $author,
				"scraper_url" => $url,
				"scraper_encoding" => $encoding,
				"scraper_global_search_pattern" => "",
				"scraper_item_search_pattern" => "",
				"scraper_privacy" => "draft",
				"scraper_description" => "",
				"scraper_date_created" => $this->rake_helpers->currentDate(),
				"scraper_last_edited" => $this->rake_helpers->currentDate(),
				"scraper_thumbnail_url" => "",
				"scraper_nicename" => $nice_name,
				"scraper_output_template" => "",
				"scraper_output_template_global" => ""
			);
			
			$this->Id = $this->rake_crud->_addDatum($this->scraper_table, $this->rake_helpers->arrayToString($values));
						
			$this->addUser($author);
		}
	}
	
	
	
	public function search($keyword, $author = 0) {
		$results_all = $this->rake_crud->_getDataRegEx($this->scraper_table, "*", "scraper_nicename", "lower('".$keyword."')");
		
		$results = array();
		$results_every = array();
		
		foreach($results_all as $result) {
		
			if($result['scraper_privacy'] == "public" || $result['scraper_author'] == $author) {
				$result_id = $result['scraper_id'];
				$result_rating = $this->getTotalRatingById($result_id);
				$results[$result_id] = $result_rating;
				$results_every[$result_id] = $result;
			}
		}
		arsort($results);
		
		$final = array();
		
		foreach ($results as $key => $value) {
			$key_id = $key;
			$final[] = $results_every[$key_id];
			next($results);
		}
		

		return $final;
	}
	
	
	public function changePrivacy($privacy) {
		$results = array();
		$scraper_list = $this->rake_crud->_getDatum($this->scraper_table, "scraper_id", $this->Id, "scraper_id");
		if($scraper_list == null) {
			$this->last_error_msg = "No data found.";
			return false;
		} else {
			$this->rake_crud->_updateDatum($this->scraper_table, "scraper_id", $this->Id, "scraper_privacy", $privacy);
			return true;
		}
	}
	
	public function getScrapersByUser($user_id) {
		$results = array();
		$scraper_list = $this->rake_crud->_getDataByOption($this->scraper_user_table, "scraper_id", "scraper_id", "user_id", $user_id);
		if($scraper_list == null) {
			$this->last_error_msg = "No data found.";
		} else {
			foreach($scraper_list as $scraper) {
				
				$scraper_info = $this->rake_crud->_getDatum($this->scraper_table, "scraper_id", $scraper["scraper_id"], "*");
				if($scraper_info[0]['scraper_privacy'] == "public" || $scraper_info[0]['scraper_author'] == $user_id) {
					$results[$scraper["scraper_id"]] = $scraper_info[0]["scraper_nicename"];
				}
			}
		}
		return $results;
	}
	
	public function getScraperByUserAndScraper($user_id, $scraper_id) {
		$results = null;
		$scraper_list = $this->rake_crud->_getDatumAnd($this->scraper_user_table, "scraper_id", $scraper_id, "user_id", $user_id, "*");
		if($scraper_list == null) {
			$this->last_error_msg = "No data found.";
		} else {
			$results = $scraper_list[0];
		}
		return $results;
	}	
	
	public function setRating($user_id, $rating) {
		$scraper_list = $this->getScraperByUserAndScraper($user_id, $this->Id);
		if($scraper_list == null) {		
		
			$this->last_error_msg = "No data found.";
		} else {
			$scraper_user_id = $scraper_list['scraper_user_id'];
			
			$this->rake_crud->_updateDatum($this->scraper_user_table, "scraper_user_id", $scraper_user_id, "scraper_user_rating", $rating);
		}
	}
	
		
	public function removeUser($user_id) {
		$scraper_list = $this->getScraperByUserAndScraper($user_id, $this->Id);
		if($scraper_list == null) {			
			$this->last_error_msg = "No data found.";
		} else {
			$scraper_user_id = $scraper_list['scraper_user_id'];
			$this->rake_crud->_deleteDatum($this->scraper_user_table, "scraper_user_id", $scraper_user_id);
		}
	}
	
	public function addUser($user_id) {
		$scraper_list = $this->getScraperByUserAndScraper($user_id, $this->Id);
		if($scraper_list == null) {			
			$values = array(
				"scraper_user_id" => "",
				"scraper_id" => $this->Id,
				"user_id" => $user_id,
				"scraper_user_date_started" => $this->rake_helpers->currentDate(),
				"scraper_user_rating" => ""
			);
			$this->rake_crud->_addDatum($this->scraper_user_table, $this->rake_helpers->arrayToString($values));
		} else {
			$this->last_error_msg = "Allready a User.";
		}
	}
	
	public function getTotalRating() {
		$results = null;
		$scraper_list = $this->rake_crud->_getDataByOption($this->scraper_user_table, "scraper_user_rating", "scraper_user_rating", "scraper_id", $this->Id);
		if($scraper_list == null) {
			$this->last_error_msg = "No data found.";
		} else {
			$total = 0;
			foreach($scraper_list as $scraper) {				
				$rating = $scraper["scraper_user_rating"];
				$total = $total + (int)$rating;
			}
			$results = $total;
		}
		return $results;
	}
	
	public function getTotalRatingById($id) {
		$results = null;
		$scraper_list = $this->rake_crud->_getDataByOption($this->scraper_user_table, "scraper_user_rating", "scraper_user_rating", "scraper_id", $id);
		if($scraper_list == null) {
			$this->last_error_msg = "No data found.";
		} else {
			$total = 0;
			foreach($scraper_list as $scraper) {				
				$rating = $scraper["scraper_user_rating"];
				$total = $total + (int)$rating;
			}
			$results = $total;
		}
		return $results;
	}
	
	public function getScraper() {
		$scraper_info = $this->rake_crud->_getDatum($this->scraper_table, "scraper_id", $this->Id, "*");
		if($scraper_info == null) {
			$this->last_error_msg = "No record found.";
			return null;
		} else {

			$author_id = $scraper_info[0]['scraper_author'];
			$user_result = $this->rake_crud->_getDatum($this->user_table, "user_id", $author_id, "user_email");
			$scraper_info[0]['scraper_author_name'] = $user_result[0]['user_email'];
			return $scraper_info[0];
		}
	}
	
	public function delete() {
		$scraper_info = $this->rake_crud->_getDatum($this->scraper_table, "scraper_id", $this->Id, "*");
		if($scraper_info == null) {
			$this->last_error_msg = "No record found.";
			return null;
		} else {
			$this->rake_crud->_deleteDatum($this->scraper_table, "scraper_id", $this->Id);
			$this->rake_crud->_deleteDatum($this->scraper_user_table, "scraper_id", $this->Id);
			return true;
		}
	}
	
	public function setScraper($key, $value) {

		$this->rake_crud->_updateDatum($this->scraper_table, "scraper_id", $this->Id, $key, $value);
	}
	
	
	
	
}