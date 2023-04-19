<?php

namespace App\Core;

use App\Core\Controller;
use App\Lib\AmoService;

class MainController extends Controller 
{
	public function index() 
	{
		$amoService = new AmoService();
		$result = $amoService->isUserIntegrated();

		if(!$result)
		{
			$vars = [
				'clientParams' 	=> $amoService->getClientParams(),
			];
	
			$this->view->render('main/index', $vars);
			return;
		}

		$this->view->render('main/form');
	}
}