@extends('layouts.app')
@section('title','| HOME')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Tableau de bord</h4>
                    {{--                    <p class="mb-0">Your business dashboard template</p>--}}
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    {{--                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Components</a></li>--}}
                </ol>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card px-3">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 d-lg-flex d-md-flex row-cols-sm-6 mb-3">
                                <div class="col-md-6 col-sm-12">
                                    <label class="text-center fs-3 font-weight-bold">Statut de la caisse du mois en cours</label>
                                </div>
                                <div class="col-md-6 col-sm-12 justify-content-end">
                                    <form method="post" id="date-form"  class="d-flex">
                                        <label for="date">Mois <span class="text-danger">*</span></label> &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="month" name="date" max="{{ date('Y-m') }}" title="sélectionez un mois" required id="date" class="form-control w-50">&nbsp;&nbsp;
                                        <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Cliquer pour afficher les détails de caisse pour le mois sélectioné">
                                            <i class="fa fa-sign-in"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6">
                                <a href="{{ route('gestion.caisses') }}">
                                    <div class="card">
                                        <div class="stat-widget-one card-body">
                                            <div class="stat-icon d-inline-block">
                                                <i class="fa fa-dollar {{ $solde<=0?'text-danger border-danger':'text-primary border-primary' }}"></i>
                                            </div>
                                            <div class="stat-content d-inline-block">
                                                <div class="stat-text">Solde</div>
                                                <div class="stat-digit">{{ $solde }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <a href="{{ route('gestion.entrees') }}">
                                    <div class="card">
                                        <div class="stat-widget-one card-body">
                                            <div class="stat-icon d-inline-block">
                                                <i class="fa fa-angle-double-down text-success border-success"></i>
                                            </div>
                                            <div class="stat-content d-inline-block">
                                                <div class="stat-text">Entrées</div>
                                                <div class="stat-digit" id="entre">{{ $entre }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <a href="{{ route('gestion.tache') }}">
                                    <div class="card">
                                        <div class="stat-widget-one card-body">
                                            <div class="stat-icon d-inline-block">
                                                <i class="fa fa-angle-double-up text-warning border-warning"></i>
                                            </div>
                                            <div class="stat-content d-inline-block">
                                                <div class="stat-text">Sorties</div>
                                                <div class="stat-digit" id="sortie">{{ $sortie }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <a href="{{ route('gestion.tache') }}">
                                    <div class="card">
                                        <div class="stat-widget-one card-body">
                                            <div class="stat-icon d-inline-block">
                                                <i class="fa fa-dashcube text-success border-success"></i>
                                            </div>
                                            <div class="stat-content d-inline-block">
                                                <div class="stat-text">Dépenses</div>
                                                <div class="stat-digit" id="tache">{{ count($taches) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                <a href="{{ route('devis.all') }}">
                                    <div class="card">
                                        <div class="stat-widget-two card-body">
                                            <div class="stat-content">
                                                <div class="stat-text">Devis non validés</div>
                                                <div class="stat-digit"><i
                                                        class=""></i>{{ count($devisNV) }}</div>
                                            </div>
                                            {{--                                            <div class="progress">--}}
                                            {{--                                                <div class="progress-bar progress-bar-success w-25" role="progressbar"--}}
                                            {{--                                                     aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>--}}
                                            {{--                                            </div>--}}
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <a href="{{ route('factures.all') }}">
                                    <div class="card">
                                        <div class="stat-widget-two card-body">
                                            <div class="stat-content">
                                                <div class="stat-text">Factures non validées</div>
                                                <div class="stat-digit"><i
                                                        class=""></i>{{ count($factureNV) }}</div>
                                            </div>
                                            {{--                                            <div class="progress">--}}
                                            {{--                                                <div class="progress-bar progress-bar-success w-25" role="progressbar"--}}
                                            {{--                                                     aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>--}}
                                            {{--                                            </div>--}}
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-3 col-sm-6">
                                <a href="{{ route('commandes.all') }}">

                                    <div class="card">
                                        <div class="stat-widget-two card-body">
                                            <div class="stat-content">
                                                <div class="stat-text">Commandes non validées</div>
                                                <div class="stat-digit"><i
                                                        class=""></i>{{ count($commandesNV) }}
                                                </div>
                                            </div>
                                            {{--                                            <div class="progress">--}}
                                            {{--                                                <div class="progress-bar progress-bar-success w-25" role="progressbar"--}}
                                            {{--                                                     aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>--}}
                                            {{--                                            </div>--}}
                                        </div>
                                    </div>

                                </a>
                            </div>

                            <div class="col-lg-3 col-sm-6">
                                <a href="{{ route('devis.all') }}">
                                    <div class="card">
                                        <div class="stat-widget-two card-body">
                                            <div class="stat-content">
                                                <div class="stat-text">Devis sans factures</div>
                                                <div class="stat-digit"><i
                                                        class=""></i>{{ count($devisSF) }}</div>
                                            </div>
                                            {{--                                            <div class="progress">--}}
                                            {{--                                                <div class="progress-bar progress-bar-success w-25" role="progressbar"--}}
                                            {{--                                                     aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>--}}
                                            {{--                                            </div>--}}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 col-sm-12">
                                <div class="card">
                                    <div class="stat-widget-two card-body">
                                        <div class="stat-content">
                                            <div class="stat-text h3">Dernières activités</div>
                                            <div class="">
                                                @if (count($lastactivity)>0)
                                                    <label class="my-2 h4">Devis</label>
                                                @endif

                                                @foreach($lastactivity as $key=>$value)
                                                    <a href="{{ route('devis.view',['id'=>$value->devis_id]) }}"
                                                       class="row">
                                                        <ul class="d-flex row col-md-12">
                                                            <li class="col-md-5">{{ $value->objet }}</li>
                                                            <li class="col-md-2">{{ $value->reference_devis }}</li>
                                                            <li class="col-md-2">{{ $value->date_devis }}</li>
                                                            <li class="col-md-3">{{ $value->lastname }}  {{ $value->lastname }}</li>
                                                        </ul>
                                                    </a>
                                                @endforeach
                                                @if (count($lastactivity1)>0)
                                                    <label class="my-2 h4">Facture</label>
                                                @endif

                                                @foreach($lastactivity1 as $key=>$value)
                                                    <a href="{{ route('factures.view',['id'=>$value->facture_id]) }}"
                                                       class="row">
                                                        <ul class="d-flex row col-md-12">
                                                            <li class="col-md-5">{{ $value->objet }}</li>
                                                            <li class="col-md-2">{{ $value->reference_fact }}</li>
                                                            <li class="col-md-2">{{ $value->date_fact }}</li>
                                                            <li class="col-md-3">{{ $value->lastname }}  {{ $value->lastname }}</li>
                                                        </ul>
                                                    </a>
                                                @endforeach
                                                    @if (count($lastactivity2)>0)
                                                        <label class="my-2 h4">Commandes</label>
                                                    @endif

                                                @foreach($lastactivity2 as $key=>$value)
                                                    <a href="{{ route('commandes.view',['id'=>$value->commande_id]) }}"
                                                       class="row">
                                                        <ul class="d-flex row col-md-12">
                                                            <li class="col-md-5">{{ $value->objet }}</li>
                                                            <li class="col-md-2">{{ $value->reference_commande }}</li>
                                                            <li class="col-md-2">{{ $value->date_commande }}</li>
                                                            <li class="col-md-3">{{ $value->lastname }}  {{ $value->firstname }}</li>
                                                        </ul>
                                                    </a>
                                                @endforeach
                                                    @if (count($lastactivity2)===0 && count($lastactivity1)===0 && count($lastactivity)===0)
                                                       <h4 class="text-danger text-center my-4">Aucune activité durant les dernières 24h</h4>
                                                    @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-2 col-sm-6">
                                <a href="{{ route('client.all') }}">
                                    <div class="card">
                                        <div class="stat-widget-one card-body">
{{--                                            <div class="d-inline-block">--}}
{{--                                                <i class="ti-user fs-1 text-success border-success"></i>--}}
{{--                                            </div>--}}
                                            <div class="stat-content d-inline-block">
                                                <div class="stat-text">Clients</div>
                                                <div class="stat-digit">{{ count($clients) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-2 col-sm-6">
                                <a href="{{ route('fournisseur.all') }}">
                                    <div class="card">
                                        <div class="stat-widget-one card-body">
{{--                                            <div class="stat-icon d-inline-block">--}}
{{--                                                <i class="fa fa-users text-success border-success"></i>--}}
{{--                                            </div>--}}
                                            <div class="stat-content d-inline-block">
                                                <div class="stat-text fs-6">Fournisseurs</div>
                                                <div class="stat-digit">{{ count($fournisseurs) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@stop
@section('script')
    <script>
        $('#date-form').on('submit', function (e){
            e.preventDefault()
            $('#date-form .btn-primary').attr("disabled", true).html("En cours...")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let data = $('#date-form').serialize();

            $.ajax({
                type: "POST",
                url: "{{ route('load.dep') }}",
                data: data,
                dataType: 'json',
                success: function (res) {
                    console.log(res);
                    if (res) {
                        $('#date-form .btn-primary').attr("disabled", false).html("<i class='fa fa-sign-in'></i>")

                        $('#entre').html(res.entre);
                        $('#sortie').html(res.sortie);
                        $('#tache').html(res.tache);
                        // $('#tache').html(res.mois);
                        toastr.success("Depenses chargées avec succès!");
                    }else {
                        $('#date-form .btn-primary').attr("disabled", false).html("<i class='fa fa-sign-in'></i>")

                    }
                },
                error: function (resp) {
                    console(resp);
                    sweetAlert("Désolé!", "Une erreur s'est produite. Veillez actualiser la page.", "error");
                    $('#date-form .btn-primary').attr("disabled", false).html("<i class='fa fa-sign-in'></i>")
                }
            });

            return false;
        });
    </script>
@endsection
