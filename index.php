<?php

use App\Core\Router;

require_once __DIR__ . '/vendor/autoload.php';

define("APP_ROOT", __DIR__);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(session_status() !== PHP_SESSION_ACTIVE)
{
    session_start();
} 

$router = new Router;
$router->run();
