<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>GSC-APP @yield('title')</title>
    @yield('css_before')
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/logo/logo_gssc.png')}}">
    <!-- Datatable css -->
    <link href="{{asset('template/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">

    <!-- Scripts -->
    <!-- Toastr -->
<!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('app.css') }}">
    <link href="{{asset('template/css/style.css')}}" rel="stylesheet">
    <!-- Toastr -->
    <link href="{{asset('template/vendor/plugins/toastr/css/toastr.min.css')}}" rel="stylesheet">

    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
</head>
<body>
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
<!--**********************************
       Main wrapper start
   ***********************************-->
<div id="main-wrapper">

    <!--**********************************
        Nav header start
    ***********************************-->
    <div class="nav-header">
        <a href="{{ route('home') }}" class="brand-logo">
            <img class="logo-abbr" style="width: 50px;height: 40px" src="{{asset('images/logo/logo_gssc.png')}}"
                 alt="Not found">
            {{--            <img class="logo-compact" src="{{asset('images/logo/logo_gssc.png')}}" alt="">--}}
            <img class="brand-title" src="{{asset('images/logo/logo_gssc.png')}}" alt="">
        </a>

        <div class="nav-control">
            <div class="hamburger">
                <span class="line"></span><span class="line"></span><span class="line"></span>
            </div>
        </div>
    </div>
    <!--**********************************
        Nav header end
    ***********************************-->

    <!--**********************************
        Header start
    ***********************************-->
    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <div class="search_bar dropdown">
{{--                                <span class="search_icon p-3 c-pointer" data-toggle="dropdown">--}}
{{--                                    <i class="mdi mdi-magnify"></i>--}}
{{--                                </span>--}}
{{--                            <div class="dropdown-menu p-0 m-0">--}}
{{--                                <form>--}}
{{--                                    <input class="form-control" type="search" placeholder="Search" aria-label="Search">--}}
{{--                                </form>--}}
{{--                            </div>--}}
                        </div>
                    </div>

                    <ul class="navbar-nav header-right">
                        <li class="nav-item dropdown notification_dropdown">
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                <i class="mdi mdi-bell"></i>
                                <div class="pulse-css"></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <ul class="list-unstyled">
                                    <li class="media dropdown-item">
                                        <span class="success"><i class="ti-user"></i></span>
                                        <div class="media-body">
                                            <a href="#">
                                                <p><strong>Martin</strong> has added a <strong>customer</strong>
                                                    Successfully
                                                </p>
                                            </a>
                                        </div>
                                        <span class="notify-time">3:20 am</span>
                                    </li>
                                    <li class="media dropdown-item">
                                        <span class="primary"><i class="ti-shopping-cart"></i></span>
                                        <div class="media-body">
                                            <a href="#">
                                                <p><strong>Jennifer</strong> purchased Light Dashboard 2.0.</p>
                                            </a>
                                        </div>
                                        <span class="notify-time">3:20 am</span>
                                    </li>
                                    <li class="media dropdown-item">
                                        <span class="danger"><i class="ti-bookmark"></i></span>
                                        <div class="media-body">
                                            <a href="#">
                                                <p><strong>Robin</strong> marked a <strong>ticket</strong> as unsolved.
                                                </p>
                                            </a>
                                        </div>
                                        <span class="notify-time">3:20 am</span>
                                    </li>
                                    <li class="media dropdown-item">
                                        <span class="primary"><i class="ti-heart"></i></span>
                                        <div class="media-body">
                                            <a href="#">
                                                <p><strong>David</strong> purchased Light Dashboard 1.0.</p>
                                            </a>
                                        </div>
                                        <span class="notify-time">3:20 am</span>
                                    </li>
                                    <li class="media dropdown-item">
                                        <span class="success"><i class="ti-image"></i></span>
                                        <div class="media-body">
                                            <a href="#">
                                                <p><strong> James.</strong> has added a<strong>customer</strong>
                                                    Successfully
                                                </p>
                                            </a>
                                        </div>
                                        <span class="notify-time">3:20 am</span>
                                    </li>
                                </ul>
                                <a class="all-notification" href="#">See all notifications <i
                                        class="ti-arrow-right"></i></a>
                            </div>
                        </li>
                        <li class="nav-item dropdown header-profile">
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                {{ Auth::user()->lastname }} {{ Auth::user()->firstname }}
                                @if (!empty(Auth::user()->profile_photo_path))
                                    <img src="{{ asset('images/profil/'.Auth::user()->profile_photo_path) }}"
                                         style="height: 60px; width: 60px" alt="Image introuvable">
                                @else
                                    <i class="mdi mdi-account"></i>
                                @endif

                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="{{ route('user.profile') }}" class="dropdown-item">
                                    <i class="icon-user"></i>
                                    <span class="ml-2">Profil </span>
                                </a>
{{--                                <a href="./email-inbox.html" class="dropdown-item">--}}
{{--                                    <i class="icon-envelope-open"></i>--}}
{{--                                    <span class="ml-2">Inbox </span>--}}
{{--                                </a>--}}

                                <form action="{{ route('logout') }}" method="post" id="logout-form">
                                    @csrf
                                    <a type="submit" class="dropdown-item" data-toggle="modal"
                                       data-target="#logoutModal">
                                        <i class="icon-key"></i>
                                        <span class="ml-2">Se déconnecter </span>
                                    </a>
                                </form>

                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <!--**********************************
        Header end ti-comment-alt
    ***********************************-->

    <!--**********************************
        Sidebar start
    ***********************************-->
    <div class="quixnav">
        <div class="quixnav-scroll">
            <ul class="metismenu" id="menu">
            {{--                <li class="nav-label first">Tableau de bord</li>--}}
            <!-- <li><a href="index.html"><i class="icon icon-single-04"></i><span class="nav-text">Dashboard</span></a>
                </li> -->
                <li><a class="" href="{{ route('home') }}" aria-expanded="false"><i
                            class="icon icon-home"></i><span class="nav-text">Tableau de bord</span></a>
                </li>
                <li class="nav-label">GESTION DE LA FACTURATION</li>

                <li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false"><i
                            class="fa fa-database"></i><span class="nav-text">Dévis</span></a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('devis.add') }}">Créer un dévis</a></li>
                        <li><a href="{{ route('devis.all') }}">Gestion des dévis</a></li>
                    </ul>
                </li>

                <li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false"><i
                            class="fa fa-file"></i><span class="nav-text">Factures</span></a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('factures.add') }}">Créer une facture</a></li>
                        <li><a href="{{ route('factures.all') }}">Gestion des factures</a></li>
                    </ul>
                </li>

                <li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false"><i
                            class="fa fa-cart-plus"></i><span class="nav-text">Commandes</span></a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('commandes.add') }}">Créer une commande</a></li>
                        <li><a href="{{ route('commandes.all') }}">Gestion des commandes</a></li>
                    </ul>
                </li>
                <li><a class="" href="{{ route('client.all') }}" aria-expanded="false"><i
                            class="fa fa-users"></i><span class="nav-text">Clients</span></a>
                </li>
                <li><a class="" href="{{ route('fournisseur.all') }}" aria-expanded="false"><i
                            class="mdi mdi-nature-people"></i><span class="nav-text">Fournisseurs</span></a>
                </li>
{{--                <li class="nav-label">PRODUITS</li>--}}
                <li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false"><i
                            class="fa fa-product-hunt"></i><span class="nav-text">Produits</span></a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('produit.all') }}">Gestion des produits</a></li>

                        <li><a href="{{ route('categorie.all') }}">Gestion des catégories</a></li>
                        {{--                        <li><a href="{{ route('gestion.calendrier') }}">Calendrier</a></li>--}}
                        {{--                        <li><a href="{{ route('gestion.calendrier') }}">Rapport</a></li>--}}
                    </ul>
                </li>
                <li class="nav-label">GESTION DE L'ENTREPRISE</li>
                <li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false"><i
                            class="icon icon-payment"></i><span class="nav-text">Gestions</span></a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('gestion.index') }}">Charges</a></li>
                        <li><a href="{{ route('gestion.tache') }}">Tâches</a></li>
                    </ul>
                </li>
                <li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false"><i
                            class="fa fa-file-pdf-o"></i><span class="nav-text">Rapports</span></a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('rapport.charge') }}">Rapport des charges</a></li>
                        <li><a href="{{ route('gestion.index') }}">Rapport d'activités clients</a></li>
                    </ul>
                </li>
                @if (Auth::user()->is_admin==1)
                    <li class="nav-label">GESTION DES UTILISATEURS</li>
                    <li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false"><i
                                class="icon icon-users-mm"></i><span class="nav-text">Comptes</span></a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('user.all') }}">Utilisateurs</a></li>

                            <li><a href="{{ route('user.add') }}">Ajouter</a></li>
                        </ul>
                    </li>
                @endif

                {{--                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i--}}
                {{--                            class="icon icon-chart-bar-33"></i><span class="nav-text">Charts</span></a>--}}
                {{--                    <ul aria-expanded="false">--}}
                {{--                        <li><a href="./chart-flot.html">Flot</a></li>--}}
                {{--                        <li><a href="./chart-morris.html">Morris</a></li>--}}
                {{--                        <li><a href="./chart-chartjs.html">Chartjs</a></li>--}}
                {{--                        <li><a href="./chart-chartist.html">Chartist</a></li>--}}
                {{--                        <li><a href="./chart-sparkline.html">Sparkline</a></li>--}}
                {{--                        <li><a href="./chart-peity.html">Peity</a></li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}


            </ul>
        </div>
    </div>
    <!--**********************************
        Sidebar end
    ***********************************-->

    <!--**********************************
        Content body start
    ***********************************-->
    <div class="content-body">
        @yield('content')

    </div>
    <!--**********************************
        Content body end
    ***********************************-->


    <!--**********************************
        Footer start
    ***********************************-->
@include('_partial._modals')
@include('_partial.footer')
<!--**********************************
        Footer end
    ***********************************-->

    <!--**********************************
       Support ticket button start
    ***********************************-->

    <!--**********************************
       Support ticket button end
    ***********************************-->


</div>
<!--**********************************
    Main wrapper end
***********************************-->


<!--**********************************
    Scripts
***********************************-->
<!-- Required vendors -->

<script src="{{asset('template/vendor/global/global.min.js')}}"></script>
<script src="{{asset('template/js/quixnav-init.js')}}"></script>
<script src="{{asset('template/js/custom.min.js')}}"></script>

{{--<script src="{{asset('template/vendor/toastr/js/toastr.min.js')}}"></script>--}}

{{--<!-- All init script -->--}}
{{--<script src="{{asset('template/js/plugins-init/toastr-init.js')}}"></script>--}}
<!-- Toastr -->
<script src="{{asset('template/vendor/plugins/toastr/js/toastr.min.js')}}"></script>
<script src="{{asset('template/vendor/plugins/toastr/js/toastr.init.js')}}"></script>
@include('_partial._toastr-message')
@yield('script')
</body>
</html>
