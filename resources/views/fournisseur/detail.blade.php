@extends('layouts.app')
@section('title','| FOURNISSEUR-DETAILS')
@section('css_before')
    <link href="{{asset('template/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('template/vendor/select2/css/select2.min.css')}}">
    <style>
        table thead tr th{
            color: white!important;
        }
    </style>
@stop
@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>DETAILS FOURNISSUER</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Fournisseur</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Details</a></li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card px-3">
                    <div class="card-body">
                        <div class="default-tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#infos">Infos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#detail">Commandes</a>
                                </li>

                                {{--                                <li class="nav-item">--}}
                                {{--                                    <a class="nav-link" data-toggle="tab" href="#paiement">Paiements({{ count($paiements) }})</a>--}}
                                {{--                                </li>--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a class="nav-link" data-toggle="tab" href="#message">Factures</a>--}}
{{--                                </li>--}}
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade fade show active" id="infos">

                                    <div class="pt-4">
                                        <div class="col-md-12 mb-5">
                                            <label class="float-left h4">Informations du client</label>
                                            <a href="{{ route('fournisseur.edit',['id'=>$data[0]->fournisseur_id]) }}" class="btn btn-sm btn-whatsapp float-right" title="Editer le client">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </div>
                                        <div class="table-responsive-md table-responsive-sm">
                                            <table class="table text-black fs-4 font-weight-bold table-bordered table-hover">
                                                <tr>
                                                    <td>
                                                        @if ($data[0]->type_client==0)
                                                            Nom
                                                        @else
                                                            Raison sociale
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $data[0]->nom_fr.' '.$data[0]->prenom_fr.' '.$data[0]->raison_s_fr }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Tel</td>
                                                    <td>{{ $data[0]->phone_1_fr }}/{{ $data[0]->phone_2_fr }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Pays</td>
                                                    <td>{{ $data[0]->nom_pays }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Ville</td>
                                                    <td>{{ $data[0]->ville_fr }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Adresse</td>
                                                    <td>{{ $data[0]->adresse_fr }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Boite postale</td>
                                                    <td>{{ $data[0]->postale }}</td>
                                                </tr>
                                                @if ($data[0]->type_fr==1)
                                                    <tr>
                                                        <td>Contribuable</td>
                                                        <td>{{ $data[0]->contribuable }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>RCM</td>
                                                        <td>{{ $data[0]->rcm }}</td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td>Date creation</td>
                                                    <td>{{ $data[0]->date_ajout_fr }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Cree par</td>
                                                    <td>
                                                        {{ $data[0]->firstname }} {{ $data[0]->lastname }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="detail" role="tabpanel">
                                    <div class="pt-4">
                                        @include('fournisseur.commandes')
                                    </div>
                                </div>
{{--                                <div class="tab-pane fade" id="message">--}}
{{--                                    <div class="pt-4">--}}
{{--                                        @include('client.facture')--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        // delete funtion

        function deleteFun(id) {
            var table = $('#commande-table').DataTable();
            swal.fire({
                title: "Supprimer cette commande?",
                icon: 'question',
                text: "Cette commande sera supprimé de façon définitive.",
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
                        url: "{{ route('comment.delete') }}",
                        data: {id: id},
                        dataType: 'json',
                        success: function (res) {
                            if (res) {
                                swal.fire("Effectué!", "Supprimé avec succès!", "success")
                                table.row( $('#deletebtn'+id).parents('tr') )
                                    .remove()
                                    .draw();

                            } else {
                                sweetAlert("Désolé!", "Erreur lors de la suppression!", "error")
                            }

                        },
                        error: function (resp) {
                            sweetAlert("Désolé!", "Une erreur s'est produite.", "error");
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


        // fonction qui charge les produits : les elements du tableau
        function loadCommande() {
            $('#commande-table').dataTable().fnClearTable();
            $('#commande-table').dataTable().fnDestroy();
            // $("#example").DataTable.destroy();
            $("#commande-table").DataTable({
                Processing: true,
                searching: true,
                LengthChange: true, // desactive le module liste deroulante(d'affichage du nombre de resultats par page)
                iDisplayLength: 10, // Configure le nombre de resultats a afficher par page a 10
                bRetrieve: true,
                stateSave: false,
                serverSide: true,
                ajaxSetup:{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                ajax:{
                    url: "{{ route('commandes.load',['id'=>$data[0]->fournisseur_id]) }}",
                },

                columns: [
                    {data: 'DT_RowIndex',name:'commande_id'},
                    {data: 'reference_commande',name:'reference_commande'},
                    {data: 'client',name:'fournisseurs.raison_s_fr'},
                    {data: 'objet_limit',name:'objet'},
                    {data: 'date_commande',name:'date_commande'},
                    {data: 'statut',name:'statut'},
                    {data: 'montantHT',name:'montantHT'},
                    {data: 'montantTTC',name:'montantTTC'},
                    {data: 'firstname',name:'users.firstname'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ],
                order: ['0','desc']
            })

        }

        $(document).ready(function () {
            loadCommande()
        });

        // cette fonction defini un devis comme valide
        function validerFun(id) {
            swal.fire({
                title: "Valider cette commande?",
                icon: 'question',
                text: "Elle ne sera plus modifiable aprés validation.",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Oui, valider!",
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
                        url: "{{ route('commandes.valider') }}",
                        data: {id: id},
                        dataType: 'json',
                        success: function (res) {
                            if (res) {
                                swal.fire("Effectué!", "Validé avec succès!", "success")
                                // toastr.success("Validé avec succès!");
                                loadCommande();

                            } else {
                                sweetAlert("Désolé!", "Erreur lors de la validation!", "error")
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
        // cette fonction defini un devis comme Non valider
        function bloquerFun(id) {
            swal.fire({
                title: "Bloquer cette commande?",
                icon: 'question',
                text: "Elle ne sera pas possible de générer sa facture. Les autres pourrons editer.",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Oui, bloquer!",
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
                        url: "{{ route('commandes.bloquer') }}",
                        data: {id: id},
                        dataType: 'json',
                        success: function (res) {
                            if (res) {
                                swal.fire("Effectué!", "Bloqué avec succès!", "success")
                                // toastr.success("Bloqué avec succès!");
                                loadDevis();

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

@endsection
