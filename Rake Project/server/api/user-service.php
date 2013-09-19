<?php

class UserService {

	private $user;
	
	function __construct() {
		$this->user = new User();
	}
	
	function authenticate($param) {
		$this->user->authenticate($param->email, $param->password);
		$user_id = $this->user->getId();
		
		$error_msg = "none";
		if($user_id == 0) {
			$status = false;
			$error_msg =$this->user->getLastErrorMsg();
		}
		else
			$status = true;
			
		$data = array(
			"Status" => $status,
			"Result" => $user_id,
			"Error" => $error_msg
		);		
		return json_encode($data);		
	}
	
	function create($param) {
		$this->user->create($param->email, $param->password);
		$user_id = $this->user->getId();
		
		$error_msg = "none";
		
		if($user_id == 0) {
			$error_msg =$this->user->getLastErrorMsg();
			$status = false;
		}
		else
			$status = true;
			
		$data = array(
			"Status" => $status,
			"Result" => $user_id,
			"Error" => $error_msg
		);		
		return json_encode($data);
	}
	
	function requestPasswordChange($param) {
		$error_msg = "none";
		if($this->user->emailAlreadyTaken($param->email)) {
			$this->user->changePasswordRandom();
			$status = true;
		} else {
			$status = false;
			$error_msg =$this->user->getLastErrorMsg();
		}
		
		$data = array(
			"Status" => $status,
			"Result" => "",
			"Error" => $error_msg
		);		
		return json_encode($data);
	}
	
	
	
}