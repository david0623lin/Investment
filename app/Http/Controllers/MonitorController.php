<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Monitor;

class MonitorController extends Controller
{
    public function run(Request $request)
    {
        $ticket_id = $request->input('ticket_id', 'ALL');
        $price = $request->input('price', '');
        $type = $request->input('type', 'default');
        $favorite = Ticket::getTicketListInfo();
        $ticket_lists['ALL'] = '全部';

        foreach ($favorite as $ticket){
            $ticket_lists[$ticket['ticket_id']] = $ticket['name'];
        }

        $view_datas['ticket_id'] = $ticket_id;
        $view_datas['ticket_lists'] = $ticket_lists;
        $view_datas['type'] = $type;
        $view_datas['price'] = '';

        // 預設顯示全部監控
        if ($ticket_id == 'ALL' && $type == 'default'){
            $view_datas['rets'] = Monitor::getMonitorInfoByALL();
        }

        // 新增監控
        if ($ticket_id != 'ALL' && $type != 'default' && $price != '') {
            $name = $ticket_lists[$ticket_id];
            Monitor::setMonitorInfo($ticket_id, $name, $type, $price);
            $view_datas['ticket_id'] = $ticket_id;
            $view_datas['rets'] = Monitor::getMonitorInfo($ticket_id);
        }

        // 股票管理導頁查詢個股監控
        if ($ticket_id != 'ALL' && $type == 'default' && $price == '') {
            $view_datas['rets'] = Monitor::getMonitorInfo($ticket_id);
        }

        return view('Ticket.monitor', $view_datas);
    }

    public function delete(Request $Request)
    {
        if ($Request->ajax()) {
            $price = $Request->Input('price');
            $type = $Request->Input('type');

            Monitor::deleteMonitorInfo($price, $type);

            return \Response::json(
                array(
                    'ret' => true,
                    'msg' => '監控職: '. $type. ' '. $price. ' 已從監控列表中移除'
                )
            );
        }
    }
}
