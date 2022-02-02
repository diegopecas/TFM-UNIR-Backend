<?php
// header('Access-Control-Allow-Origin: '.$_SERVER["HTTP_ORIGIN"]);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: *');
header("Access-Control-Request-Headers: *");
header("Content-Type: application/json; charset=UTF-8");
/*
// Allow from any origin
header('Access-Control-Allow-Origin:*');
header("Access-Control-Allow-Headers:X-Requested-With, X-API-KEY, Origin, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods:GET, POST, OPTIONS, PUT, DELETE");
header("Allow:GET, POST, OPTIONS, PUT, DELETE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Request-Headers:*");
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
}

*/