@extends('layouts.app')
@section('title','| TACHES')
@section('css_before')
    <link href="{{asset('template/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('template/vendor/select2/css/select2.min.css')}}">

@stop
@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Tâches</h4>
                    {{--                    <p class="mb-0">Your business dashboard template</p>--}}
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Gestion</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">taches</a></li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card px-3">
                    <div class="card-body">
                        <!-- Button trigger modal -->
                        <span class="float-left h4">Liste des tâches</span>
                        <button type="button" class="btn btn-primary float-right mb-3" data-toggle="modal"
                                data-target="#tachesModal"><i class="fa fa-plus">&nbsp; Ajouter</i></button>

                        <div class="table-responsive">
                            <table id="example" class="display text-center" style="min-width: 845px">
                                <thead class="bg-primary text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Raison</th>
                                    <th>Charge</th>
                                    <th>Quantité</th>
                                    <th>Prix.U</th>
                                    <th>Total</th>
                                    {{--                                    <th>Statut</th>--}}
                                    {{--                                    <th>Créer le</th>--}}
                                    <th>Crée Par</th>
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
    @include('gestion.tache_modal')
@endsection
@section('script')
    <script>
        // delete funtion
        function deleteFun(id) {
            var table = $('#example').DataTable();
            swal.fire({
                title: "Supprimer cette tâches?",
                icon: 'question',
                text: "Cette tâches sera supprimé de façon définitive.",
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
                        url: "{{ route('gestion.taches.delete') }}",
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
        function loadTaches(){
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
                    url: "{{ route('gestion.load.tache') }}",

                },

                columns: [
                    {data: 'DT_RowIndex',name:'DT_RowIndex'},
                    {data: 'date_debut',name:'date_debut'},
                    {data: 'raison',name:'raison'},
                    {data: 'titre',name:'titre'},
                    {data: 'nombre',name:'nombre'},
                    {data: 'prix',name:'prix'},
                    {data: 'total',name:'total'},
                    {data: 'firstname',name:'firstname'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ],
                order: []
            })
        }
        $(document).ready(function () {
            loadTaches();

        });

        // add new taches
        $("#tache-form").on("submit", function (event) {
            event.preventDefault();

            $('#tache-form .btn-primary').attr("disabled", true).html("En cours...")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var data = $('#tache-form').serialize()

            $.ajax({
                type: "POST",
                url: "{{ route('gestion.taches.add') }}",
                data: data,
                dataType: 'json',
                success: function (res) {
                    console.log(res);

                    if (res) {
                        // swal.fire("Effectué!", "Enregistré avec succès!", "success")
                        // on recharge le tableau de produit
                        toastr.success("Enregistré avec succès!");

                        loadTaches()
                        // on reinitialise le formulaire qui contient les produits
                        $('#tache-form .btn-primary').attr("disabled", false).html("Enregistrer")
                        $('#tache-form')[0].reset()

                        $('#tachesModal').modal('hide');
                    } if (res===[]|| res===undefined || res==null) {
                        sweetAlert("Désolé!", "Erreur lors de l'enregistrement!", "error")
                        $('#tache-form .btn-primary').attr("disabled", false).html("Enregistrer")
                    }

                },
                error: function (resp) {
                    sweetAlert("Désolé!", "Une erreur s'est produite.", "error");
                    $('#tache-form .btn-primary').attr("disabled", false).html("Enregistrer")
                }
            });
        });

        //  cette methode fait la mise a jour d'une tache
        function editTache(id){
            $("#edit-tache-form"+id).on("submit", function (event) {
                event.preventDefault();
                $('#edit-tache-form'+id +' .btn-primary').attr("disabled", true).html("En cours...")
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var data = $('#edit-tache-form'+id).serialize()

                $.ajax({
                    type: "POST",
                    url: "{{ route('gestion.taches.add') }}",
                    data: data,
                    dataType: 'json',
                    success: function (res) {

                        if (res) {
                            // swal.fire("Effectué!", "Enregistré avec succès!", "success")
                            // on recharge le tableau de produit
                            toastr.success("Enregistré avec succès!");


                            // on reinitialise le formulaire qui contient les produits
                            $('#edit-tache-form'+id+' .btn-primary').attr("disabled", false).html("Enregistrer")
                            $('#tachesModal'+id).modal('hide');
                            loadTaches()

                        } if (res===[]|| res===undefined || res==null) {
                            sweetAlert("Désolé!", "Erreur lors de l'enregistrement!", "error")
                            $('#edit-tache-form'+id+' .btn-primary').attr("disabled", false).html("Enregistrer")
                        }


                    },
                    error: function (resp) {
                        sweetAlert("Désolé!", "Une erreur s'est produite.", "error");
                        $('#edit-tache-form'+id+' .btn-primary').attr("disabled", false).html("Enregistrer")
                    }
                });
            });
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
