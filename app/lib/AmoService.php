<?php

namespace App\Lib;

use AmoCRM\OAuth2\Client\Provider\AmoCRM;

class AmoService
{
    private $serviceProvider;
    private $clientParams;
    private $tokenManager;

    public function __construct()
    {
        $clientParams = $this->initClientParams();
        $this->serviceProvider = new AmoCRM($clientParams);
        $this->tokenManager = new AmoTokenManager();
    }

    private function isCurrentUserAuthorized()
    {
        $accessToken = $this->tokenManager->getToken();

        if(!$accessToken)
        {
            return false;
        }

        $this->serviceProvider->setBaseDomain($accessToken->getValues()['baseDomain']);

        if ($accessToken->hasExpired()) 
        {
            try 
            {
                $accessToken = $this->serviceProvider->getAccessToken(new \League\OAuth2\Client\Grant\RefreshToken(), [
                    'refresh_token' => $accessToken->getRefreshToken(),
                ]);

                $this->tokenManager->saveToken([
                    'accessToken' => $accessToken->getToken(),
                    'refreshToken' => $accessToken->getRefreshToken(),
                    'expires' => $accessToken->getExpires(),
                    'baseDomain' => $this->serviceProvider->getBaseDomain(),
                ]);
            } 
            catch (\Exception $e) 
            {
                //+LOGS
                die((string) $e->getMessage());
            }
        }

        return true;
    }

    private function isQueryParamsValid()
    {
        if (isset($_GET['code']))
        {
            if (empty($_GET['state']) || empty($_SESSION['oauth2state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) 
            {
                unset($_SESSION['oauth2state']);
                return false;
            }

            try 
            {
                $accessToken = $this->serviceProvider->getAccessToken(new \League\OAuth2\Client\Grant\AuthorizationCode(), [
                    'code' => $_GET['code'],
                ]);
        
                if (!$accessToken->hasExpired()) 
                {
                    $this->tokenManager->saveToken([
                        'accessToken' => $accessToken->getToken(),
                        'refreshToken' => $accessToken->getRefreshToken(),
                        'expires' => $accessToken->getExpires(),
                        'baseDomain' => $this->serviceProvider->getBaseDomain(),
                    ]);
                }
            } 
            catch (\Exception $e) 
            {
                //+LOGS
                die((string) $e->getMessage());
            }

            return true;
        }

        return false;
    }

    public function isUserIntegrated()
    {
        if($this->isCurrentUserAuthorized())
        {
            return true;
        }

        if($this->isQueryParamsValid())
        {
            return true;
        }

        return false;
    }

    private function initClientParams()
    {
        return [
			'clientId' => 'a0638859-d4ec-455f-bca6-a5f8b016a2b4',
			'clientSecret' => 'Mj2EH4SRXO4b6hvvmmaHNcyeyHHjTh1b1B8gWwDqWfwNBPyMdnL5BcRPUEbYB23h',
			'redirectUri' => 'http://f0808190.xsph.ru/',
		];
    }
    
    public function getClientParams()
    {
        return $this->clientParams;
    }
}