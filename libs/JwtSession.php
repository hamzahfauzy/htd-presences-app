<?php

class JwtSession
{
    static $token = "";
    static function init($token)
    {
        self::$token = $token;
    }

    static function get()
    {
        return JwtAuth::decode(self::$token, config('jwt_secret'));
    }
}