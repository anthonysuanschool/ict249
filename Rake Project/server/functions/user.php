<?php

class User {

	private $rake_crud;
	private $user_table;
	private $user_meta_table;
	private $rake_helpers;
	
	private $id;
	private $last_error_msg;
	
	public function __construct($id = 0) {
		$this->rake_crud = new RakeCRUD();
		$this->rake_helpers = new RakeHelpers();
		$this->user_table = USERS;
		$this->user_meta_table = USER_META;
		$this->Id = $id;
		$this->last_error_msg = "";
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
	
	public function authenticate($email, $password) {
		$user_info = $this->rake_crud->_getDatumAnd($this->user_table, "user_email", $email, "user_password", $this->rake_helpers->passwordEncrypt($password), "user_id");
		if($user_info == null) {
			$this->Id = 0;
			$this->last_error_msg = "User not found.";
		}
		else
			$this->Id = $user_info[0]['user_id'];
	}
	
	public function create($email, $password) {
	
		
		if($this->emailAlreadyTaken($email))
			$this->last_error_msg = "User email already exist.";
		else {
		
			if($password == null || $password == "")
				$password = $this->rake_helpers->generatePassword(9);
			
			$values = array(
				"user_id" => "",
				"user_email" => $email,
				"user_password" => $this->rake_helpers->passwordEncrypt($password),
				"user_active" => "pending",
				"user_registered" => $this->rake_helpers->currentDate(),
				"user_last_login" => ""
			);
			
			$this->Id = $this->rake_crud->_addDatum($this->user_table, $this->rake_helpers->arrayToString($values));
			
			$this->changeStatus("active");
		
			if($this->Id != 0) {
				$subject = "Welcome to Rake";
				$message = "Your Password is: " . $password;
				$this->rake_helpers->email($email, $subject, $message);
			}
		}
	}
	
	public function emailAlreadyTaken($email) {
		$result = $this->rake_crud->_getDatum($this->user_table, "user_email", $email, "user_id");
		if($result != null) {
			$this->Id = $result[0]['user_id'];
			return true;
		}
		else {
			$this->Id = 0;
			$this->last_error_msg = "Email not found.";
			return false;
		}
	}
	
	public function isUserActive() {
		$result = $this->rake_crud->_getDatum($this->user_table, "user_id", $this->Id, "user_active");
		if($result[0]['user_active'] == "active")
			return true;
		else
			return false;
	}
	
	public function getUserStatus() {
		$result = $this->rake_crud->_getDatum($this->user_table, "user_id", $this->Id, "user_active");
		return $result[0]['user_active'];
	}
	
	public function changeStatus($status) {
		$this->rake_crud->_updateDatum($this->user_table, "user_id", $this->Id, "user_active", $status);
	}
	
	public function updateLoginDate() {
		$this->rake_crud->_updateDatum($this->user_table, "user_id", $this->Id, "user_last_login", $this->rake_helpers->currentDate());		
	}
	
	public function getEmail() {
		$result = $this->rake_crud->_getDatum($this->user_table, "user_id", $this->Id, "user_email");
		return $result[0]['user_email'];
	}
	
	
	public function getPassword() {
		$result = $this->rake_crud->_getDatum($this->user_table, "user_id", $this->Id, "user_password");
		return $result[0]['user_password'];
	}
	
	public function comparePassword($new_password) {
		$original_password = $this->getPassword();
		if($original_password == $this->rake_helpers->passwordEncrypt(new_password))
			return true;
		else
			return false;
	}
	
	public function changePasswordRandom() {
		$password = $this->rake_helpers->generatePassword(9);
		$this->changePassword($password);
		$subject = "Rake Password Changed";
		$message = "Your New Password is: " . $password;
		$this->rake_helpers->email($this->getEmail(), $subject, $message);
	}
	
	public function changePassword($new_password) {
		$this->rake_crud->_updateDatum($this->user_table, "user_id", $this->Id, "user_password", $this->rake_helpers->passwordEncrypt($new_password));		
	}
	
	public function getMetum($meta_key) {
		$result = $this->rake_crud->_getDatumAnd($this->user_meta_table, "user_id", $this->Id, "user_meta_key", $meta_key, "user_meta_value");
		return $result[0]['user_meta_value'];
	}
	
	public function getMetumId($meta_key) {
		$result = $this->rake_crud->_getDatumAnd($this->user_meta_table, "user_id", $this->Id, "user_meta_key", $meta_key, "user_meta_id");
		return $result[0]['user_meta_id'];
	}
	
	public function getMeta() {
		$result = $this->rake_crud->_getDatum($this->user_meta_table, "user_id", $this->Id, "user_meta_key");
		return $result;
	}
	
	public function setMetum($meta_key, $meta_value) {
		$meta_value_id = $this->getMetumId($meta_key);
		if($meta_value_id == "" || $meta_value_id == null) {
			$values = array(
				"user_meta_id" => "",
				"user_id" => $this->Id,
				"user_meta_key" => $meta_key,
				"user_meta_value" => $meta_value,
				"user_meta_type" => "text"
			);
		
			$this->rake_crud->_addDatum($this->user_meta_table, $this->rake_helpers->arrayToString($values));
			
		} else {
			$this->rake_crud->_updateDatum($this->user_meta_table, "user_meta_id", $meta_value_id, "user_meta_value", $meta_value);		
		}
	}
	
	public function setMetumType($meta_key, $meta_type) {
		$meta_value_id = $this->getMetumId($meta_key);
		if(!($meta_value_id == "" || $meta_value_old == null)) {
			$this->rake_crud->_updateDatum($this->user_meta_table, "user_meta_id", $meta_value_id, "user_meta_type", $meta_type);		
		}
	}
	
	
}
	