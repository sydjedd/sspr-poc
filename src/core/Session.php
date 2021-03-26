<?php

final class Session
{
    //TODO faire des accesseurs et des mutateurs et rendre les attributs prive
    public static $isConnected = false;

    final public static function init()
    {
        session_start();
        //TODO trouver ou supprimr les entetes
        //header_remove();

        if (isset($_COOKIE['token']) && isset($_SESSION['token']) && ($_COOKIE['token'] === $_SESSION['token'])) {
            Self::setToken();
        } else {
            Self::unSetToken();
        }
    }

    final public static function kill()
    {
        unset($_SESSION);
        unset($_COOKIE);
        session_destroy();
        setcookie('token', '', -1, '/');
        Self::$isConnected = false;
    }

    final public static function setToken()
    {
        $token = hash('sha512', session_id().microtime().rand(0, 9999999999));
        setcookie('token', $token, time() + (60 * 60), '/');
        Self::set('token', $token);
        Self::$isConnected = true;
    }

    final public static function unSetToken()
    {
        unset($_SESSION['token']);
        Self::$isConnected = false;
    }

    final public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    final public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return false;
    }

    private function __construct()
    {
    }
}
