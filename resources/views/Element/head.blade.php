<!DOCTYPE html>
<html lang="zh-tw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>股票後台</title>
    <script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style type="text/css">
    @media all and (min-width: 992px) {
        .navbar .nav-item .dropdown-menu{ display: none; }
        .navbar .nav-item:hover .nav-link{ color: #fff;  }
        .navbar .nav-item:hover .dropdown-menu{ display: block; }
        .navbar .nav-item .dropdown-menu{ margin-top:0; }
    }
    </style>
    @yield('sidebar')

</head>
<body>
<div class="container-fluid px-0">
@include('Element.nav_bar')
@yield('content')
</div>
</body>
</html>