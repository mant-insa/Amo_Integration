<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Lib\AmoClientParams;
use App\Lib\AmoTokenManager;
use App\Lib\AmoApiClient;
use App\Lib\AmoContact;
use AmoCRM\Exceptions\AmoCRMApiException;

class FormController extends Controller 
{
	public function index() 
	{
		$requestBody = $this->validateCurrentRequest();

		$this->addAmoLead($requestBody);

		$this->sendResponse([
			"success" => true,
		], 200);
	}

	private function validateCurrentRequest()
	{
		$requestRaw = file_get_contents('php://input');
		$requestBody = json_decode($requestRaw, true);

		if(!$requestBody || is_null($requestBody))
		{
			$this->sendResponse([
				"error" => "Ошибка обработки формы. Попробуйте ещё раз."
			], 500);
		}

		return $requestBody;
	}

	private function addAmoLead($requestBody)
	{
		$clientParams = AmoClientParams::getClientParams();
		$tokenManager = new AmoTokenManager();
		$accessToken = $tokenManager->getToken();

		if(!$accessToken) 
		{
			$this->sendResponse([
				"error" => "Ваш токен доступа не найден. Пожалуйста, обновите страницу."
			], 401);
		}

		$apiClient = new AmoApiClient($tokenManager, $clientParams);

		try 
		{
			$apiClient->addOneComplexLead(
				uniqid("Сделка-"), 
				$requestBody["price"],
				new AmoContact($requestBody["name"], $requestBody["phone"], $requestBody["email"])
			);
		} catch (AmoCRMApiException $e) 
		{
			$this->sendResponse([
				"error" => "Что-то пошло не так. Сделка не была создана.",
				"exception" => $e->getMessage(),
			], 500);
		}
	}
}