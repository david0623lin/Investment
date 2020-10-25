@extends('Element.head')

@section('sidebar')
<script src="js/jquery.min.js"></script>
<script src="js/templatemo-script.js"></script>
<script>
    $(function() {
        $('button[name^="deleteTrcket"]').bind('click', function() {
            var row = this;
            var tmp = $(this).attr("info").split("/");
            var price = tmp[0];
            var type = tmp[1];
            if(confirm('確認從監控列表中移除?\r\n' + '\r\n' + '監控值:' + tmp[0] + '\r\n' + '狀態:' + tmp[1])){
                $.ajax({
                    cache   : false,
                    url     : "{{action('MonitorController@delete')}}",
                    data    : {price: price, type: type},
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
    <div class="mt-2 pl-3 pr-3"><h4>設定監控</h4>
    <h3 class="pb-1 mb-3 font-italic border-bottom"></h3>
    <form class="form-horizontal" action="{{action('MonitorController@run')}}" method="get">
        <div class="row pl-2">
            <div class="col-1.5 pl-2 mb-3">
                <label for="game_type">股票</label><br>
                {{Form::select('ticket_id', $ticket_lists, $ticket_id, array('class' => 'custom-select d-block w-100'))}}
            </div>
            <div class="col-1.5 pl-2 mb-3">
                <label for="type">狀態</label><br>
                <select name="type" class="custom-select d-block w-100'">
                    <option value="default">請選擇</option>
                    <option value=">=">大於等於</option>
                    <option value="<">小於</option>
                </select>
            </div>
            <div class="col-1.5 pl-2 mb-3">
                <label for="price">監控值</label><br>
                <input type="text" class="form-control" id="price" name="price" value="{{ $price }}" />
            </div>
            <div class="col-0.5 pt-2 pl-2 mb-3">
                <label for="NewReservation""> </label><br>
                <button type="submit" class="btn btn-primary btn-block">新增</button>
            </div>
            <div class="col-1.5 pl-2 mb-3 pt-2">
                <label for="back"> </label><br>
                <input type ="button" class="btn btn-primary btn-block" onclick="history.back()" value="返回"></input>
            </div>
        </div>
    </form>
    <h3 class="pb-2 mb-3 font-italic border-bottom"></h3>
    <h4>監控列表</h4>
    <div class="table-responsive">
        <table bgcolor="#F0F0F0" class="table table-sm table-hover" style="width: 60%; border:3px #cccccc solid;" cellpadding="10" border='1'>
            <thead class="table thead-dark">
                <tr>
                    <th>編號</th>
                    <th>名稱</th>
                    <th>監控金額</th>
                    <th>觸發狀態</th>
                    <th>是否觸發</th>
                    <th>功能</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rets as $key => $ret)
                    <tr>
                        <td align="center"><font color="#00529B"><b>{{ $ret['ticket_id'] }}</b></font></td>
                        <td align="center"><font color="#00529B">{{ $ret['name'] }}</font></td>
                        <td align="center">{{ $ret['price'] }}</td>
                        <td align="center">{{ $ret['type'] }}</td>
                        @if ($ret['status'] == 'true')
                            <td align="center">已觸發</td>
                        @else
                            <td align="center">未觸發</td>
                        @endif
                        <td align="center">
                            <div class="col-1.5">
                                <button type="button" name="deleteTrcket" info="{{$ret['price']}}/{{$ret['type']}}" class="btn btn-danger">移除</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>

@endsection
