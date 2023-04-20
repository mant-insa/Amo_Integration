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
        $this->serviceProvider = new AmoCRM(AmoClientParams::getClientParams());
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
                SimpleLogger::log("Exception in AmoService in method isCurrentUserAuthorized. Message: " . $e->getMessage());
                die("Что-то пошло не так. Пожалуйста, обратитесь к администратору.");
            }
        }

        return true;
    }

    private function isQueryParamsValid()
    {
        if (isset($_GET['code']) && isset($_GET['referer']))
        {
            if (empty($_GET['state']) || empty($_SESSION['oauth2state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) 
            {
                unset($_SESSION['oauth2state']);
                echo "wrong state";
                return false;
            }

            $this->serviceProvider->setBaseDomain($_GET['referer']);

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
                SimpleLogger::log("Exception in AmoService in method isQueryParamsValid. Message: " . $e->getMessage());
                die("Что-то пошло не так. Пожалуйста, обратитесь к администратору.");
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
}