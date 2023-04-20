<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Lib\AmoService;
use App\Lib\AmoClientParams;

class MainController extends Controller 
{
	public function index() 
	{
		$amoService = new AmoService();
		$result = $amoService->isUserIntegrated();

		if(!$result)
		{
			$vars = [
				'clientParams' 	=> AmoClientParams::getClientParams(),
			];
	
			$this->view->render('main/index', $vars);
			return;
		}

		$this->view->render('main/form');
	}
}