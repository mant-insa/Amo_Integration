<?php

namespace App\Lib;

use AmoCRM\OAuth2\Client\Provider\AmoCRM;

class AmoTokenManager
{
    public function getToken()
    {
        if(!isset($_SESSION['accessToken']))
        {
            return false;
        }

        $accessToken = $_SESSION['accessToken'];

        if ($this->isTokenValid($accessToken))
        {
            return new \League\OAuth2\Client\Token\AccessToken([
                'access_token' => $accessToken['accessToken'],
                'refresh_token' => $accessToken['refreshToken'],
                'expires' => $accessToken['expires'],
                'baseDomain' => $accessToken['baseDomain'],
            ]);
        } 
        else 
        {
            return false;
        }
    }

    public function saveToken($accessToken)
    {
        if ($this->isTokenValid($accessToken))
        {
            $data = [
                'accessToken' => $accessToken['accessToken'],
                'expires' => $accessToken['expires'],
                'refreshToken' => $accessToken['refreshToken'],
                'baseDomain' => $accessToken['baseDomain'],
            ];

            $_SESSION['accessToken'] = $data;
        } 
        else
        {
            //+LOGS
            exit('Invalid access token ' . var_export($accessToken, true));
        }
    }

    private function isTokenValid($accessToken)
    {
        return isset($accessToken)
        && isset($accessToken['accessToken'])
        && isset($accessToken['refreshToken'])
        && isset($accessToken['expires'])
        && isset($accessToken['baseDomain']);
    }
}