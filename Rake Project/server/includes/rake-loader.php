<?php

class RakeLoader {

	function __construct() {
	}
	
	function fileGetContents($url) {
		$contents = file_get_contents('http://www.example.com/');
		return $contents;
	}
	
	function replaceShortcode () {
		
	}
}