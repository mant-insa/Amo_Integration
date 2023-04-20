<?php

use App\Core\Router;

require_once __DIR__ . '/vendor/autoload.php';

define("APP_ROOT", __DIR__);

if(session_status() !== PHP_SESSION_ACTIVE)
{
    session_start();
} 

$router = new Router;
$router->run();
