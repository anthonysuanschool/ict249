<?php

require_once('bootstrap.php');

require_once('api/user-service.php');
require_once('api/rake-api.php');

$ra = new RakeAPI();

//@$data = $_POST['data'];
//echo $ra->query($data);


$param = array(
			"email" => "test@test.com",
			"password" => "ton"
		);
		
$data = array(
			"Service" => "User",
			"Method" => "authenticate",
			"Parameters" => $param
		);
		
echo $data = json_encode($data);

echo $ra->query($data);



