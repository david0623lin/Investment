<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monitor extends Model
{
    protected $connection;
    protected $table = 'Monitor';
    protected $primarykey = 'id';
    public $timestamps = false;

    public static function getMonitorInfoByALL()
    {
        $info = self::get()->toArray();
        $ret = ($info != array()) ? $info : array();

        return $ret;
    }

    public static function getMonitorInfo($ticket_id)
    {
        $info = self::where('ticket_id', $ticket_id)->get()->toArray();
        $ret = ($info != array()) ? $info : array();

        return $ret;
    }

    public static function setMonitorInfo($ticket_id, $name, $type, $price)
    {
        self::insert([
            'ticket_id' => $ticket_id,
            'name' => $name,
            'price' => $price,
            'type' => $type,
            'status' => 'false'
        ]);
    }

    public static function deleteMonitorInfo($price, $type)
    {
        self::where('price', $price)->where('type', $type)->delete();
    }
}
