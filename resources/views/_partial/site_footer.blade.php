<footer class="bg-dark py-4 row col-md-12 mt-5">

        <div class="col-md-3 col-sm-12 pt-2 d-flex justify-content-center">
{{--            <label class="text-white">SEIGNEURIE</label>--}}
            <img src="{{ asset('images/logo.svg') }}" alt="Logo" style="width: 250px;">
        </div>
        <div class="col-md-3 col-sm-12">
            <label class="text-white ps-md-5 ps-sm-0">Menu</label>
            <ul class="" style="list-style: none">
                <li class="fs-6 m-2">
                    <a href="/" class="social-icon nav-link titre-color-1">
                        Accueil
                    </a>
                </li>
                <li class="fs-6 m-2">
                    <a href="{{ route('site.boutique') }}" class="social-icon nav-link titre-color-1">
                        Boutique
                    </a>
                </li>
                <li class="fs-6 m-2">
                    <a href="#" class="social-icon nav-link titre-color-1">
                        A propos
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-md-3 col-sm-12 pt-2 justify-content-center">
            <label class="h6 text-light ps-md-5 ps-sm-0">Contact</label>
            <ul class="" style="list-style: none">
                <li class="">
                        <small><a class="nav-link titre-color-1" href="tel:+23733375923">Tel: +237 33 37 59 23</a></small>
                </li>

            </ul>
            <label class="h6 text-light ps-md-5 ps-sm-0">E-mail</label>
            <ul class="" style="list-style: none">
                <li class="">
                        <small><a class="nav-link titre-color-1" href="mailto:ppgcameroun@ppg.com">ppgcameroun@ppg.com</a></small>
                </li>

            </ul>
        </div>
        <div class="col-md-3 col-sm-12 pt-2">
            <label class="text-light">Adresse</label><br><br>
            <small class="titre-color-1 nav-link">Z.I.Magzi Bassa BP 1028, Douala</small>
{{--            <img src="{{ asset('images/ppg.svg') }}" alt="Logo" style="width: 100px;">--}}
        </div>

</footer>
