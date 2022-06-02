@extends('layouts.app')
@section('title','| FACTURES | HISTORIQUES')
@section('css_before')
    <link href="{{asset('template/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('template/vendor/select2/css/select2.min.css')}}">
    <style>
        table thead tr th {
            /*color: white !important;*/
        }
    </style>
@stop
@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>GESTION DES HISTORIQUES FACTURES</h4>
                    {{--                    <p class="mb-0">Your business dashboard template</p>--}}
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Factures</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Historiques</a></li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card px-3">
                    <div class="card-body">
                        {{--                        <span class="float-left h4">Liste des modifications des factures</span>--}}
                        @if (count($factures)<1)
                            <div class="alert alert-outline-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                                </button>
                                <strong>Aucun historique à afficher pour l'instant</strong>
                            </div>
                        @endif

                        <div id="accordion-four" class="accordion accordion-no-gutter mt-5 accordion-bordered">
                            @foreach($factures as $fact=>$value)
                                <div class="accordion__item">
                                    <div class="accordion__header" data-toggle="collapse"
                                         data-target="#bordered_no-gutter_collapse{{ $value->facture_id }}">
                                        <span
                                            class="accordion__header--text">{{ $value->reference_fact }} => {{ $value->objet }}</span>
                                        <span class="accordion__header--indicator style_two"></span>
                                    </div>
                                    <div id="bordered_no-gutter_collapse{{ $value->facture_id }}"
                                         class="collapse accordion__body show" data-parent="#accordion-four">
                                        <div class="accordion__body--text">
                                            <label class="nav-label text-primary">Statut actuel, derniere modification
                                                le: {{ $value->updated_at }}</label>
                                            <div class="table-responsive">
                                                <table
                                                    class="table w-100 mt-2 table-bordered table-hover text-black">
                                                    <thead >
                                                    <tr class="text-black">
                                                        <th>Objet</th>
                                                        <th>Client</th>
                                                        <th>Date</th>
                                                        <th>TVA?</th>
                                                        <th>Par</th>
                                                        <th>Créé le</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>{{ $value->objet}}</td>
                                                        <td>
                                                            @foreach($client as $c)
                                                                @if ($c->client_id===$value->idclient)
                                                                    {{ $c->nom_client }} {{ $c->prenom_client }} {{ $c->raison_s_client }}
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        <td>{{ $value->date_fact }}</td>
                                                        <td>
                                                            {{ $value->tva_statut==1?"Oui":"Non" }}
                                                        </td>
                                                        <td>
                                                            @foreach($users as $u)
                                                                @if ($u->id===$value->iduser)
                                                                    {{ $u->firstname }} {{ $u->lastname }}
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            {{ $value->created_at }}
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <label class="text-primary">Produits</label>
                                                <table
                                                    class="table w-100 mt-5  table-bordered table-hover text-black">
                                                    <thead>
                                                    <tr>
                                                        <th>Désignation</th>
                                                        <th>QTE</th>
                                                        <th>P.U</th>
                                                        <th>Remise</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach($factproduct as $pf)
                                                        @if ($pf->idfacture == $value->facture_id)
                                                            <tr>
                                                                <td>{{ $pf->titre_produit }} &nbsp;&nbsp; <small>{{ $pf->description_produit }}</small></td>
                                                                <td>{{ $pf->quantite }}</td>
                                                                <td>{{ $pf->prix }}</td>
                                                                <td>{{ $pf->remise }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                                <label class="text-success fw-700">Historique des modifications</label>
                                                <div>
                                                    @foreach($logs as $k=>$item)
                                                        <label class="text-danger">{{ $k+1 }}</label>
                                                        @if(Auth::user()->is_admin==1)
                                                        <div class="w-100 d-flex justify-content-end">
                                                            <a href="javascript:void(0);" class="btn btn-sm btn-secondary" title="Achiver" onclick="archivateFun({{ $item->log_f_id }})">
                                                                <i class="fa fa-archive"></i>
                                                            </a>
                                                            <a href="javascript:void(0);" class="btn btn-sm btn-danger ml-2" title="Supprimer" onclick="deleteFun({{ $item->log_f_id }})">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>
                                                        @endif

                                                        <table
                                                        class="table w-100 mt-2 table-bordered table-hover text-black">
                                                        <thead>
                                                        <tr>
                                                            <th>Objet</th>
                                                            <th>Client</th>
                                                            <th>Date</th>
                                                            <th>TVA?</th>
                                                            <th>Par</th>
                                                            <th>Créé le</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td>{{ $item->log_objet}}</td>
                                                            <td>
                                                                @foreach($client as $c)
                                                                    @if ($c->client_id===$item->log_idclient)
                                                                        {{ $c->nom_client }} {{ $c->prenom_client }} {{ $c->raison_s_client }}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>{{ $value->log_date_fact }}</td>
                                                            <td>
                                                                {{ $value->log_tva_statut==1?"Oui":"Non" }}
                                                            </td>
                                                            <td>
                                                                @foreach($users as $u)
                                                                    @if ($u->id===$item->log_iduser)
                                                                        {{ $u->firstname }} {{ $u->lastname }}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                {{ $item->created_at }}
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                        <label class="text-primary">Produits</label>
                                                        <table
                                                        class="table w-100 mt-5  table-bordered table-hover text-black">
                                                        <thead>
                                                        <tr>
                                                            <th>Désignation</th>
                                                            <th>QTE</th>
                                                            <th>P.U</th>
                                                            <th>Remise</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                        @foreach($logproducts as $lpf)
                                                            @if ($lpf->log_idf== $item->log_f_id)
                                                                <tr>
                                                                    <td>{{ $lpf->titre_produit }} &nbsp;&nbsp; <small>{{ $lpf->description_produit }}</small></td>
                                                                    <td>{{ $lpf->log_quantite }}</td>
                                                                    <td>{{ $lpf->log_prix }}</td>
                                                                    <td>{{ $lpf->log_remise }}</td>
                                                                </tr>
                                                            @endif
                                                        @endforeach

                                                        </tbody>
                                                    </table>
                                                    @endforeach
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script>
        // cette fonction ,et les produit de la commande en stock
        function deleteFun(id) {
            swal.fire({
                title: "Attention!",
                icon: 'warning',
                text: "Voulez-vous vraiment supprimer?",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Oui, supprimer!",
                cancelButtonText: "Non, annuler !",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    // if (confirm("Supprimer cette tâches?") == true) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "{{ route('history.delete') }}",
                        data: {id: id},
                        dataType: 'json',
                        success: function (res) {
                            if (res) {
                                swal.fire("Effectué!", "Effectué avec succès!", "success")
                                // toastr.success("Bloqué avec succès!");
                                window.location.reload();
                            } else {
                                sweetAlert("Désolé!", "Erreur lors de l'opération!", "error")
                            }

                        },
                        error: function (resp) {
                            sweetAlert("Désolé!", "Une erreur s'est produite. Actulisez la page et reessayez", "error");
                        }
                    });
                } else {
                    e.dismiss;
                }
            }, function (dismiss) {
                return false;
            })
            // }
        }

        // cette fonction ,et les produit de la commande en stock
        function archivateFun(id) {
            swal.fire({
                title: "Attention!",
                icon: 'warning',
                text: "Cette modification n'apparaitra plus ici dans l'historique. Continuer?",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Oui, continuer!",
                cancelButtonText: "Non, annuler !",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    // if (confirm("Supprimer cette tâches?") == true) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "{{ route('history.archive') }}",
                        data: {id: id},
                        dataType: 'json',
                        success: function (res) {
                            if (res) {
                                swal.fire("Effectué!", "Effectué avec succès!", "success")
                                // toastr.success("Bloqué avec succès!");
                                window.location.reload();

                            } else {
                                sweetAlert("Désolé!", "Erreur lors de l'opération!", "error")
                            }

                        },
                        error: function (resp) {
                            sweetAlert("Désolé!", "Une erreur s'est produite. Actulisez la page et reessayez", "error");
                        }
                    });
                } else {
                    e.dismiss;
                }
            }, function (dismiss) {
                return false;
            })
            // }
        }
    </script>
    <!-- Datatable -->
    <script src="{{asset('template/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/datatables.init.js')}}"></script>
    <script src="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
    <!-- Selet search -->
    <script src="{{asset('template/vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/select2-init.js')}}"></script>

@stop
