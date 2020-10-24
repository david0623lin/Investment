<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HotController extends Controller
{
    public function getUpDown()
    {
        $up = self::doParserUpDown('up');
        $down = self::doParserUpDown('down');
        $datas = array_merge($up, $down);
        $view_datas['rets'] = $datas;

        return view('Ticket.hot', $view_datas);
    }

    public static function doParserUpDown($type)
    {
        $url = 'https://www.cnyes.com/twstock/ranking2.aspx';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $input_lines = curl_exec($ch);
        curl_close($ch);

        if ($type == 'up'){
            preg_match_all('/\d{4,6}">[\x{4e00}-\x{9fa5}-A-Z]*<\/a><td class ="rt r" nowrap align="right">[.0-9]*<td nowrap align="right">[.0-9]*<td nowrap align="right">[.0-9]*/mu', $input_lines, $output_array);
        } else {
            preg_match_all('/\d{4,6}">[\x{4e00}-\x{9fa5}-A-Z]*<\/a><td class ="rt g" nowrap align="right">[-.0-9]*<td nowrap align="right">[.0-9]*<td nowrap align="right">[.0-9]*/mu', $input_lines, $output_array);
        }

        foreach ($output_array[0] as $output){
            preg_match_all('/\d{4,6}">/mu', $output, $ticket_id);
            preg_match_all('/>[\x{4e00}-\x{9fa5}-A-Z]*<\//mu', $output, $name);

            if ($type == 'up') {
                preg_match_all('/right">[.0-9]*/mu', $output, $all_price);
            } else {
                preg_match_all('/right">[-.0-9]*/mu', $output, $all_price);
            }

            $info['ticket_id'] = explode('"', $ticket_id[0][0])[0];
            $info['name'] = explode('<', explode('>', $name[0][0])[1])[0];

            foreach ($all_price[0] as $key => $value){
                switch ($key){
                    case 0:
                        $info['percent'] = explode('>', $value)[1];
                    break;
                    case 1:
                        $info['today'] = explode('>', $value)[1];
                    break;
                    case 2:
                        $info['yesterday'] = explode('>', $value)[1];
                    break;
                    default:
                }
            }

            $datas[] = $info;
        }

        return $datas;
    }
}
