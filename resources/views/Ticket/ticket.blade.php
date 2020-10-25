@extends('Element.head')

@section('sidebar')
<script src="js/jquery.min.js"></script>
<script src="js/templatemo-script.js"></script>
<script>
    $(function() {
        $('button[name^="deleteTrcket"]').bind('click', function() {
            var row = this;
            var tmp = $(this).attr("info").split("/");
            var ticket_id = tmp[0];
            var name = tmp[1];
            if(confirm('確認從觀察列表中移除?\r\n' + '\r\n' + '股票編號:' + tmp[0] + '\r\n' + '股票名稱:' + tmp[1])){
                $.ajax({
                    cache   : false,
                    url     : "{{action('TicketController@delete')}}",
                    data    : {ticket_id: ticket_id, name: name},
                    type    : 'GET',
                    dataType: 'json',
                    success : function(data) {
                        if (data.ret == true) {
                            alert(data.msg);
                            reloadPage();
                        } else {
                            alert(data.msg);
                        }
                    },
                    error   : function(x, s, t) {
                    }
                });
            }
        });
    });
    function add() {
            document.form.action = "/addreservation?mem_id=&date=";
            document.form.submit();
        }
    function reloadPage(){
        location.reload()
    }
</script>
@stop

@section('content')

<main>
    <div class="mt-2 pl-3 pr-3"><h4>觀察列表</h4>
    <div class="table-responsive">
        <table bgcolor="#F0F0F0" class="table table-sm table-hover" style="border:3px #cccccc solid;" cellpadding="10" border='1'>
            <thead class="table thead-dark">
                <tr>
                    <th>編號</th>
                    <th>名稱</th>
                    <th>現價</th>
                    <th>漲跌</th>
                    <th>漲幅</th>
                    <th>昨日收盤價</th>
                    <th>當日開盤價</th>
                    <th>當日最高價</th>
                    <th>當日最低價</th>
                    <th>當日成交量</th>
                    <th>功能</th> 
                </tr>
            </thead>
            <tbody>
                @foreach ($rets as $key => $ret)
                    <tr>
                        <td align="center"><font color="#00529B"><b>{{ $ret['ticket_id'] }}</b></font></td>
                        <td align="center"><font color="#00529B">{{ $ret['name'] }}</font></td>
                        @if ($ret['price'] > $ret['lastclose'])
                            <td align="center"><font color="red">↟ {{ $ret['price'] }}</font></td>
                        @elseif ($ret['price'] < $ret['lastclose'])
                            <td align="center"><font color="green">↡ {{ $ret['price']}}</font></td>
                        @else
                            <td align="center">{{ $ret['price'] }}</td>
                        @endif
                        @if ($ret['updown'] > 0)
                            <td align="center"><font color="red">{{ $ret['updown'] }}</font></td>
                        @elseif ($ret['updown'] < 0)
                            <td align="center"><font color="green">{{ $ret['updown']}}</font></td>
                        @else
                            <td align="center">{{ $ret['updown'] }}</td>
                        @endif
                        @if ($ret['percent'] > 0)
                            <td align="center"><font color="red">{{ $ret['percent'] }}</font></td>
                        @elseif ($ret['percent'] < 0)
                            <td align="center"><font color="green">{{ $ret['percent']}}</font></td>
                        @else
                            <td align="center">{{ $ret['percent'] }}</td>
                        @endif
                        <td align="center">{{ $ret['lastclose'] }}</td>
                        <td align="center">{{ $ret['open'] }}</td>
                        <td align="center">{{ $ret['max'] }}</td>
                        <td align="center">{{ $ret['min'] }}</td>
                        <td align="center">{{ $ret['count'] }}</td>
                        <td align="center">
                            <div class="col-1.5">
                                <button type ="submit" class="btn btn-primary" onclick="javascript:location.href='{{ $ret['search_url'] }}'">詳情</button>
                                <button type ="submit" class="btn btn-warning" onclick="javascript:location.href='{{ $ret['monitor_url'] }}'">監控</button>
                                <button type="submit" class="btn btn-info" onclick="add()">庫存</button>
                                <button type="button" name="deleteTrcket" info="{{$ret['ticket_id']}}/{{$ret['name']}}" class="btn btn-danger">移除</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>

@endsection
