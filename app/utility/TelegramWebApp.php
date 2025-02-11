<?php

namespace App\Utility;

class TelegramWebApp
{
    public static function validatingData($initData, $telegramToken = TELEGRAM_TOKEN): bool
    {
        $secretKey = hash_hmac('sha256', $telegramToken, 'WebAppData', true);
        parse_str($initData, $data);
        $receivedHash = $data['hash'];
        unset($data['hash']);
        ksort($data);
        $dataCheckString = '';
        foreach ($data as $key => $value) {
            $dataCheckString .= $key . '=' . $value . "\n";
        }
        $dataCheckString = rtrim($dataCheckString, "\n");

        $hmac = hash_hmac('sha256', $dataCheckString, $secretKey);

        return $receivedHash == $hmac;
    }
}