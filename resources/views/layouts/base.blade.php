<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/lib/fontiran.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lib/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lib/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lib/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lib/persian-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lib/sweetalert.min.css') }}">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('css/lib/mainstyles.css') }}">
    @yield('css')
    <title>@yield('title')</title>
</head>

<body>
    <div class="loader-box d-flex align-items-center justify-content-center w-100 h-100 d-none">
        <div class="loader">
            <svg viewBox="0 0 120 120" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <circle class="load one" cx="60" cy="60" r="40" />
                <circle class="load two" cx="60" cy="60" r="40" />
                <circle class="load three" cx="60" cy="60" r="40" />
                <g>
                <circle class="point one" cx="45" cy="70" r="5" />
                <circle class="point two" cx="60" cy="70" r="5" />
                <circle class="point three" cx="75" cy="70" r="5" />
                </g>
            </svg>
        </div>
    </div>
    @yield('profile')
    <div class="container self-style">
        @yield('content')
    </div>
    <script src="{{ asset('js/lib/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/lib/datatables.min.js') }}"></script>
    <script src="{{ asset('js/lib/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/lib/popper.min.js') }}"></script>
    <script src="{{ asset('js/lib/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/lib/persian-date.min.js') }}"></script>
    <script src="{{ asset('js/lib/persian-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/lib/moment.min.js') }}"></script>
    <script src="{{ asset('js/lib/moment-jalaali.js') }}"></script>
    <script src="{{ asset('js/lib/sweetalert2js.js') }}"></script>
    <script src="{{ asset('js/lib/jbvalidator.js') }}"></script>
    <script  type="module" src="{{ asset('js/lib/main.js') }}"></script>
    @yield('script')
</body>

</html>
