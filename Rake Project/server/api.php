<?php

require_once('bootstrap.php');

require_once('api/user-service.php');
require_once('api/rake-api.php');

$ra = new RakeAPI();

@$data = $_POST['data'];
echo $ra->query($data);



