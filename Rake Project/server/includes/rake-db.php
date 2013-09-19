<?php

class RakeDB {
	
	private $link;
	private $db_selected;
	
	function __construct() {
	}
	
	function connect() {
		 $this->link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
		 if (!$this->link) 
			return false;
		else
			return true;
	}
	
	function close() {
		mysql_close($this->link);
	}
	
	function selectDB() {
		$this->db_selected = mysql_select_db(DB_NAME, $this->link);
		if (!$this->db_selected) 
			return false;
		else
			return true;
	}
	
	function query( $query ) {
		$result = mysql_query($query, $this->link);
	}
	
	function get_results( $query = null) {
		$output = array();
		$result = mysql_query($query, $this->link) or die(mysql_error());

		while ($row = mysql_fetch_assoc($result)) {
			$output[] = $row;
		}
		
		return $output;
	}
	
}