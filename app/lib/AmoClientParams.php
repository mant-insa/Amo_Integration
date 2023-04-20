<?php

namespace App\Lib;

class AmoClientParams
{
    public static function getClientParams()
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(APP_ROOT);
        $dotenv->load();

        return [
			'clientId' => $_ENV['CLIENT_ID'],
			'clientSecret' => $_ENV['CLIENT_SECRET'],
			'redirectUri' => $_ENV['REDIRECT_URL'],
		];
    }

}