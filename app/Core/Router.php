<?php

namespace App\Core;

use App\Core\View;

class Router {

    protected $routes = [];
    protected $params = [];
    
    public function __construct() 
    {
        $arr = require 'app/config/routes.php';
        foreach ($arr as $key => $val) {
            $this->add($key, $val);
        }
    }

    public function add($route, $params) 
    {
        $route = '#^' . $route . '$#';
        $this->routes[$route] = $params;
    }

    public function match() 
    {
        $url = strtok($_SERVER["REQUEST_URI"], '?');
        $url = trim($url, '/');
        foreach ($this->routes as $route => $params) 
        {
            if (preg_match($route, $url, $matches) && $params['requestType'] == $_SERVER['REQUEST_METHOD']) 
            {
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function run()
    {
        if ($this->match())
        {
            $classPath = 'App\Controllers\\' . $this->params['controller'] . 'Controller';
            if (class_exists($classPath)) 
            {
                $action = $this->params['action'];
                if (method_exists($classPath, $action)) 
                {
                    $controller = new $classPath($this->params);
                    $controller->$action();
                } else {
                    View::errorCode("404");
                }
            } else {
                View::errorCode("404");
            }
        } else {
            View::errorCode("404");
        }
    }

}