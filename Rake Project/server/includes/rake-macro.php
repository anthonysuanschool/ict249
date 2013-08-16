<?php

class RakeMacro {

	private $pattern_global;
	private $pattern_item;
	private $url;
	private $scrape;
	
	
	public function __construct($html_rss) {
		$this->pattern_global = $html_rss['pattern_global'];
		$this->pattern_item = $html_rss['pattern_item'];
		$this->url = $html_rss['url'];
		@$this->scrape = file_get_contents($this->url);
	}
	
	
	public function replaceNewLineWithSpace($string) {
		return preg_replace("/[\\n\\r]+/", " ", $string);
	}
	
	public function replaceNewLineWithNone($string) {
		return preg_replace("/[\\n\\r]+/", " ", $string);
	}
	
	public function replaceSpaceWithExpressionNevermine($string) {
		return preg_replace("/[\\n\\r]+/", ".*?", $string);
	}
	
	public function replaceMacroNevermineWithExpressionNevermine($string) {
		return str_replace("{*}", ".*?", $string);
	}
	
	public function replaceMacroSelectionWithExpressionSelection($string) {
		return str_replace("{*}", ".*?", $string);
	}
	
	public function matchPattern() {
		
	}
	
	public function getItems() {
	
		//echo $this->scrape;
		
		//echo $this->pattern_global;
		//die();
		
		
	}
	
	
}