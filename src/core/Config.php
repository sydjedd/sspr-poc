<?php

final class Config
{
    private static $file = null;
    private static $env = [];

    final public static function init()
    {
        //TODO Mieux gerer et uniformiser le format pour les parametres, soit tableau php, fichier ini ou encore variable d'environement avec getenv
        self::$env = array_merge(
            require(__DIR__ . '/../../config/parameters.php'),
            require(__DIR__ . '/../../config/routes.php')
        );

        self::$file = file(__DIR__ . '/../../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach (self::$file as $line) {
            $line = explode('=', $line);
            self::$env[$line[0]] = getenv($line[0]) ?: $line[1];
        }

        setlocale(LC_ALL, 'fr_FR.UTF-8');
    }

    final public static function get($variable)
    {
        if(isset(self::$env[$variable])) {
            return self::$env[$variable];
        }

        return null;
    }

    final public static function set($variable, $value)
    {
        self::$env[$variable] = $value;
    }

    private function __construct()
    { }

    private function __clone()
    { }

    private function __wakeup()
    { }
}
