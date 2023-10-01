<?php

namespace Proloweb\WebformClient;

use Symfony\Component\Dotenv\Dotenv;

class App
{
    private static array $allowedVars = [];

    /**
     * @return void
     */
    public static function instantiate(): void
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/../.env');

        self::$allowedVars = explode(',',$_ENV['SYMFONY_DOTENV_VARS']);
    }

    /**
     * @param string $var
     * @return mixed|null
     */
    public static function getEnv(string $var) {
        if (in_array($var, self::$allowedVars)) {
            return $_ENV[$var] ?? null;
        } else {
            return null;
        }
    }
}
