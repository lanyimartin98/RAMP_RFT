<?php 
require_once('../database.php');
function generateToken(){
$token = openssl_random_pseudo_bytes(16);
$token = bin2hex($token);
return $token;
}
function checkToken(){
    $header=apache_request_headers();
    $token=explode(" ",$header['Authorization']);
    return getToken($token[1]);
}
?>