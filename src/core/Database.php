<?php

final class Database
{
    private static $dbh = null;
    private static $delimiter = '"';

    final public static function Init()
    {
        try {
            self::$dbh = new PDO(
                Config::get('DB_DRIVER') . ':host=' . Config::get('DB_HOST') . ';port=' . Config::get('DB_PORT') . ';dbname=' . Config::get('DB_NAME'),
                Config::get('DB_USERNAME'),
                Config::get('DB_PASSWORD'),
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_ORACLE_NULLS => PDO::NULL_TO_STRING,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            ErrorController::internalServerError($e->getMessage());
        }

        self::$dbh->exec('SET NAMES \'utf8\'');

        if(Config::get('DB_DRIVER') === 'pgsql') {
            self::$dbh->exec('SET search_path TO \'' . Config::get('DB_SCHEMA') . '\'');
            self::$dbh->exec('SET application_name TO \'' . Config::get('APP_NAME') . '\'');
        }

        if(Config::get('DB_DRIVER') === 'mysql') {
            self::$delimiter = '`';
        }
    }

    final public static function getInstance()
    {
        return self::$dbh;
    }

    final public static function getAttributes() {
        $attributes = array(
            'ATTR_AUTOCOMMIT',
            'ATTR_CASE',
            'ATTR_CLIENT_VERSION',
            'ATTR_CONNECTION_STATUS',
            'ATTR_DRIVER_NAME',
            'ATTR_ERRMODE',
            'ATTR_ORACLE_NULLS',
            'ATTR_PERSISTENT',
            'ATTR_PREFETCH',
            'ATTR_SERVER_INFO',
            'ATTR_SERVER_VERSION',
            'ATTR_TIMEOUT'
        );

        $attributesArray = [];

        foreach ($attributes as $attribute) {
            try {
                $attributesArray[$attribute] = self::$dbh->getAttribute(constant('PDO::' . $attribute));
            } catch ( PDOException $e ) {
                ;
            }
        }

        return $attributesArray;
    }

    final public static function getDriverName() {
        return self::$dbh->getAttribute(constant('PDO::ATTR_DRIVER_NAME'));
    }

    final public static function getDelimiter() {
        return self::$delimiter;
    }

    private function __construct()
    {
    }
}
