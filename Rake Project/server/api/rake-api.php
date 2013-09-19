<?php

class RakeAPI {

	private $user_service;
	
	function __construct() {
		$this->user_service = new UserService();
	}
	
	function query($data) {
		
		$data_array = json_decode($data);

		
		$service = $data_array->Service;
		$method = $data_array->Method;
		$param = $data_array->Parameters;
		
		if($service == "User") {
			if($method == "authenticate")
				echo $this->user_service->authenticate($param);
			else if($method == "create")
				echo $this->user_service->create($param);
			else if($method == "requestPasswordChange")
				echo $this->user_service->requestPasswordChange($param);
			else
			;
		}
		
	}
}
	