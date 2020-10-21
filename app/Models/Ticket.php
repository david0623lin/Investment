<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $connection;
    protected $table = 'Ticket';
    protected $primarykey = 'id';
    public $timestamps = false;

    public static function setTicketFavorite($ticket_id, $name)
    {
        self::insert([
            'ticket_id' => $ticket_id,
            'name' => $name,
            'create_at' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) + 28800),
        ]);
    }

    public static function deleteTicketFavorite($ticket_id)
    {
        self::where('ticket_id', $ticket_id)->delete();
    }

    public static function getTicketInfo($ticket_id)
    {
        $info = self::where('ticket_id', $ticket_id)->get()->toArray();
        
        $ret = ($info != array()) ? $info : array();

        return $ret;
    }

    public static function getTicketListInfo()
    {
        $info = self::orderby('ticket_id', 'ASC')->get()->toArray();
        
        $ret = ($info != array()) ? $info : array();

        return $ret;
    }
}
