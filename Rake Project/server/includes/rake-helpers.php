<?php

class RakeHelpers {

	public function arrayToString($data) {
		$result = "";
		foreach($data as $datum) {
			$result .= "'".$datum."', ";
		}
		return substr($result, 0, (strlen($result) - 2));
	}
	
	function passwordEncrypt($string) {
		return md5($string);
	}
	
	public function phpToMySQLDate($date_value) {
		return $mysqldate = date( 'Y-m-d H:i:s', $date_value );
	}
	
	public function phpToMySQLDate2($date_value) {
		return $mysqldate = date( 'Y-m-d', $date_value );
	}

	public function mySQLToPhpDate($date_value) {
		return strtotime( $date_value );
	}

	public function currentDate() {
		return date('Y-m-d H:i:s');
	}
	
	public function currentDate2() {
		return date('Y-m-d');
	}

	public function currentDateComplete() {
		return date('l jS \of F Y h:i:s A');
	}

	public function transformToDateComplete($date_value) {
		return $mysqldate = date( 'l jS \of F Y h:i:s A', $date_value );
	}
	
	public function transformToDateOf($date_value) {
		return $mysqldate = date( 'l jS \of F Y', $date_value );
	}

	public function transformToDateSlash($date_value) {
		return $mysqldate = date( 'm/d/Y', $date_value );
	}

	public function transformToDateDay($date_value) {
		$day_date = date( 'Y-m-d', $date_value );
		return strtotime($day_date);
	}
	
	public function transformToDateComma($date_value) {
		return $mysqldate = date( 'd, M Y', $date_value );
	}

	public function _validateEmail($email) {
		$result = TRUE;
		if(!@eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email)) {
			$result = FALSE;
		}
		return $result;
	}
	
	function generatePassword($length=9, $strength=0) {
		$vowels = 'aeuy';
		$consonants = 'bdghjmnpqrstvz';
		if ($strength & 1) {
			$consonants .= 'BDGHJLMNPQRSTVWXZ';
		}
		if ($strength & 2) {
			$vowels .= "AEUY";
		}
		if ($strength & 4) {
			$consonants .= '23456789';
		}
		if ($strength & 8) {
			$consonants .= '@#$%';
		}
 
		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $password;
	}

	function email($to, $subject, $message) {	
		$send_mail = false;
		$send_mail = mail($to, $subject, $message);
		if($send_mail)
			return true;
		else
			return false;
	}

}

