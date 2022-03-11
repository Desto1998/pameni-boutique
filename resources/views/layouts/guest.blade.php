<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
{{--    <script src="{{ asset('js/app.js') }}" defer></script>--}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/logo/logo_gssc.png')}}">
    <!-- Styles -->
{{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    <link href="{{asset('template/css/style.css')}}" rel="stylesheet">
</head>
<body class="h-100 mt-5" style="background-image: url('{{ asset('images/bg/bg1.jpg') }}');
    background-size: 1470px; background-repeat: no-repeat">
<!--*******************
       Preloader start
   ********************-->
<div id="preloader">
    <div class="sk-three-bounce">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
    </div>
</div>
<!--*******************
    Preloader end
********************-->
{{--<div id="">--}}
<div id="main-wrapper" class="auth-layout" >

    <main class="">
        @yield('content')
    </main>
</div>

<!--**********************************
    Scripts
***********************************-->
<!-- Required vendors -->
<script src="{{asset('template/vendor/global/global.min.js')}}"></script>
<script src="{{asset('template/js/quixnav-init.js')}}"></script>
<script src="{{asset('template/js/custom.min.js')}}"></script>

</body>
</html>
