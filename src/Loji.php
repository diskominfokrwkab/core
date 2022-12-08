<?php

namespace DiskominfoCore;

use CURLFile;

class Loji
{
    public static function POST_FIREBASE($key, $data)
    {
        return self::POST('', $data, [
            'Content-Type' => 'application/json',
            'Authorization' => 'key=' . $key
        ]);
    }

    private static function setOpt($curl, $url, $method, $params = array(), $headers = array())
    {
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_HTTPHEADER => $headers,
        ));
    }

    public static function GET($url, $headers = array())
    {
        $curl = curl_init();
        self::setOpt($curl, $url, 'GET', $headers);
        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response);
    }

    public static function POST($url, $params = array(), $headers = array())
    {
        $curl = curl_init();
        self::setOpt($curl, $url, 'POST', $params, $headers);
        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response);
    }

    public static function POST_FILE($url, $data, $headers = array())
    {
        return self::POST($url, array(
            'file' => new CURLFile($data)
        ), $headers);
    }

    public static function SPL_UPLOAD($file, $path)
    {
        GeneralVariable::inits(["CORE_SPL_UPLOAD_URL", "CORE_SPL_USERNAME", "CORE_SPL_PASSWORD"]);

        $url = getenv("CORE_SPL_UPLOAD_URL");
        $username = getenv("CORE_SPL_USERNAME");
        $password = getenv("CORE_SPL_PASSWORD");

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('path' => $path, 'file' => new CURLFile($file)),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . base64_encode($username . ':' . $password)
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response);
    }

    public static function SPL_SEND_EMAIL($target, $subject, $html)
    {
        GeneralVariable::inits(["CORE_SPL_MAIL_URL", "CORE_SPL_MAIL_FROM_NAME", "CORE_SPL_USERNAME", "CORE_SPL_PASSWORD"]);

        $url = getenv("CORE_SPL_MAIL_URL");
        $fromName = getenv("CORE_SPL_MAIL_FROM_NAME");
        $username = getenv("CORE_SPL_USERNAME");
        $password = getenv("CORE_SPL_PASSWORD");

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization" => "Basic " . base64_encode($username . ':' . $password)
        ));
        curl_setopt($curl, CURLOPT_USERPWD, $username . ':' . $password);
        self::setOpt($curl, $url, 'POST', array(
            'to' => $target,
            'subject' => $subject,
            'html' => $html,
            'from_name' => $fromName
        ));

        $response = curl_exec($curl);
        curl_close($curl);


        return json_decode($response);
    }

    public static function SPL_GET($url, $param)
    {
        GeneralVariable::inits(["CORE_SPL_USERNAME", "CORE_SPL_PASSWORD"]);

        $username = getenv("CORE_SPL_USERNAME");
        $password = getenv("CORE_SPL_PASSWORD");

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization" => "Basic " . base64_encode($username . ':' . $password)
        ));
        curl_setopt($curl, CURLOPT_USERPWD, $username . ':' . $password);
        self::setOpt($curl, $url, 'GET', $param);

        $response = curl_exec($curl);
        curl_close($curl);


        return json_decode($response);
    }

    public static function SPL_POST($url, $param)
    {
        GeneralVariable::inits(["CORE_SPL_USERNAME", "CORE_SPL_PASSWORD"]);

        $username = getenv("CORE_SPL_USERNAME");
        $password = getenv("CORE_SPL_PASSWORD");

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization" => "Basic " . base64_encode($username . ':' . $password)
        ));
        curl_setopt($curl, CURLOPT_USERPWD, $username . ':' . $password);
        self::setOpt($curl, $url, 'POST', $param);

        $response = curl_exec($curl);
        curl_close($curl);


        return json_decode($response);
    }
}
