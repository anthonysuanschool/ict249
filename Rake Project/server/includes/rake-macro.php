<?php

class RakeMacro {

	private $pattern_global;
	private $pattern_item;
	private $url;
	private $output;
	private $output_global;
	
	private $scrape;
	
	
	public function __construct($html_rss) {
		$this->pattern_global = $html_rss['pattern_global'];
		$this->pattern_item = $html_rss['pattern_item'];
		$this->url = $html_rss['url'];
		$this->output = $html_rss['output_template'];
		$this->output_global = $html_rss['output_template_global'];
		
		@$this->scrape = file_get_contents($this->url);
	}
	

	
	public function replaceSpaces($string, $item) {
		return preg_replace("/ +/", $item, $string);
	}
	
	public function replaceNewlines($string, $item) {
		return preg_replace("/[\\n\\r]+/", $item, $string);
	}
	
	public function replaceTabs($string, $item) {
		return preg_replace("/[\\t\\r]+/", $item, $string);
	}
	
	public function clean($string, $item) {
		return preg_replace("/\s+/", $item, $string);
	}
	
	public function replaceExclude($string, $item) {
		return preg_replace("/%x%/", $item, $string);
	}
	
	public function replaceInclude($string, $item) {
		return preg_replace("/%o%/", $item, $string);
	}
	
	public function escape($string) {
		return str_replace("/", "\/", $string);
	}
	
	public function filter() {
		
		$this->pattern_global = $this->clean($this->pattern_global, ".*?");
		$this->pattern_global = $this->escape($this->pattern_global);
		
		$this->pattern_global = $this->replaceExclude($this->pattern_global, ".*?");
		$this->pattern_global = $this->replaceInclude($this->pattern_global, "(.*?)");
		
		$this->pattern_item = $this->clean($this->pattern_item, ".*?");
		$this->pattern_item = $this->escape($this->pattern_item);
		
		$this->pattern_item = $this->replaceExclude($this->pattern_item, ".*?");
		$this->pattern_item = $this->replaceInclude($this->pattern_item, "(.*?)");
		
	}
	

	
	public function getGlobalInformation() {
	
		$posts = null;
		
		if($this->pattern_global != "" || $this->pattern_global == null) {
			preg_match_all("/".$this->pattern_global."/s",
				$this->scrape,
				$posts, // will contain the blog posts
				PREG_SET_ORDER // formats data into an array of posts
			);
		} else
			$posts = null;

		if($posts != null) {
		
			$result = '<div class="preview_container">';	
		
			$global_items = $posts[0];
			$iter = 0;
		
			$result_item = "";
		
			foreach($global_items as $global_item) {
			
				if($iter != 0) {
					$result_item  = "<h1>".$global_item."</h1>";
					$result .= $result_item;
				}
				
				$iter++;
			}
		
		
			
		
			$result .= '</div>';
	
		} else
			$result = '<div class="preview_container">No Data Available.</div>';	
		
		return $result;
	}
	
	public function getItemInformation() {

		$posts = null;
	
			preg_match_all("/".$this->pattern_item."/s",
				$this->scrape,
				$posts, // will contain the blog posts
				PREG_SET_ORDER // formats data into an array of posts
			);		
		
		
		if($posts != null) {
		
			$result = '<div class="preview_container">';		
		
			foreach($posts as $post) {			
			
				$result_item = '<div class="item_preview_container">';
				$result_item .= $this->output;
			
				$global_items = $post;
				$iter = 0;
				foreach($global_items as $global_item) {
			
					if($iter != 0) {
						$result_item = str_replace("%".$iter."%", $global_item, $result_item);
					}
					$iter++;
				}				
			
				$result_item .= '</div>';
			
				$result .= $result_item;
			
			}
		
			$result .= '</div>';
		}
		else
			$result = '<div class="preview_container">No Data Available.</div>';	
		
		
		return $result;
		
	}
	
	public function getGlobalPattern() {
		return $this->pattern_global;
	}
	
	public function getItemPattern() {
		return $this->pattern_item;
	}
	
	public function getScrape() {
		return $this->scrape;
	}
	
	public function getURL() {
		$this->url;
	}
	
	
}