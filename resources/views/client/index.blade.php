@extends('layouts.app')
@section('css_before')
    <link href="{{asset('template/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('template/vendor/select2/css/select2.min.css')}}">
    <style>
        .enterprisehide{
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Clients</h4>
                    {{--                    <p class="mb-0">Your business dashboard template</p>--}}
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Clients</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Index</a></li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card px-3">
                    <div class="card-body">
                        <!-- Button trigger modal -->
                        <span class="h4 float-left">Liste des clients</span>
                        <button type="button" class="btn btn-primary float-right mb-3" data-toggle="modal"
                                data-target="#clientsModal"><i class="fa fa-plus">&nbsp; Ajouter</i></button>

                        <div class="table-responsive">
                            <table id="example" class="display text-center w-100">
                                <thead class="bg-primary">
                                <tr>
                                    <th>#</th>
                                    <th style="width: 150px;">Nom</th>
                                    <th>Téléphone</th>
                                    <th>Email</th>
                                    <th>Pays</th>
                                    <th>Ville</th>
                                    <th>Adresse</th>
                                    <th>Boite postale</th>
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
   @include('client.modal')

@endsection
@section('script')
    <script>
        // delete funtion
        function deleteFun(id) {
            var table = $('#example').DataTable();
            swal.fire({
                title: "Supprimer ce client?",
                icon: 'question',
                text: "Ce client sera supprimé de façon définitive.",
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
                        url: "{{ route('client.delete') }}",
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
        function filterFormInput(){
            var type = $('#type_client').val();
            if (type==1){
                $('.enterprisehide').show(200)
                $('.clienthide').hide(200)
                $('#nom_client').prop('required',false)
                $('#raison_s_client').prop('required',true)
                $('#raison_s_client').attr('disabled',false)
                $('#nom_client').attr('disabled',true)
                $('#rcm').prop('required',true)
                $('#rcm').attr('disabled',false)
                $('#contribuabe').attr('disabled',false)
            }else {
                $('#raison_s_client').prop('required',false)
                $('#raison_s_client').attr('disabled',true)
                $('.enterprisehide').hide(200)
                $('.clienthide').show(200)
                $('#nom_client').prop('required',true)
                $('#nom_client').attr('disabled',false)
                $('#rcm').attr('disabled',true)
                $('#contribuabe').attr('disabled',true)
            }

        }

        // load all clients on datatable
        function loadClient(){
            $('#example').dataTable().fnClearTable();
            $('#example').dataTable().fnDestroy();
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
                    url: "{{ route('client.load') }}",

                },
                columns: [
                    {data: 'DT_RowIndex',name:'DT_RowIndex'},
                    {data: 'nom',name:'nom'},
                    {data: 'phone',name:'phone'},
                    {data: 'email_client',name:'email_client'},
                    {data: 'nom_pays',name:'nom_pays'},
                    {data: 'ville_client',name:'ville_client'},
                    {data: 'adresse_client',name:'adresse_client'},
                    {data: 'postale',name:'postale'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ],
                order: []
            })
        }
        $(document).ready(function () {
            loadClient()

        });

        // add new client
        $("#client-form").on("submit", function (event) {
            event.preventDefault();

            $('#client-form .btn-primary').attr("disabled", true).html("En cours...")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var data = $('#client-form').serialize()

            $.ajax({
                type: "POST",
                url: "{{ route('client.store') }}",
                data: data,
                dataType: 'json',
                success: function (res) {
                    console.log(res);
                    if (res) {
                        // swal.fire("Effectué!", "Enregistré avec succès!", "success")
                        // on recharge le tableau de produit
                        toastr.success("Enregistré avec succès!");


                        // on reinitialise le formulaire
                        $('#client-form .btn-primary').attr("disabled", false).html("Enregistrer")
                        $('#client-form')[0].reset()
                        $('#clientsModal').modal('hide');
                        loadClient();
                    } else {
                        sweetAlert("Désolé!", "Erreur lors de l'enregistrement!", "error")
                        $('#client-form .btn-primary').attr("disabled", false).html("Enregistrer")
                    }

                },
                error: function (resp) {
                    sweetAlert("Désolé!", "Une erreur s'est produite.", "error");
                    $('#client-form .btn-primary').attr("disabled", false).html("Enregistrer")
                }
            });
        });

    </script>
    <!-- Datatable -->
    <script src="{{asset('template/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/datatables.init.js')}}"></script>
    <script src="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
    <!-- Selet search -->
    <script src="{{asset('template/vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/select2-init.js')}}"></script>

@endsection
