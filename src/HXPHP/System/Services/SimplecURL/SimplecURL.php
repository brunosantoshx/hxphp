<?php
namespace HXPHP\System\Services\SimplecURL;

class SimplecURL
{
    public static function connect(string $url, array $post = [], array $get = [])
    {
        $url = explode('?', $url, 2);

        if (count($url) === 2) {
            $temp_get = [];
            parse_str($url[1], $temp_get);

            $get = array_merge($get, $temp_get);
        }

        $ch = curl_init($url[0] . "?" . http_build_query($get));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        return curl_exec($ch);
    }
}