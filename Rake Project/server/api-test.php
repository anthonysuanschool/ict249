<?php

require_once('bootstrap.php');

require_once('api/scraper-service.php');
require_once('api/user-service.php');
require_once('api/rake-api.php');

$ra = new RakeAPI();

//@$data = $_POST['data'];
//echo $ra->query($data);


$param = array(
			"id" => "1"
		);
		
$data = array(
			"Service" => "Scraper",
			"Method" => "getItemInformation",
			"Parameters" => $param
		);
	

echo $data = json_encode($data);

echo $ra->query($data);



