<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/ico">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>سامانه تیکتینگ | @yield('title')</title>

    <link rel="stylesheet" href="{{ asset('css/lib/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lib/fontiran.css') }}">

    <style>
        html,body {
            user-select: none;
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
            font-family: "IRANSansFaNum";
            height: 100vh;
            width: 100vw;
            overflow: hidden !important;
            background-color: #151925;
        }
    </style>

</head>

<body>
    <div class="d-flex h-100 d-flex justify-content-center">
        @yield('content')
    </div>
</body>

</html>
