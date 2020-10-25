<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\ParserTicket;
use App\Models\Ticket;

class SearchController extends Controller
{
    public function run(Request $request)
    {
        $ticket_id = $request->input('ticket_id', '');
        $start = date('Y-m-01', strtotime(date("Y-m-d")));
        $end = date('Y-m-d', strtotime("$start +1 month -1 day"));
        $start = strtotime($start. ' 08:00:00');
        $end = strtotime($end. ' 23:59:59');

        $view_datas['ticket_id'] = $ticket_id;
        $alls = Ticket::getTicketListInfo();
        $view_datas['favorite'] = false;

        foreach ($alls as $value){
            if ($ticket_id == $value['ticket_id']){
                $view_datas['favorite'] = true;
            }
        }

        if ($ticket_id == ''){
            $view_datas['info'] = array();
            $view_datas['rets'] = array();
            $view_datas['other'] = array();
            $view_datas['today'] = array();
            $view_datas['name'] = '';
            $view_datas['open'] = '';
            return view('Ticket.search', $view_datas);
        }

        $profile_data = json_decode(ParserTicket::getProfile($ticket_id), true);
        $history_data = json_decode(ParserTicket::getHistory($ticket_id, $start, $end), true);
        $institution_data = json_decode(ParserTicket::getInstitution($ticket_id, $start, $end), true);
        $institution_data = array_reverse($institution_data['data']);
        $orveview_data = json_decode(ParserTicket::getOverView($ticket_id), true);
        // dd($profile_data, $history_data, $institution_data);

        $info['id'] = $profile_data['data']['symbolId'];
        $info['type'] = $profile_data['data']['stockType'];
        $info['name'] = $profile_data['data']['companyName'];
        $info['address'] = $profile_data['data']['companyAddress'];
        $info['class'] = $profile_data['data']['industryType'];
        $info['main'] = $profile_data['data']['description'];
        $info['gold'] = $profile_data['data']['netAsset'];
        $info['outgold'] = $profile_data['data']['foreignStockOwnRatio'];
        
        foreach ($history_data['data']['t'] as $key => $date){
            $datas[$key]['date'] = date('Y-m-d', $date);
        }

        foreach ($history_data['data']['o'] as $key => $open){
            $datas[$key]['open'] = sprintf('%.2f', $open);
        }

        foreach ($history_data['data']['h'] as $key => $max){
            $datas[$key]['max'] = sprintf('%.2f', $max);
        }

        foreach ($history_data['data']['l'] as $key => $min){
            $datas[$key]['min'] = sprintf('%.2f', $min);
        }

        foreach ($history_data['data']['c'] as $key => $close){
            $datas[$key]['close'] = sprintf('%.2f', $close);
        }

        foreach ($history_data['data']['v'] as $key => $count){
            $datas[$key]['count'] = (int) $count;
        }

        foreach ($institution_data as $key => $institution){
            $other[$key]['date'] = $institution['date'];
            $other[$key]['foreign'] = $institution['foreignNetBuySellVolume'];
            $other[$key]['domestic'] = $institution['domesticNetBuySellVolume'];
            $other[$key]['dealer'] = $institution['dealerNetBuySellVolume'];
            $other[$key]['total'] = $institution['totalNetBuySellVolume'];
        }

        $t_data = array_reverse($orveview_data['data']['t']);
        foreach ($t_data as $i => $value){
            $today[$i]['t'] = date('Y-m-d H:i:s', $value);
        }

        $o_data = array_reverse($orveview_data['data']['o']);
        foreach ($o_data as $i => $value){
            $today[$i]['o'] = sprintf('%.2f', $value);
        }

        $v_data = array_reverse($orveview_data['data']['v']);
        foreach ($v_data as $i => $value){
            $today[$i]['v'] = $value;
        }

        $view_datas['info'] = array($info);
        $view_datas['rets'] = $datas;
        $view_datas['other'] = $other;
        $view_datas['today'] = $today;
        $view_datas['name'] = $orveview_data['data']['quote']['200009'];
        $view_datas['open'] = sprintf('%.2f', $orveview_data['data']['quote']['21']);

        return view('Ticket.search', $view_datas);
    }

    public function add(Request $Request)
    {
        if ($Request->ajax()) {
            $ticket_id = $Request->Input('ticket_id');
            $name = $Request->Input('name');

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
}
