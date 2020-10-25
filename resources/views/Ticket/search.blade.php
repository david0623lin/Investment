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
                    url     : "{{action('SearchController@add')}}",
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
    function reloadPage(){
        location.reload()
    }
</script>
@stop

@section('content')

<main>
    <div class="mt-2 pl-3 pr-3"><h4>股票查詢</h4>
    <h3 class="pb-1 mb-3 font-italic border-bottom"></h3>
    <form class="form-horizontal" action="{{action('SearchController@run')}}" method="get">
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
                <input type ="button" class="btn btn-primary btn-block" onclick="history.back()" value="返回"></input>
            </div>
        </div>
    </form>
    <h3 class="pb-2 mb-3 font-italic border-bottom"></h3>
    @if ($ticket_id != '')
    <div class="table-responsive">
        <h4>股票資訊</h4>
        <table bgcolor="#F0F0F0" class="table table-sm table-hover" style="border:3px #cccccc solid;" cellpadding="10" border='1'>
            <thead class="table thead-dark">
                <tr>
                    <th>股票編號</th>
                    <th>公司名稱</th>
                    <th>類別</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($info as $value)
                    <tr>
                        <td align="center" style="width: 20%"><font color="#00529B"><b>{{ $value['id'] }}</b></font></td>
                        <td align="center" style="width: 70%"><font color="#00529B">{{ $value['name'] }}</font></td>
                        <td align="center" style="width: 10%">{{ $value['type'] }}</td>
                    </tr>
                @endforeach
            </tbody>
            <thead class="table thead-dark">
                <tr>
                    <th>產業別</th>
                    <th>主營業務</th>
                    <th>功能</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($info as $value)
                    <tr>
                        <td align="center">{{ $value['class'] }}</td>
                        <td align="center">{{ $value['main'] }}</td>
                        @if ($favorite == false)
                            <td align="center"><button type="button" name="addTrcket" info="{{$ticket_id}}/{{$name}}" class="btn btn-success">新增</button></td>
                        @else
                            <td> </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h4>歷史走勢</h4>
        <table bgcolor="#F0F0F0" class="table table-sm table-hover" style="border:3px #cccccc solid;" cellpadding="10" border='1'>
            <thead class="table thead-dark">
                <tr>
                    <th>日期</th>
                    <th>開盤</th>
                    <th>最高</th>
                    <th>最低</th>
                    <th>收盤</th>
                    <th>成交張數</th>
                </tr>	
            </thead>
            <tbody>
                @foreach ($rets as $key => $ret)
                    <tr>
                        <td align="center"><font color="#00529B"><b>{{ $ret['date'] }}</b></font></td>
                        <td align="center">{{ $ret['open'] }}</td>
                        <td align="center">{{ $ret['max'] }}</td>
                        <td align="center">{{ $ret['min'] }}</td>
                        <td align="center">{{ $ret['close'] }}</td>
                        <td align="center">{{ $ret['count'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h4>三大法人</h4>
        <table bgcolor="#F0F0F0" class="table table-sm table-hover" style="border:3px #cccccc solid;" cellpadding="10" border='1'>
            <thead class="table thead-dark">
                <tr>
                    <th style="width: 25%">外資</th>
                    <th style="width: 25%">投信</th>
                    <th style="width: 25%">自營商</th>
                    <th style="width: 25%">合計</th>
                </tr>	
            </thead>
            <tbody>
                @foreach ($other as $key => $ret)
                    <tr>
                        @if ($ret['foreign'] > 0)
                            <td align="center"><font color="red"> {{ $ret['foreign'] }}</font></td>
                        @elseif ($ret['foreign'] < 0)
                            <td align="center"><font color="green"> {{ $ret['foreign'] }}</font></td>
                        @else
                            <td align="center">{{ $ret['foreign'] }}</td>
                        @endif

                        @if ($ret['domestic'] > 0)
                            <td align="center"><font color="red"> {{ $ret['domestic'] }}</font></td>
                        @elseif ($ret['domestic'] < 0)
                            <td align="center"><font color="green"> {{ $ret['domestic'] }}</font></td>
                        @else
                            <td align="center">{{ $ret['domestic'] }}</td>
                        @endif

                        @if ($ret['dealer'] > 0)
                            <td align="center"><font color="red"> {{ $ret['dealer'] }}</font></td>
                        @elseif ($ret['dealer'] < 0)
                            <td align="center"><font color="green"> {{ $ret['dealer'] }}</font></td>
                        @else
                            <td align="center">{{ $ret['dealer'] }}</td>
                        @endif

                        @if ($ret['total'] > 0)
                            <td align="center"><font color="red"><b> {{ $ret['total'] }}</b></font></td>
                        @elseif ($ret['total'] < 0)
                            <td align="center"><font color="green"><b> {{ $ret['total'] }}</b></font></td>
                        @else
                            <td align="center"><b>{{ $ret['total'] }}</b></td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h4>當日各時段價位、成交量</h4>
        <table bgcolor="#F0F0F0" class="table table-sm table-hover" style="width: 50%; border:3px #cccccc solid;" cellpadding="10" border='1'>
            <thead class="table thead-dark">
                <tr>
                    <th>時段</th>
                    <th>價錢</th>
                    <th>數量</th>
                </tr>	
            </thead>
            <tbody>
                @foreach ($today as $value)
                    <tr>
                        <td align="center">{{ $value['t'] }}</td>
                        @if ($value['o'] > $open)
                            <td align="center"><font color="red"><b> {{ $value['o'] }}</b></font></td>
                        @elseif ($value['o'] < $open)
                            <td align="center"><font color="green"><b> {{ $value['o'] }}</b></font></td>
                        @else
                            <td align="center"><b>{{ $value['o'] }}</b></td>
                        @endif
                        <td align="center">{{ $value['v'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</main>

@endsection
