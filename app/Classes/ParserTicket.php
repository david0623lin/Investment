<?php

namespace App\Classes;

class ParserTicket
{
    public static function init($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $html = curl_exec($ch);
        curl_close($ch);

        return $html;
    }

    /**
     * 當日資訊
     */
    public static function getOverView($id)
    {
        $url = 'https://ws.api.cnyes.com/ws/api/v1/charting/history?resolution=1&symbol=TWS:'. $id. ':STOCK&quote=1';
        $html = self::init($url);

        return $html;
    }

    /**
     * 歷史走勢
     */
    public static function getHistory($id, $start, $end)
    {
        $url = 'https://ws.api.cnyes.com/ws/api/v1/charting/history?resolution=D&symbol=TWS:'. $id. ':STOCK&from='. $end. '&to='. $start;
        $html = self::init($url);

        return $html;
    }

    /**
     * 三大法人
     */
    public static function getInstitution($id, $start, $end)
    {
        $url = 'https://marketinfo.api.cnyes.com/mi/api/v1/investors/buysell/TWS%3A'. $id. '%3ASTOCK?from='. $end. '&to='. $start;
        $html = self::init($url);

        return $html;
    }

    /**
     * 基本資料
     */
    public static function getProfile($id)
    {
        $url = 'https://marketinfo.api.cnyes.com/mi/api/v1/TWS:'. $id. ':STOCK/info';
        $html = self::init($url);

        return $html;
    }
}
