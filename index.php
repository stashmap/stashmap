<?php


//  phpinfo();die;

// error_reporting(E_ALL); 
// ini_set("display_errors", 1); 


ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));
require_once "vendor/autoload.php";
require_once('url.php');
require_once('debug.php');



//not use redirect to https for next routes : 
if (!in_array ($_SERVER['REQUEST_URI'], \Components\Config::get('http_only_routes'), true)) {
    if (!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on") {
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
        exit;
    }
}

session_start();

//  vd($_COOKIE);
// hr();
// vd($_SESSION);
//vd($_SERVER);
// echo geBaseSiteUrl();
// vd();


$router = new Components\Router();
$router->run();

