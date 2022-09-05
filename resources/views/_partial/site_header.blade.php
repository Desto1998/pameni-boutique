<div class="nav-header">
    <div class="my-3 container bg-white navbar-light justify-content-between">
        <div class="row col-md-12">
            <div class="col-md-4 col-sm-3">
                <div class="col-md-4 pt-2text-center justify-content-center d-inline-flex justify-content-center">
                    <img src="{{ asset('images/logo.svg') }}" alt="Logo" style="width: 250px;">
                </div>
            </div>
            <div class="col-md-8 col-sm-9 justify-content-end row">
                <div class="col-md-3 col-sm-6 text-center">
                        {{--                    <a class="" href="{{ route('site.boutique') }}">Boutique</a>--}}
                    <a href="{{ route('login') }}" target="_blank" class="nav-link head-element text-uppercase fs-6">
                        <span class="text-danger fs-1">
                           <i class="fa fa-user"></i>
                        </span>
                        <br>
                       <span class="titre-color-1 font-weight-bold">Connexion</span>
                    </a>
                </div>
                <div class="col-md-6 text-center">
                    <a title="Mon panier" class="nodecoration text-danger head-element nav-link fs-6" href="{{ route('site.card') }}" onclick="window.open(this.href, '',
    'toolbar=no, location=no, directories=no, status=yes, scrollbars=yes, resizable=yes, copyhistory=no, width=600, height=350  style=font-weight:bold; color: green'); return false;">

                        <span class="fs-1 text-danger">
                           <i class="fas fa-shopping-cart"></i>
                            <span class="fs-6">&nbsp; {{ (new \App\Models\Panier())->totalCartFromCard() }}&nbsp;CFA</span>
                            &nbsp;&nbsp;<span class="fs-2">({{ (new \App\Models\Panier())->numberInCard() }})</span>
                        </span>
                        <br>
                        <span class="titre-color-1 font-weight-bold">
                            MON PANIER
                        </span>
                    </a>
                </div>


            </div>

            {{--            <div class="col-md-6 p-1">--}}
            {{--                <ul class="mr-auto d-inline-flex mt-3" style="list-style: none">--}}
            {{--                    <li class="fs-4 mx-2"><a href="#" class="text-black social-icon"><i class="fa fa-twitter"></i></a></li>--}}
            {{--                    <li class="fs-4 mx-2"><a href="#" class="text-black social-icon"><i class="fa fa-pinterest"></i></a></li>--}}
            {{--                    <li class="fs-4 mx-2"><a href="#" class="text-black social-icon"><i class="fa fa-facebook"></i></a></li>--}}
            {{--                </ul>--}}
            {{--            </div>--}}
            {{--            <div class="col-md-4 pt-2text-center justify-content-center d-inline-flex justify-content-center">--}}
            {{--                <img src="{{ asset('images/logo.svg') }}" alt="Logo" style="width: 250px;">--}}
            {{--            </div>--}}
            {{--            <div class="col-md-6 mt-3 d-inline-flex justify-content-end">--}}
            {{--                <small><a class="nav-link" href="tel:+23733375923"><i class="fa fa-phone fs-4 mt-1"></i>&nbsp;&nbsp;Tel: +237 33 37 59 23</a></small>&nbsp;&nbsp;&nbsp;&nbsp;--}}
            {{--                <small><a class="nav-link" href="mailto:ppgcameroun@ppg.com"><i class="fa fa-envelope fs-4 mt-1"></i>&nbsp;&nbsp;ppgcameroun@ppg.com</a></small>--}}
            {{--            </div>--}}
        </div>
    </div>
    <nav class="navbar navbar-expand-lg  px-5 py-3 text-black header-band-back" style="">
        <a class="navbar-brand" href="#"><img src="{{ asset('images/ppg.svg') }}" style="height: 70px; width: 120px"
                                              alt="SEIGNEURIE"></a>
        <button class="navbar-toggler btn-light" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"><i class="fa fa-bars"></i></span>
        </button>

        <div class="collapse navbar-collapse ms-4" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active text-uppercase mx-3">
                    <a class="nav-link text-white font-weight-bolder fs-5" href="{{ url('/') }}">Acceuil <span
                            class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item text-uppercase mx-3">
                    <a class="nav-link text-white font-weight-bolder fs-5"
                       href="{{ route('site.boutique') }}">Boutique</a>
                </li>


                {{--                <li class="nav-item dropdown">--}}
                {{--                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                {{--                        Dropdown--}}
                {{--                    </a>--}}
                {{--                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">--}}
                {{--                        <a class="dropdown-item" href="#">Action</a>--}}
                {{--                        <a class="dropdown-item" href="#">Another action</a>--}}
                {{--                        <div class="dropdown-divider"></div>--}}
                {{--                        <a class="dropdown-item" href="#">Something else here</a>--}}
                {{--                    </div>--}}
                {{--                </li>--}}


            </ul>
            <div class="col-md-6 col-sm-12">
                <form class="form-inline my-2 my-lg-0 float-end d-flex justify-content-end align-right">
                    <input class="form-control mr-sm-2 col-md-12" type="search" placeholder="Recherche" aria-label="Search">
                    <button class="btn btn-outline-danger my-2 my-sm-0" type="submit"><i class="fa fa-search"></i></button>
                </form>

            </div>

        </div>
    </nav>

    {{--    <header>--}}
    {{--        <div class="collapse bg-dark" id="navbarHeader">--}}
    {{--            <div class="container">--}}
    {{--                <div class="row">--}}
    {{--                    <div class="col-sm-8 col-md-7 py-4">--}}
    {{--                        <h4 class="text-white">About</h4>--}}
    {{--                        <p class="text-muted"></p>--}}
    {{--                    </div>--}}
    {{--                    <div class="col-sm-4 offset-md-1 py-4">--}}
    {{--                        <h4 class="text-white">Sign in</h4>--}}
    {{--                        <ul class="list-unstyled">--}}
    {{--                            <li><a href="{{ route('login') }}" target="_blank" class="text-white">se connecter</a></li>--}}
    {{--                        </ul>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--        <div class="navbar navbar-dark bg-dark shadow-sm">--}}
    {{--            <div class="container">--}}
    {{--                <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center">--}}
    {{--                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="me-2" viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>--}}
    {{--                    <strong>MIA Industry</strong>--}}
    {{--                </a>--}}
    {{--                <a href="{{ route('site.boutique') }}" class="navbar-brand d-flex align-items-center">--}}
    {{--                    <strong>Boutique</strong>--}}
    {{--                </a>--}}
    {{--                <a title="Mon panier" class="cart" href="{{ route('site.card') }}" onclick="window.open(this.href, '',--}}
    {{--'toolbar=no, location=no, directories=no, status=yes, scrollbars=yes, resizable=yes, copyhistory=no, width=600, height=350  style=font-weight:bold; color: green'); return false;"><span class="panier-nombre">&nbsp;&nbsp;{{ (new \App\Models\Panier())->numberInCard() }}</span><i class="fas fa-shopping-cart"></i>&nbsp; {{ (new \App\Models\Panier())->totalCartFromCard() }}&nbsp;CFA</a>--}}

    {{--                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">--}}
    {{--                    <span class="navbar-toggler-icon"></span>--}}
    {{--                </button>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </header>--}}

</div>
