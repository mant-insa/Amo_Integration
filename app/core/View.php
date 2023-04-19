<?php

namespace App\Core;

use Exception;

class View {

	protected $layout = 'default';

	public function render($viewPath, $vars = []) 
	{
		extract($vars);
		$path = 'app/views/' . $viewPath . '.php';
		if (file_exists($path)) 
		{
			ob_start();
			require $path;
			$content = ob_get_clean();
			require 'app/views/layouts/' . $this->layout . '.php';
		}
		else
		{
			throw new \Exception("View file \"" . $path . "\" not found");
		}
	}

	public function redirect($url, $query = []) 
	{
		if(count($query) > 0)
		{
			$url .= "?";
			foreach($query as $key => $value)
			{
				$url .= $key . "=" . $value . "&";

			}
		}
		header('location: ' . $url);
		exit;
	}
/*
	public static function errorCode($code) 
	{
		http_response_code($code);
		$path = 'application/views/errors/' . $code . '.php';
		if (file_exists($path)) 
		{
			require $path;
		}
		exit;
	}
*/
	public function message($status, $message) 
	{
		exit(json_encode(['status' => $status, 'message' => $message]));
	}

	public function location($url) 
	{
		exit(json_encode(['url' => $url]));
	}

}	