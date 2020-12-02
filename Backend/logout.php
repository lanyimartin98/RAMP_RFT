<?php 
require_once('database.php');
$header=apache_request_headers();
$token=explode(" ",$header['Authorization']);
crashToken($token[1]);
?>