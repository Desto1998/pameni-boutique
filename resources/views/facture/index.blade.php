@extends('layouts.app')
@section('title','| FACTURES')
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
                    <h4>GESTION DES FACTURES</h4>
                    {{--                    <p class="mb-0">Your business dashboard template</p>--}}
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Factures</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Index</a></li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card px-3">
                    <div class="card-body">
                        <!-- Button trigger modal -->
                        <span class="float-left h4">Liste des factures</span>
                        <a href="{{ route('factures.add') }}" class="btn btn-primary float-right mb-3"
                        ><i class="fa fa-plus">&nbsp; Ajouter</i></a>

                        <div class="table-responsive">
                            <table id="example" class="display text-center w-100">
                                <thead class="bg-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Refernce</th>
                                    <th>Client</th>
                                    <th>Objet</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th>Mon. HT</th>
                                    <th>Mon. TTC</th>
                                    <th>Payé</th>
                                    <th>Par</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@include('facture.modal')
@stop
@section('script')
    <script>
        // delete funtion

        function deleteFun(id) {
            var table = $('#example').DataTable();
            swal.fire({
                title: "Supprimer cette facture?",
                icon: 'question',
                text: "Cette facture sera supprimé de façon définitive.",
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
                        url: "{{ route('factures.delete') }}",
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

        // ajouter un paiement
        $("#modal-form").on("submit", function (event) {
            event.preventDefault();
            swal.fire({
                title: "Voulez-vous enregistre ce paiement?",
                icon: 'question',
                text: "Vous pouvez le modifier plus tard dans les details.",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Oui, Continuer!",
                cancelButtonText: "Non, annuler !",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $('#modal-form .btn-primary').attr("disabled", true).html("En cours...")
                    var data = $('#modal-form').serialize()
                    $.ajax({
                        type: "POST",
                        url: "{{ route('factures.paiement.store') }}",
                        data: data,
                        dataType: 'json',
                        success: function (res) {
                            console.log(res);
                            if (res) {
                                toastr.success("Enregistré avec succès.", "Effectué!")

                                $('#modal-form .btn-primary').attr("disabled", false).html("Enregistrer")
                                $('#modal-form')[0].reset()
                                $('#paiement-modal').modal('hide');
                                loadFactures()

                            }
                            if (res === [] || res === undefined || res == null) {
                                toastr.error("Erreur lors de l'enregistrement.", "Désolé!",)
                                $('#modal-form .btn-primary').attr("disabled", false).html("Enregistrer")
                            }

                        },
                        error: function (resp) {
                            sweetAlert("Désolé!", "Une erreur s'est produite. Actualisez la page et reessayez.", "error");
                            $('#modal-form .btn-primary').attr("disabled", false).html("Enregistrer")
                        }
                    });
                } else {

                    $('#modal-form .btn-primary').attr("disabled", false).html("Enregistrer")
                    $('#paiement-modal').modal('hide');
                    e.dismiss;
                }
            }, function (dismiss) {
                $('#modal-form .btn-primary').attr("disabled", false).html("Enregistrer")
                $('#paiement-modal').modal('hide');
                return false;
            })

        });

        // fonction qui charge les produits : les elements du tableau
        function loadFactures() {
            $('#example').dataTable().fnClearTable();
            $('#example').dataTable().fnDestroy();
            // $("#example").DataTable.destroy();
            $("#example").DataTable({
                Processing: true,
                searching: true,
                LengthChange: true, // desactive le module liste deroulante(d'affichage du nombre de resultats par page)
                iDisplayLength: 10, // Configure le nombre de resultats a afficher par page a 10
                bRetrieve: true,
                stateSave: true,
                ajaxSetup:{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                ajax:{
                    url: "{{ route('factures.load',['id'=>-1]) }}",
                },

                columns: [
                    {data: 'DT_RowIndex',name:'DT_RowIndex'},
                    {data: 'reference_fact',name:'reference_fact'},
                    {data: 'client',name:'client'},
                    {data: 'objet',name:'objet'},
                    {data: 'date_fact',name:'date_fact'},
                    {data: 'statut',name:'statut'},
                    {data: 'montantHT',name:'montantHT'},
                    {data: 'montantTTC',name:'montantTTC'},
                    {data: 'paye',name:'paye'},
                    {data: 'firstname',name:'firstname'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ],
                order: []
            })

        }

        $(document).ready(function () {
            loadFactures()
        });

        // cette fonction defini un devis comme valide
        function validerFun(id) {
            swal.fire({
                title: "Valider cette facture?",
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
                        url: "{{ route('factures.valider') }}",
                        data: {id: id},
                        dataType: 'json',
                        success: function (res) {
                            if (res) {
                                swal.fire("Effectué!", "Validé avec succès!", "success")
                                // toastr.success("Validé avec succès!");
                                loadFactures();

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
                title: "Bloquer cette facture?",
                icon: 'question',
                text: "Il ne sera pas possible d'imprimer.",
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
                        url: "{{ route('factures.bloquer') }}",
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


        @include('facture.comon_script')
    </script>
    <!-- Datatable -->
    <script src="{{asset('template/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/datatables.init.js')}}"></script>
    <script src="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
    <!-- Selet search -->
    <script src="{{asset('template/vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/select2-init.js')}}"></script>

@stop
