<?php

require_once('bootstrap.php');


$url = "http://localhost/Rake/templates/content.tpl";
$source = $rl->fileGetContents($url);
echo $rl->findShortcode($source);
