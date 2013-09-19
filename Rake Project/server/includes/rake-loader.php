<?php

class RakeLoader {

	function __construct() {
	}
	
	function fileGetContents($url) {
		$contents = file_get_contents($url);
		return $contents;
	}
	
	function replaceShortcode ($search, $replace, $string) {
		return str_replace($search, $replace, $string);
	}
	
	function findShortcode($source) {
		preg_match_all(
			'/.*?{{(.*?)}}.*?/s',
			$source,
			$matches,
			PREG_SET_ORDER
		);
		
		
		if($matches != null) {
			
			foreach($matches as $match) {
				$shortcode = $match[0];
				$value = $match[1];
				$value_array = explode("=", $value);
			
				if($value_array[0] == "template") {				
					$template_path = TEMPLATE_DIR . "/" . $value_array[1];				
					$result = $this->fileGetContents($template_path);					
					$result = $this->findShortcode($result);					
					$source = $this->replaceShortcode ($shortcode, $result, $source);
				} 
			}
			
		}
		
		return $source;
	}
}