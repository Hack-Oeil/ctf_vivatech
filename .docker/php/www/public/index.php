<?php
// configuration
if(!file_exists(dirname(__DIR__)."/shared/.env"))  { header("location:/b1897811c0c207.php"); exit(); } 

// On securise le cookie de session (PHPSESSID)
session_set_cookie_params(60*60, null, null, false, true);

require '../vendor/autoload.php';

$kernel = new Yoop\Kernel();

(new Yoop\Database\Wait)->tryMySQL();

$router = $kernel->getRouter();
$router->load('/app/routes.php');
$router->run($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);