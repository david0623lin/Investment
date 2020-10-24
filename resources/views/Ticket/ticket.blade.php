@extends('Element.head')

@section('sidebar')
<script src="js/jquery.min.js"></script>
<script src="js/templatemo-script.js"></script>
<script>
    $(function() {
        $('button[name^="addTrcket"]').bind('click', function() {
            var row = this;
            var tmp = $(this).attr("info").split("/");
            var ticket_id = tmp[0];
            var name = tmp[1];
            if(confirm('確認新增股票到觀察列表?\r\n' + '\r\n' + '股票編號:' + tmp[0] + '\r\n' + '股票名稱:' + tmp[1])){
                $.ajax({
                    cache   : false,
                    url     : "{{action('TicketController@add')}}",
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
    <div class="mt-2 pl-3 pr-3"><h4>股票查詢</h4>
    <h3 class="pb-1 mb-3 font-italic border-bottom"></h3>
    <form class="form-horizontal" action="{{action('TicketController@run')}}" method="get">
        <div class="row pl-2">
            <div class="col-1.5 pl-2 mb-3">
                <label for="ticket_id">股票編號</label><br>
                <input type="text" class="form-control" id="ticket_id" name="ticket_id" value="{{ $ticket_id }}" />
            </div>
            <div class="col-0.5 pt-2 pl-2 mb-3">
                <label for="NewReservation""> </label><br>
                <button type="submit" class="btn btn-primary btn-block">送出</button>
            </div>
            <div class="col-1.5 pl-2 mb-3 pt-2">
                <label for="back"> </label><br>
                {{ link_to('/ticket', '返回', array('class' => 'btn btn-primary')) }}
            </div>
        </div>
    </form>
    <h3 class="pb-2 mb-3 font-italic border-bottom"></h3>
    @if ($type)
        <h4>觀察列表</h4>
    @else
        <h4>查詢結果</h4>
    @endif
    <div class="table-responsive">
        <table class="table table-sm table-hover" style="border:3px #cccccc solid;" cellpadding="10" border='1'>
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
                        <td align="center"><b>{{ $ret['ticket_id'] }}</b></td>
                        <td align="center">{{ $ret['name'] }}</td>
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
                                @if (!$ret['favorite'])
                                    <button type="button" name="addTrcket" info="{{$ticket_id}}/{{$ret['name']}}" class="btn btn-success">新增</button>
                                @else
                                    <button type ="submit" class="btn btn-warning" onclick="javascript:location.href='{{ $ret['monitor_url'] }}'">監控</button>
                                    <button type="submit" class="btn btn-info" onclick="add()">庫存</button>
                                    <button type="button" name="deleteTrcket" info="{{$ret['ticket_id']}}/{{$ret['name']}}" class="btn btn-danger">移除</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>

@endsection
