<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Classes\ParserTicket;

class TicketController extends Controller
{
    public function run(Request $request)
    {
        $ticket_id = $request->input('ticket_id', '');
        $view_datas['type'] = true;
        $favorite = true;

        if ($ticket_id == ''){
            $ticket_lists = Ticket::getTicketListInfo();
        } else {
            $ticket_lists = Ticket::getTicketInfo($ticket_id);
            $view_datas['type'] = false;

            if ($ticket_lists == array()){
                $ticket_lists = array(array('ticket_id' => $ticket_id));
                $favorite = false;
            }
        }

        foreach ($ticket_lists as $ticket_value){
            $id = $ticket_value['ticket_id'];

            if ($ticket_id == $id){
                $ticket_all[$id]['favorite'] = true;
            }

            $ticket_info = json_decode(ParserTicket::get($id), true);

            $ticket_all[$id]['ticket_id'] = $id; #編號
            $ticket_all[$id]['name'] = $ticket_info['data']['quote']['200009']; #名稱
            $ticket_all[$id]['price'] = sprintf('%.2f', $ticket_info['data']['quote']['6']); #現價
            $ticket_all[$id]['updown'] = sprintf('%.2f', $ticket_info['data']['quote']['11']); #漲幅
            $ticket_all[$id]['percent'] = $ticket_info['data']['quote']['56']. '%'; #漲幅百分比
            $ticket_all[$id]['lastclose'] = sprintf('%.2f', $ticket_info['data']['quote']['21']); #昨日收盤價
            $ticket_all[$id]['open'] = sprintf('%.2f', $ticket_info['data']['h'][count($ticket_info['data']['h']) - 1]); #開盤價
            $ticket_all[$id]['max'] = sprintf('%.2f', max($ticket_info['data']['h'])); #當日最高
            $ticket_all[$id]['min'] = sprintf('%.2f', min($ticket_info['data']['h'])); #當日最低
            $ticket_all[$id]['count'] = (string) array_sum($ticket_info['data']['v']); #當日成交張數
            $ticket_all[$id]['favorite'] = $favorite;
            $ticket_all[$id]['monitor_url'] = "/monitor?ticket_id=". $id;
        }

        $view_datas['ticket_id'] = $ticket_id;
        $view_datas['rets'] = $ticket_all;

        return view('Ticket.ticket', $view_datas);
    }

    public function add(Request $Request)
    {
        if ($Request->ajax()) {
            $ticket_id = $Request->Input('ticket_id');
            $name = $Request->Input('name');

            $favorite = Ticket::getTicketListInfo();

            foreach ($favorite as $value){
                if ($value['ticket_id'] == $ticket_id){
                    return \Response::json(
                        array(
                            'ret' => false,
                            'msg' => $name. ' - '. $ticket_id. ' 該股票已在觀察列表'
                        )
                    );
                }
            }

            Ticket::setTicketFavorite($ticket_id, $name);
            $check = Ticket::getTicketInfo($ticket_id);

            if ($check[0]['ticket_id']){
                return \Response::json(
                    array(
                        'ret' => true,
                        'msg' => $name. ' - '. $ticket_id. ' 已新增至觀察列表'
                    )
                );
            } else {
                return \Response::json(array('ret' => false, 'msg' => '操作失敗'));
            }
        }
    }

    public function delete(Request $Request)
    {
        if ($Request->ajax()) {
            $ticket_id = $Request->Input('ticket_id');
            $name = $Request->Input('name');

            Ticket::deleteTicketFavorite($ticket_id);
            $check = Ticket::getTicketInfo($ticket_id);

            if ($check == array()){
                return \Response::json(
                    array(
                        'ret' => true,
                        'msg' => $name. ' - '. $ticket_id. ' 已從觀察列表中移除'
                    )
                );
            } else {
                return \Response::json(array('ret' => false, 'msg' => '操作失敗'));
            }
        }
    }
}
