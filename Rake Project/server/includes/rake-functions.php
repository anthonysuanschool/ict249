<?php

class RakeFunctions {

	function __construct() {
	}
	
	function loadFunctions() {
		$files = scandir(FUNCTION_DIR."/");
		foreach($files as $file) {
			if(!($file == "." || $file == "..")) {
				require_once(FUNCTION_DIR."/".$file);
			}
		}
	}
}