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
<div class="bg-light navbar-light justify-content-between">
    <div class="col-md-12 row">
        <div class="col-md-4 p-5">
            <ul class="mr-auto d-inline-flex" style="list-style: none">
                <li class="fs-4 mx-2"><a href="#" class="text-black social-icon"><i class="fa fa-twitter"></i></a></li>
                <li class="fs-4 mx-2"><a href="#" class="text-black social-icon"><i class="fa fa-pinterest"></i></a></li>
                <li class="fs-4 mx-2"><a href="#" class="text-black social-icon"><i class="fa fa-facebook"></i></a></li>
            </ul>
        </div>
        <div class="col-md-4 pt-2text-center justify-content-center d-inline-flex justify-content-center">
            <img src="{{ asset('images/logo.svg') }}" alt="Logo" style="width: 250px;">
        </div>
        <div class="col-md-4 pt-2 d-inline-flex justify-content-center">
            <img src="{{ asset('images/ppg.svg') }}" alt="Logo" style="width: 100px;">
        </div>
    </div>
</div>
<div class="page-content">
    <div class="row col-md-12">
        <div class="full-back d-flex justify-content-center">
            <div class="">
                <p>
                <span class="text-white h1 justify-content-center text-center">WELCOME TO BOUTIQUE</span>
                </p>
                <p class="text-center">
                    <a class="btn btn-primary" href="{{ route('site.home') }}">Naviguez vers la page d'acceuil</a>
                </p>
            </div>
        </div>
    </div>
    <div class="container-fluid my-5">
        <div class="row text-center">
            <h3 class="bg-light text-uppercase py-3">Nos Categories</h3>
        </div>
        <div class="row col-md-12 my-4 justify-content-between">
            <div class="col-md-3 col-sm-6 cat-int">
                <label class="font-weight-bold fs-5 titre-color-1 text-uppercase">Peinture interieure</label>
            </div>
            <div class="col-md-3 col-sm-6 cat-ext">
                <label class="font-weight-bold fs-5 text-white text-uppercase">Peinture Extrerieure</label>
            </div>
            <div class="col-md-3 col-sm-6 cat-sol">
                <label class="font-weight-bold fs-5 titre-color-1 text-uppercase">Peinture du sol</label>
            </div>
{{--            <div class="col-md-3 col-sm-6 cat-fac">--}}
{{--                <label class="font-weight-bold fs-5 titre-color-1 text-uppercase">Peinture facade</label>--}}
{{--            </div>--}}
        </div>
    </div>
</div>



@include('_partial.site_footer')
</body>

</html>
