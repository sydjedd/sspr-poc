<?php

final class Http
{
    //TODO faire des accesseurs et des mutateurs et rendre les attributs prive
    public static $uri = null;
    public static $method = null;
    public static $arguments = null;
    public static $parameters = null;

    final public static function init()
    {
        self::$method = strtoupper($_SERVER['REQUEST_METHOD']);
        self::$uri = substr(explode('?', $_SERVER['REQUEST_URI'], 2)[0], strlen(Config::get('APP_DIR')));

        if (self::$method === 'PUT' || self::$method === 'DELETE') {
            parse_str(file_get_contents('php://input'), self::$parameters);
        }

        if (self::$method === 'GET') {
            self::$parameters = $_GET;
        }

        if (self::$method === 'POST') {
            self::$parameters = $_POST;
        }
    }

    private function __construct()
    {
    }
}
