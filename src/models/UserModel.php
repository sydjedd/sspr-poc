<?php

class UserModel extends Model
{
    protected static $fileName = __DIR__ . '/../../user.csv';
    protected static $file = null;

    public static function getByEmail($email): ?array
    {
        static::$file = file(static::$fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach (static::$file as $line) {
            $line = explode(';', $line);
            if($line[0] === $email) {
                return $line;
            }
        }
        return null;
    }

    public static function getByToken($token): ?array
    {
        static::$file = file(static::$fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach (static::$file as $line) {
            $line = explode(';', $line);
            if($line[2] === $token) {
                return $line;
            }
        }
        return null;
    }

    public static function setToken($email): ?string
    {
        $lineToChangeNumber = null;
        $lineToChangeValue = '';
        static::$file = file(static::$fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach (static::$file as $number => $line) {
            $line = explode(';', $line);
            if($line[0] === $email) {
                $token = md5(uniqid(rand(), true));
                $lineToChangeNumber = $number;
                $lineToChangeValue = $line[0] . ';' . $line[1] . ';' . $token . ';' . (new DateTime('NOW', new DateTimeZone('Europe/Paris')))->add(new DateInterval('P1D'))->format('Y-m-d H:i:s');
            }
        }
        if($lineToChangeNumber !== null) {
            static::$file[$lineToChangeNumber] = $lineToChangeValue;
            $fileHandle = fopen(static::$fileName, 'w');
            foreach(static::$file as $line){
                fwrite($fileHandle, $line . PHP_EOL);
            }
            return $token;
        }
        return null;
    }

    public static function removeToken($email): void
    {
        $lineToChangeNumber = null;
        $lineToChangeValue = '';
        static::$file = file(static::$fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach (static::$file as $number => $line) {
            $line = explode(';', $line);
            if($line[0] === $email) {
                $lineToChangeNumber = $number;
                $lineToChangeValue = $line[0] . ';' . $line[1] . ';;';
            }
        }
        if($lineToChangeNumber !== null) {
            static::$file[$lineToChangeNumber] = $lineToChangeValue;
            $fileHandle = fopen(static::$fileName, 'w');
            foreach(static::$file as $line){
                fwrite($fileHandle, $line . PHP_EOL);
            }
        }
    }
}
