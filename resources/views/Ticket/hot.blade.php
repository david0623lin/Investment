@extends('Element.head')

@section('sidebar')

@stop

@section('content')

<main>
    <div class="mt-2 pl-3 pr-3"><h4>🔥🔥🔥 漲跌幅前30名股票 🔥🔥🔥</h4>
    <h3 class="pb-2 mb-3 font-italic border-bottom"></h3>
    <div class="table-responsive">
        <table bgcolor="#F0F0F0" class="table table-sm table-hover" style="width: 60%; border:3px #cccccc solid;" cellpadding="10" border='1'>
            <thead class="table thead-dark">
                <tr>
                    <th>編號</th>
                    <th>名稱</th>
                    <th>漲幅</th>
                    <th>今收</th>
                    <th>昨收</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rets as $key => $ret)
                    <tr>
                        <td align="center"><font color="#00529B"><b>{{ $ret['ticket_id'] }}</b></font></td>
                        <td align="center"><font color="#00529B">{{ $ret['name'] }}</font></td>
                        @if ($ret['percent'] > 0)
                            <td align="center"><font color="red">{{ $ret['percent'] }}%</font></td>
                        @else
                            <td align="center"><font color="green">{{ $ret['percent']}}%</font></td>
                        @endif
                        <td align="center">{{ $ret['today'] }}</td>
                        <td align="center">{{ $ret['yesterday'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
</main>

@endsection
