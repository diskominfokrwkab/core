<?php

namespace DiskominfoCore;

class Ciampel
{
    public static function rupiah($angka, $symbol = "Rp. ")
    {
        try {
            $hasil_rupiah = $symbol . number_format($angka, 2, ',', '.');
            return $hasil_rupiah;
        } catch (\Throwable $th) {
            return $angka;
        }
    }

    public static function makeResponse($state, $message, $data = null, $code = 200)
    {
        $model['state'] = $state;
        $model['message'] = $message;
        $model['data'] = $data;
        $model['code'] = $code;
        return $model;
    }

    public static function quickRandom($length = 16, $md5 = false)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($md5) {
            return substr(bin2hex(str_shuffle(str_repeat($pool, 5))), 0, $length);
        } else {
            return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
        }
    }

    static function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function timeMillis()
    {
        return intval(microtime(true) * 1000);
    }

    public static function encodeId($value)
    {
        return self::generateRandomString(20) . bin2hex($value);
    }

    public static function decodeId($value)
    {
        return hex2bin(substr($value, 20));
    }

}
