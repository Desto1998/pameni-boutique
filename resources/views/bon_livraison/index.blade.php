@extends('layouts.app')
@section('title','| BONS DE LIVRAISON')
@section('css_before')
    <link href="{{asset('template/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('template/vendor/select2/css/select2.min.css')}}">
    <style>
        table thead tr th{
            color: white!important;
        }
        .hide{
            display: none;
        }
    </style>
@stop
@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>GESTION DES BONS DE LIVRAISON</h4> <br>
                    {{--                    <p class="mb-0">Your business dashboard template</p>--}}
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Factures</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Bon livraison</a></li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card px-3">
                    <div class="card-body">
                        <!-- Button trigger modal -->
                        <span class="float-left h4">Liste des bons de livraisons</span>
                        <button type="button" class="btn btn-primary float-right align-self-end mb-3"
                                data-toggle="modal"
                                data-target="#new-bon-liv"><i class="fa fa-plus">&nbsp; Ajouter</i></button>

                        <div class="table-responsive">
                            <table id="example" class="display text-center w-100">
                                <thead class="bg-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Reference</th>
                                    <th>Client</th>
                                    <th>Objet</th>
                                    <th>Date</th>
                                    <th title="Reference de la proformat ou de la facture">Ref.Dev/Fac</th>
                                    <th title="Lieu de livraison">Lieu Liv</th>
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
    @include('bon_livraison.modal')
@stop
@section('script')
    <script>
        // delete funtion

        function deleteFun(id) {
            var table = $('#example').DataTable();
            swal.fire({
                title: "Supprimer ce bon de livraison?",
                icon: 'question',
                text: "Ce bon de livraison sera supprimé de façon définitive.",
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
                        url: "{{ route('bon.delete') }}",
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
        function loadBon() {
            $('#example').dataTable().fnClearTable();
            $('#example').dataTable().fnDestroy();
            // $("#example").DataTable.destroy();
            $("#example")
                .on( 'error.dt', function ( e, settings, techNote, message ) {
                    alert('Erreur delai d\'attente expire, veillez actualiser la page.')
                    console.log( 'An error has been reported by DataTables: ', message );
                } )
                .DataTable({
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
                    url: "{{ route('bon.loadAll',['id'=>-1]) }}",
                },

                columns: [
                    {data: 'DT_RowIndex',name:'DT_RowIndex'},
                    {data: 'reference_bl',name:'reference_bl'},
                    {data: 'client',name:'client'},
                    {data: 'objet',name:'objet'},
                    {data: 'date_bl',name:'date_bl'},
                    {data: 'devis',name:'devis'},
                    {data: 'lieu_liv',name:'lieu_liv'},
                    {data: 'firstname',name:'firstname'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ],
                order: []
            })

        }

        $(document).ready(function () {
            loadBon()
        });

        // store function on form submit
        $('#newBon-form').on('submit', function (e){
            e.preventDefault();
            swal.fire({
                title: "Voulez-vous enregistrer ce bon de livraison?",
                icon: 'question',
                text: "Cette opération est irreversible.",
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
                    $('#newBon-form #register-btn').attr("disabled", true).html("En cours...")
                    var data = $('#newBon-form').serialize()
                    console.log(data);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('bon.store') }}",
                        data: data,
                        dataType: 'json',
                        success: function (res) {
                            console.log(res);
                            if (res==-1){
                                alert("Un bon de livraison existe déja pour cette opération.")
                                $('#newBon-form #register-btn').attr("disabled", false).html("Enregistrer")
                                return false;
                            }
                            if (res){
                                // swal.fire("Effectué!", "Enregistré avec succès!", "success")


                                $('#newBon-form #register-btn').attr("disabled", false).html("Enregistrer")
                                $('#newBon-form')[0].reset();
                                $('#new-bon-liv').modal('hide');
                                // $('#single-select');
                                $('.dropdown-groups').val(null).trigger('change').select2();
                                loadBon();

                                swal.fire({
                                    icon: 'success',
                                    title: 'Effectué avec succès',
                                    text: "L'opération s'est bien terminé!",
                                    footer: '<a href="/dashboard/bonLivraison/print/'+res.bonlivraison_id+'" target="_blank"><i class="fa fa-eye"></i> Cliquer pour voir la facture avoir.</a>'
                                });

                            }else {
                                sweetAlert("Désolé!", "Erreur lors de l'enregistrement!", "error");
                                $('#newBon-form #register-btn').attr("disabled", false).html("Enregistrer");
                            }


                        },
                        error: function (resp) {
                            console.log(resp);
                            sweetAlert("Désolé!", "Une erreur s'est produite.", "error");
                            $('#newBon-form #register-btn').attr("disabled", false).html("Enregistrer");
                        }
                    });
                } else {

                    $('#newBon-form #register-btn').attr("disabled", false).html("Enregistrer");
                    $('#new-bon-liv').modal('hide');
                    e.dismiss;
                }
            }, function (dismiss) {
                $('#newBon-form #register-btn').attr("disabled", false).html("Enregistrer");
                $('#new-bon-liv').modal('hide');
                return false;
            })
        });
        $('#choice').on('click', function (e){
            if ($('#choice').is(":checked")){
                $('#idfacture').attr('required',false);
                $('#iddevis').attr('required',true);
                $('.facture-group').hide(600)
                $('.devis-group').show(600)
            }else{
                $('#idfacture').attr('required',true);
                $('#iddevis').attr('required',false);
                $('.facture-group').show(600)
                $('.devis-group').hide(600)
            }
        })
    </script>

    <!-- Datatable -->
    <script src="{{asset('template/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/datatables.init.js')}}"></script>
    <script src="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
    <!-- Selet search -->
    <script src="{{asset('template/vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/select2-init.js')}}"></script>

@stop
