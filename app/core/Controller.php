<?php

namespace App\Core;

use App\Core\View;

abstract class Controller {

	protected $route;
	protected $view;
	protected $model;

	public function __construct($route) 
	{
		$this->route = $route;
		$this->view = new View();
		$this->model = $this->loadModel($route['controller']);
	}

	public function loadModel($name) 
	{
		$path = 'App\Models\\' . $name;
		if (class_exists($path)) 
		{
			return new $path;
		}
	}
}