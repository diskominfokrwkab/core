<?php

namespace DiskominfoCore;

use Dotenv\Dotenv;
use Exception;

class GeneralVariable
{
    public static function init(string $string)
    {
        $_KEY = getenv($string);
        if (empty($_KEY)) {
            throw new Exception("Pastikan ".$string." terpsang di .env");
        }
    }

    public static function inits(array $array)
    {
        foreach ($array as $item) {
            self::init($item);
        }
    }
}
