<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BOUTIQUE @yield('title')</title>
    @yield('css_before')
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('template/images/favicon.png')}}">

    <!-- Scripts -->
    <!-- Toastr -->
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/fontawesome/css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">

    <!-- Toastr -->

    <!-- Javascript -->
    <script src="{{ asset('template/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template/vendors/jquery/jquery.min.js') }}"></script>

</head>
<body>

@include('_partial.site_header')

@yield('content')


@include('_partial.site_footer')




@yield('script')
</body>

</html>
