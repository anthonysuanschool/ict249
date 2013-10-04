<?php

class ScraperService {

	private $scraper;
	private $macro;
	
	public  function __construct() {
		$this->scraper = new Scraper();
		
	}
	
	public  function search($param) {
	
		$error_msg = "none";		
		$status = true;
		
		
		$result_array = $this->scraper->search($param->keyword, $param->user_id) ;
		
		$result = array();
		foreach($result_array as $result_item) {
			$result[$result_item['scraper_id']] = $result_item['scraper_nicename'];
		}
		
		$data = array(
			"Status" => $status,
			"Result" => $result,
			"Error" => $error_msg
		);		
		return json_encode($data);
	}
	
	public function getScrapersByUser($param) {
	
		$error_msg = "none";		
		$status = true;		
		
		$result_array = $this->scraper->getScrapersByUser($param->user) ;
		
		if($result_array == null) {
			$status = false;
			$result = "";
			$error_msg = $this->scraper->getLastErrorMsg();
			
		} else {
			$result = $result_array;
		}
		
		$data = array(
			"Status" => $status,
			"Result" => $result,
			"Error" => $error_msg
		);		
		return json_encode($data);
	}
	
	public function getScraperByUserAndScraper($param) {
		
		$error_msg = "none";		
		$status = true;	
		
		$result_array =  $this->scraper->getScraperByUserAndScraper($param->user_id, $param->scraper_id);
		
		if($result_array == null) {
			$status = false;
			$result = "";
			$error_msg = $this->scraper->getLastErrorMsg();
			
		} else {
			$result = $result_array;
		}
		
		$data = array(
			"Status" => $status,
			"Result" => $result,
			"Error" => $error_msg
		);		
		return json_encode($data);
		
	}
	
	public function changePrivacy($param) {
		$error_msg = "none";		
		$status = true;		
		$result = "";
		$this->scraper->setId($param->scraper_id);
		
		$result_array = $this->scraper->changePrivacy($param->privacy) ;
		
		if($result_array == false) {
			$status = false;
			$result = "";
			$error_msg = $this->scraper->getLastErrorMsg();
			
		} 
		
		$data = array(
			"Status" => $status,
			"Result" => $result,
			"Error" => $error_msg
		);		
		return json_encode($data);
	}
	
	public function getScraper($param) {
		$error_msg = "none";		
		$status = true;		
		
		$this->scraper->setId($param->id);
		
		$result_array = $this->scraper->getScraper() ;
		
		if($result_array == null) {
			$status = false;
			$result = "";
			$error_msg = $this->scraper->getLastErrorMsg();
			
		} else {
			$result = $result_array;
			$html = "";			
			@$html = file_get_contents($result_array['scraper_url']);
			$result['source'] = $html;
		}
		
		$data = array(
			"Status" => $status,
			"Result" => $result,
			"Error" => $error_msg
		);		
		return json_encode($data);
		
	}
	
	public function setScraper($param) {
		$error_msg = "none";		
		$status = true;		
		
		$this->scraper->setId($param->id);
		
		$result_array = $this->scraper->setScraper($param->key, $param->value) ;	
		
		$data = array(
			"Status" => $status,
			"Result" => "",
			"Error" => $error_msg
		);		
		return json_encode($data);
	}
	
	public function setRating($param) {
		$error_msg = "none";		
		$status = true;		
		
		$this->scraper->setId($param->scraper_id);
		
		$result_array = $this->scraper->setRating($param->user_id, $param->rating) ;	
		
		$data = array(
			"Status" => $status,
			"Result" => "",
			"Error" => $error_msg
		);		
		return json_encode($data);
	}
	
	public function removeUser($param) {
		$error_msg = "none";		
		$status = true;		
		
		$this->scraper->setId($param->scraper_id);
		
		$result_array = $this->scraper->removeUser($param->user_id) ;	
		
		$data = array(
			"Status" => $status,
			"Result" => "",
			"Error" => $error_msg
		);		
		return json_encode($data);
	}
	
	public function addUser($param) {
		$error_msg = "none";		
		$status = true;		
		
		$this->scraper->setId($param->scraper_id);
		
		$result_array = $this->scraper->addUser($param->user_id) ;	
		
		$data = array(
			"Status" => $status,
			"Result" => "",
			"Error" => $error_msg
		);		
		return json_encode($data);
	}
	
	public function delete($param) {
		$error_msg = "none";		
		$status = true;		
		
		$this->scraper->setId($param->scraper_id);
		
		$result_array = $this->scraper->delete() ;	
		
		$data = array(
			"Status" => $status,
			"Result" => "",
			"Error" => $error_msg
		);		
		return json_encode($data);
	}
	
	public function getGlobalInformation($param) {
		$error_msg = "none";		
		$status = true;		
		
		$this->scraper->setId($param->id);		
		
		$result_array = $this->scraper->getScraper() ;			
		
		$html_src['pattern_global'] = $result_array['scraper_global_search_pattern'];
		$html_src['pattern_item'] = $result_array['scraper_item_search_pattern'];
		$html_src['url'] = $result_array['scraper_url'];
		$html_src['output_template'] = $result_array['scraper_output_template'];
		$html_src['output_template_global'] = $result_array['scraper_output_template_global'];
		
		$this->macro = new RakeMacro($html_src);
		
		$this->macro->filter();
		
		$result = $this->macro->getGlobalInformation();
		
		
		$data = array(
			"Status" => $status,
			"Result" => $result,
			"Error" => $error_msg
		);		
		return json_encode($data);
	}
	
	public function getItemInformation($param) {
		$error_msg = "none";		
		$status = true;		
		
		$this->scraper->setId($param->id);
		
		$result_array = $this->scraper->getScraper() ;	
		
		$html_src['pattern_global'] = $result_array['scraper_global_search_pattern'];
		$html_src['pattern_item'] = $result_array['scraper_item_search_pattern'];
		$html_src['url'] = $result_array['scraper_url'];
		$html_src['output_template'] = $result_array['scraper_output_template'];
		$html_src['output_template_global'] = $result_array['scraper_output_template_global'];
		
		$this->macro = new RakeMacro($html_src);
		
		$this->macro->filter();
		
		$result = $this->macro->getItemInformation();
		
		
		$data = array(
			"Status" => $status,
			"Result" => $result,
			"Error" => $error_msg
		);		
		return json_encode($data);
	}
	
	public function create($param) {
	
		$error_msg = "none";		
		$status = true;		
		$result = 0;
		
		if(strpos($param->url, "http://") == false)
			$param->url = "http://" . $param->url;
		
		
		if (filter_var($param->url, FILTER_VALIDATE_URL) === FALSE) {
			$error_msg = "Invalid URL.";
			$status = false;
		}
		
		
		
		if($param->encoding == "") {
			@$html = file_get_contents($param->url);
			if($html == FALSE) {
				$error_msg = "Invalid URL.";
				$status = false;
			}
			$html = str_replace("\n","",$html);
			$get_doctype = preg_match_all('/.*?<meta charset="(.*?)".*?\/>.*?/s',$html,$matches);
			
			
			if($matches == null)
				@$param->encoding = "UTF-8";
			else
				@$param->encoding = $matches[1][0];
				
			if($param->encoding == "")
				@$param->encoding = "UTF-8";
		}
		
		if($param->nice_name == "") {
			$error_msg = "Name is Blank.";
			$status = false;
		}
		
	
	
		if($status) {		
			
			$this->scraper->create($param->author, $param->url, $param->encoding, $param->nice_name);
			
			$result_array = $this->scraper->getScraper();
			//print_r($result_array);
			$result = $result_array;
			$html = "";			
			@$html = file_get_contents($result_array['scraper_url']);
			$result['source'] = $html;
		
			if($result == 0) {
				$status = false;
				$error_msg = "An error occured while creating a scrape.";
			
			} 
		}
		
		$data = array(
			"Status" => $status,
			"Result" => $result,
			"Error" => $error_msg
		);		
		return json_encode($data);
	}
	
	
	
	
	
}
	