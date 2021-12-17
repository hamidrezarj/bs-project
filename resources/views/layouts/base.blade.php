<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/lib/fontiran.css')}}">
    <link rel="stylesheet" href="{{asset('css/lib/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/lib/bootstrap.rtl.min.css')}}">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="{{asset('css/lib/mainstyles.css')}}">
    @yield('css')
    <title>@yield('title')</title>
</head>

<body>
    <div class="container self-style">
        @yield('content')
    </div>
    <script src="{{asset('js/lib/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('js/lib/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/lib/popper.min.js')}}"></script>
    <script src="{{asset('js/lib/bootstrap.bundle.min.js')}}"></script>
    @yield('script')
</body>
</html>