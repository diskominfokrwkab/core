<?php

namespace DiskominfoCore;

use Exception;
use stdClass;

class Walahar
{


    static private function checkCryptKey($secretKey)
    {
        GeneralVariable::init("CORE_SECURITY_KEY");
        if (strlen($secretKey) != 32) throw new Exception('"SecretKey length is not 32 chars"');
        $iv = substr($secretKey, 0, 16);
        return [$secretKey, $iv];
    }

    static function encrypt($data)
    {
        try {
            GeneralVariable::init("CORE_SECURITY_KEY");
            if (is_array($data)) {
                $data = json_encode($data);
            }
            $k = self::checkCryptKey(getenv("CORE_SECURITY_KEY"));
            $crypt = openssl_encrypt($data, 'aes-256-cbc', $k[0], 0, $k[1]);
            return base64_encode(rand(1000, 9999) . $crypt . rand(1000, 9999));
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 1);
        }
    }

    static function decrypt($data)
    {
        try {
            GeneralVariable::init("CORE_SECURITY_KEY");
            $k = self::checkCryptKey(getenv("CORE_SECURITY_KEY"));
            $base64 = substr(base64_decode($data), 4, -4);
            return openssl_decrypt($base64, 'aes-256-cbc', $k[0], 0, $k[1]);;
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 1);
        }
    }

    static function encryptWithPassphrase($passphrase, $data)
    {
        try {
            $secret_key = hex2bin($passphrase);
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
            $encrypted_64 = openssl_encrypt($data, 'aes-256-cbc', $secret_key, 0, $iv);

            $json = new stdClass();
            $json->iv = base64_encode($iv);
            $json->data = $encrypted_64;

            return base64_encode(json_encode($json));
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 1);
        }
    }

    static function decryptWithPassphrase($passphrase, $iv, $data)
    {
        try {
            $secret_key = hex2bin($passphrase);
            $decrypted_64 = openssl_decrypt($data, 'aes-256-cbc', $secret_key, OPENSSL_RAW_DATA, $iv);
            return $decrypted_64;
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 1);
        }
    }

    static function sensor_nik($nik)
    {
        try {
            if ($nik === '-' || empty($nik)) {
                return '-';
            }
            $jumlah_sensor = 6;
            $setelah_angka_ke = 6;
            $censored = mb_substr($nik, $setelah_angka_ke, $jumlah_sensor);
            $nik2 = explode($censored, $nik);
            $nik_new = $nik2[0] . "******" . $nik2[1];
            return $nik_new;
        } catch (\Throwable $th) {
            return '-';
        }
    }

    static function sensor_email($nik)
    {
        try {
            if ($nik === '-' || empty($nik)) {
                return '-';
            }
            $jumlah_sensor = 3;
            $setelah_angka_ke = 3;
            $censored = mb_substr($nik, $setelah_angka_ke, $jumlah_sensor);
            $nik2 = explode($censored, $nik);
            $nik_new = $nik2[0] . "******" . $nik2[1];
            return $nik_new;
        } catch (\Throwable $th) {
            return '-';
        }
    }
}
