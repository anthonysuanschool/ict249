<?php

class RakeCRUD {

	private $rakedb;
	
	function __construct() {
		$this->rakedb = new RakeDB();
		$this->rakedb->connect();
		$this->rakedb->selectDB();
	}
	
	public function _getData($table_name, $field_name, $ordered) {
		$sql = "select ".$field_name." from ".$table_name." order by ".$ordered." ASC;";
		$results = $this->rakedb->get_results($sql);	
		return $results;
	}
	public function _getSpecificData($table_name, $field_name, $ordered) {
		$sql = "select ".$field_name." from ".$table_name." order by ".$ordered." ASC;";
		$results = $this->rakedb->get_results($sql);	
		return $results;
	}
	public function _getMax($table_name, $field_name) {
		$sql = "select MAX(".$field_name.") from ".$table_name."";
		$results = $this->rakedb->get_results($sql);	
		return $results;
	}
	
	public function _getDataByOption($table_name, $field_name, $ordered, $option_name, $option_value) {
		$sql = "select ".$field_name." from ".$table_name." where ".$option_name."=".$option_value." order by `".$ordered."` ASC;";
		$results = $this->rakedb->get_results($sql);	
		return $results;
	}

	public function _getDatum($table_name, $field_name, $field_value, $return_field) {
		$sql = "select ".$return_field." from ".$table_name." where ".$field_name."='$field_value';";
		$results = $this->rakedb->get_results($sql);		
		return $results;
	}
	
	public function _getDatums($table_name, $field_name, $field_value, $return_field) {
		$sql = "select ".$table_name.".".$return_field." from ".$table_name." inner join wp_stmt_users on ".$table_name.".user_id = wp_stmt_users.user_id where ".$table_name.".$field_name =$field_value AND wp_stmt_users.user_type = 'pupil';";
		$results = $this->rakedb->get_results($sql);		
		return $results;
	}
	
	public function _getDatumAnd3Fields($table_name, $field_name, $field_value, $field_name2, $field_value2, $field_name3, $field_value3,$return_field) {	
		$sql = "select ".$return_field." from ".$table_name." where ".$field_name."='$field_value' and ".$field_name2."='$field_value2' and ".$field_name3."='$field_value3';";
		$results = $this->rakedb->get_results($sql);
		return $results;
	}

	public function _getDatumAnd($table_name, $field_name, $field_value, $field_name2, $field_value2, $return_field) {
		$sql = "select ".$return_field." from ".$table_name." where ".$field_name."='$field_value' and ".$field_name2."='$field_value2';";
		$results = $this->rakedb->get_results($sql);
		return $results;
	}
	
	public function _getDatumAndOrder($table_name, $field_name, $field_value, $field_name2, $field_value2, $return_field, $ordered) {
		$sql = "select ".$return_field." from ".$table_name." where ".$field_name."='$field_value' and ".$field_name2."='$field_value2' order by `".$ordered."` ASC;";
		$results = $this->rakedb->get_results($sql);
		return $results;
	}
	
	public function _getDatumIDRange($table_name, $field_id, $from, $to, $return_field) {
		$sql = "select ".$return_field." from ".$table_name." where ".$field_id.">='$from' and ".$field_id."<='$to';";
		$results = $this->rakedb->get_results($sql);
		return $results;
	}

	public function _getDatumAndAnd($table_name, $field_name, $field_value, $field_name2, $field_value2, $field_name3, $field_value3, $return_field) {
		$sql = "select ".$return_field." from ".$table_name." where ".$field_name."='$field_value' and ".$field_name2."='$field_value2' and ".$field_name3."='$field_value3';";
		$results = $this->rakedb->get_results($sql);
		return $results;
	}

	public function _addDatum($table_name, $values) {
		$sql = "insert into ".$table_name." values(".$values.")";
		$this->rakedb->query($sql);
		$id = mysql_insert_id();	
		return $id;
	}

	public function _deleteDatum($table_name, $field_name, $field_value) {
		$sql = "delete from ".$table_name." where ".$field_name."='$field_value'";
		$this->rakedb->query($sql);
	}

		
	public function _updateDatum($table_name, $field_name, $field_value, $update_field, $update_value) {
		$sql = "update ".$table_name." set ".$update_field."='".$update_value."' where ".$field_name."='$field_value';";
		$this->rakedb->query($sql);	
	}
	
	public function _updateDatum2($table_name, $field_name, $field_value, $update_field, $update_value) {
		$sql = "update ".$table_name." set ".$update_field."='".$update_value."' where ".$field_name."='$field_value';";
		$this->rakedb->query($sql);	
	}
	
	public function _getDataInnerJoin($table_name1, $table_name2, $field_name_common1, $field_name_common2, $return_field1, $return_field2, $field_condition_name, $field_condition_value, $ordered) {				
		$sql = "SELECT t1.".$return_field1.", t2.".$return_field2." FROM ".$table_name1." AS t1 INNER JOIN ".$table_name1." AS t2 ON t1.".$field_name_common1." = t2.".$field_name_common2." where ".$field_condition_name." = '".$field_condition_value."' order by `".$ordered."` ASC;";
		$this->rakedb->query($sql);	
	}

}