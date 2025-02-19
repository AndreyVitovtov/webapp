<?php

namespace App\Utility;

class Curl
{
    public static function POST(string $url, $data, $headers = null): bool|string
    {
        if (is_array($data)) $data = http_build_query($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        if ($headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public static function GET($url, ?array $data = null, $headers = null): bool|string
    {
        if ($data) $url .= "?" . http_build_query($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        if ($headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public static function multi($params): array
    {
        $mh = curl_multi_init();

        $handles = [];
        foreach ($params as $key => $param) {
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $param['url'],
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $param['data'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT => 0
            ));
            curl_multi_add_handle($mh, $ch);
            $handles[$key] = $ch;
        }

        do {
            $status = curl_multi_exec($mh, $running);
            if ($status != CURLM_OK) {
                break;
            }
        } while ($running > 0);

        $results = [];
        foreach ($handles as $url => $ch) {
            $results[$url] = curl_multi_getcontent($ch);
            curl_multi_remove_handle($mh, $ch);
            curl_close($ch);
        }
        curl_multi_close($mh);

        return $results;
    }
}
