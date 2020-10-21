<?php

namespace App\Classes;

class ParserTicket
{
    public static function get($id)
    {
        $url = 'https://ws.api.cnyes.com/ws/api/v1/charting/history?resolution=1&symbol=TWS:'. $id. ':STOCK&quote=1';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $html = curl_exec($ch);
        curl_close($ch);

        return $html;
    }
}
