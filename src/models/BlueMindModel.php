<?php

final class BlueMindModel
{
    private static $_handler = null;
    private static $_host = '';
    private static $_url = '';
    private static $_method = 'GET';
    private static $_header = [];
    private static $_body = '';
    private static $_response = null;
    private static $_authKey = '';
    private static $_error = '';

    final public static function init(string $host,string $login, string $password): bool
    {
        self::$_host = $host;
        self::$_handler = curl_init();
        if (self::$_handler === false) { return false; }
        if (self::auth($login, $password) === false) { return false; }
        self::$_authKey = self::$_response->authKey;
        self::$_header[] = 'X-BM-ApiKey:' . self::$_response->authKey;
        return true;
    }

    public static function close(): void
    {
        self::$_url = self::$_host . '/auth/logout';
        self::$_method =  'POST';
        self::exec();
        curl_close(self::$_handler);
    }

    final public static function auth(string $login, string $password): bool
    {
        self::$_url = self::$_host . '/auth/login?login=' . $login;
        self::$_body =  '"' . $password . '"';
        self::$_method =  'POST';
        if (self::exec() === false) { return false; }
        if (self::$_response->status !== 'Ok') { return false; }
        return true;
    }

    final public static function exec(): bool
    {
        curl_reset(self::$_handler);
        $option = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => self::$_method,
            CURLOPT_URL  => self::$_url,
            CURLOPT_HTTPHEADER => self::$_header,
            CURLOPT_POSTFIELDS => self::$_body
        ];
        curl_setopt_array(self::$_handler, $option);
        $response = curl_exec(self::$_handler);
        if ($response === false) {
            self::$_error = '[PROBLEME EXECUTION REQUETE CURL] ' . curl_errno(self::$_handler) . ' - ' . curl_error(self::$_handler);
            return false;
        }
        self::$_response = json_decode($response);
        $httpCodeResponse = curl_getinfo(self::$_handler, CURLINFO_RESPONSE_CODE);
        if ($httpCodeResponse !== 200) {
            self::$_error = '[PROBLEME RETOUR REQUETE HTTP] Code retour http : ' . $httpCodeResponse . ' : ' . self::$_response->errorCode . ' : ' . self::$_response->message;
            return false;
        }
        return true;
    }

    public static function getUserByLogin(string $login, string $domaine = 'inserm.fr'): ?object
    {
        self::$_url = self::$_host . '/users/' . $domaine . '/byLogin/' . $login;
        self::$_method =  'GET';
        if (self::exec() === false) { return null; }
        return self::$_response;
    }

    public static function getUserByEmail(string $email, string $domaine = 'inserm.fr'): ?object
    {
        self::$_url = self::$_host . '/users/' . $domaine . '/byEmail/' . $email;
        self::$_method =  'GET';
        if (self::exec() === false) { return null; }
        return self::$_response;
    }

    public static function changeUserPassword(string $uid, string $newPassword, string $currentPassword = null , string $domaine = 'inserm.fr'): bool
    {
        self::$_url = self::$_host . '/users/' . $domaine . '/' . $uid . '/password_';
        self::$_method =  'POST';
        self::$_body = '{ ' . ( $currentPassword === null ? '' : '"currentPassword": "' . $currentPassword . '", ' ) . '"newPassword": "' . $newPassword . '" }';
        if (self::exec() === false) { return false; }
        return true;
    }

    public static function getAuthKey(): ?string
    {
        return self::$_authKey;
    }

    public static function getResponse(): ?object
    {
        return self::$_response;
    }

    public static function getError(): ?string
    {
        return self::$_error;
    }

    private function __construct()
    {
    }
}
