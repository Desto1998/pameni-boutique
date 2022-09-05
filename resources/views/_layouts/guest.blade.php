<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SEIGNEURIE-LOGIN</title>
    @yield('css_before')
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('template/images/favicon.png')}}">
    <!-- Datatable css -->
    <link href="{{asset('template/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}" rel="stylesheet">
    <link href="{{asset('template/vendors/ti-icons/css/themify-icons.css')}}" rel="stylesheet">
    <link href="{{asset('template/js/select.dataTables.min.css')}}" rel="stylesheet">

    <!-- Scripts -->
    <!-- Toastr -->
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('app.css') }}">
    <link href="{{asset('template/css/vertical-layout-light/style.css')}}" rel="stylesheet">
    <link href="{{asset('template/css/vertical-layout-light/style.css')}}" rel="stylesheet">
    <!-- Toastr -->

    <link href="{{asset('template/vendors/plugins/toastr/css/toastr.min.css')}}" rel="stylesheet">
    <!-- Javascript -->
    <script src="{{ asset('app.js') }}" defer></script>

    <script src="{{ asset('template/vendors/jquery/jquery.min.js') }}"></script>

</head>
<body>
{{--<div class=" container-scroller">--}}
{{--   --}}
{{--</div> --}}
@yield('content')
<!-- plugins:js -->
<script src="{{ asset('template/vendors/js/vendor.bundle.base.js') }}"></script>
<!-- endinject -->

<!-- Plugin js for this page -->

<!-- Plugin js for this page -->
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{ asset('template/js/off-canvas.js') }}"></script>
<script src="{{ asset('template/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('template/js/template.js') }}"></script>
<script src="{{ asset('template/js/todolist.js') }}"></script>



<!-- endinject -->
<!-- Custom js for this page-->
<!-- End custom js for this page-->


@yield('script')
</body>

</html>
