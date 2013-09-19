<?php

require_once('config.php');


require_once('includes/rake-db.php');
require_once('includes/rake-crud.php');
require_once('includes/rake-helpers.php');

require_once('includes/rake-loader.php');
$rl = new RakeLoader();

require_once('includes/rake-functions.php');
$rf = new RakeFunctions();
$rf->loadFunctions() ;

//$user = new User();
//echo $user->authenticate("test@test.com", "test");
//$user->create("ton@ton.com", "ton");
//$user->changeStatus(2, "active");


