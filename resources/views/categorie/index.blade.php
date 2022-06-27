@extends('layouts.app')
@section('title','| CATEGORIES')
@section('css_before')
    <link href="{{asset('template/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">

{{--    <link href="{{ asset('datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">--}}
{{--    <link href="{{ asset('datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">--}}
@stop
@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Catégories</h4>
                    {{--                    <p class="mb-0">Your business dashboard template</p>--}}
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Produits</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Categorie</a></li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card px-3">
                    <div class="card-body">
                        <!-- Button trigger modal -->
                        <span class="float-left h4">Liste des catégorie</span>
                        <button type="button" class="btn btn-primary float-right mb-3" data-toggle="modal"
                                data-target="#categoriesModal"><i class="fa fa-plus">&nbsp; Ajouter</i></button>

                        <div class="table-responsive">
                            <table id="example" class="display w-100 text-center">
                                <thead class="bg-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Titre</th>
                                    <th>Description</th>
                                    <th>Crée par</th>
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

@include('categorie.modal')
@stop
@section('script')
    <script>
        //delete categorie
        function deleteFun(id) {
            var table = $('#example').DataTable();
            swal.fire({
                title: "Supprimer cette catégorie?",
                icon: 'question',
                text: "Cette catégorie sera supprimée de façon définitive avec ses produits",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Oui, supprimer!",
                cancelButtonText: "Non, annuler !",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    var table = $('#example').DataTable();
                    // if (confirm("Supprimer cette tâches?") == true) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "{{ route('categorie.delete') }}",
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
        // load all categories on datatable
        function loadCategorie(){
            $('#example').dataTable().fnClearTable();
            $('#example').dataTable().fnDestroy();
            $("#example").DataTable({
                Processing: true,
                searching: true,
                serverSide: true,
                LengthChange: true, // desactive le module liste deroulante(d'affichage du nombre de resultats par page)
                iDisplayLength: 10, // Configure le nombre de resultats a afficher par page a 10
                bRetrieve: true,
                stateSave: false,
                ajaxSetup:{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                ajax:{
                    url: "{{ route('categorie.load') }}",

                },

                columns: [
                    {data: 'DT_RowIndex',name:'categorie_id', orderable: true, searchable: true},
                    {data: 'code_cat',name:'code_cat'},
                    {data: 'titre_cat',name:'titre_cat'},
                    {data: 'description_cat',name:'description_cat'},
                    {data: 'firstname',name:'users.firstname', orderable: true, searchable: true},
                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ],
                order: ['0','desc']
            })
        }
        $(document).ready(function () {
            loadCategorie()

        });

        // add new categorie
        $("#categorie-form").on("submit", function (event) {
            event.preventDefault();

            $('#categorie-form .btn-primary').attr("disabled", true).html("En cours...")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var data = $('#categorie-form').serialize()

            $.ajax({
                type: "POST",
                url: "{{ route('categorie.store') }}",
                data: data,
                dataType: 'json',
                success: function (res) {
                    console.log(res);
                    if (res==0){
                        sweetAlert("Désolé!", "Une catégorie avec ce code existe déja! Veillez changer le code.", "error")
                        $('#categorie-form .btn-primary').attr("disabled", false).html("Enregistrer")
                    }
                    else {
                        // swal.fire("Effectué!", "Enregistré avec succès!", "success")
                        // on recharge le tableau de produit
                        toastr.success("Enregistré avec succès!");

                        loadCategorie()
                        // on reinitialise le formulaire qui contient les produits
                        $('#categorie-form .btn-primary').attr("disabled", false).html("Enregistrer")
                        $('#categorie-form')[0].reset()

                        $('#categoriesModal').modal('hide');
                    } if (res===[]|| res===undefined || res==null) {
                        sweetAlert("Désolé!", "Erreur lors de l'enregistrement!", "error")
                        $('#categorie-form .btn-primary').attr("disabled", false).html("Enregistrer")
                    }

                },
                error: function (resp) {
                    sweetAlert("Désolé!", "Une erreur s'est produite.", "error");
                    $('#categorie-form .btn-primary').attr("disabled", false).html("Enregistrer")
                }
            });
        });

        // getcategorie id cette methode fait la mise a jour d'une categorie
        function getCategorieId(id){
            $("#edit-categorie-form"+id).on("submit", function (event) {
                event.preventDefault();
                $('#edit-categorie-form'+id +' .btn-primary').attr("disabled", true).html("En cours...")
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var data = $('#edit-categorie-form'+id).serialize()

                $.ajax({
                    type: "POST",
                    url: "{{ route('categorie.store') }}",
                    data: data,
                    dataType: 'json',
                    success: function (res) {
                        if (res==0){
                            sweetAlert("Désolé!", "Une catégorie avec ce code existe déja! Veillez changer le code.", "error")
                            $('#edit-categorie-form'+id+' .btn-primary').attr("disabled", false).html("Enregistrer")
                        }
                        else {
                            // swal.fire("Effectué!", "Enregistré avec succès!", "success")
                            // on recharge le tableau de produit
                            toastr.success("Enregistré avec succès!");


                            // on reinitialise le formulaire qui contient les produits
                            $('#edit-categorie-form'+id+' .btn-primary').attr("disabled", false).html("Enregistrer")

                            $('#categoriesModal'+id).modal('hide');
                            loadCategorie()
                        } if (res===[]|| res===undefined || res==null) {
                            sweetAlert("Désolé!", "Erreur lors de l'enregistrement!", "error")
                            $('#edit-categorie-form'+id+' .btn-primary').attr("disabled", false).html("Enregistrer")
                        }


                    },
                    error: function (resp) {
                        sweetAlert("Désolé!", "Une erreur s'est produite.", "error");
                        $('#edit-categorie-form'+id+' .btn-primary').attr("disabled", false).html("Enregistrer")
                    }
                });
            });
        }


    </script>
    <!-- Datatable -->
    <script src="{{asset('template/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/datatables.init.js')}}"></script>
    <script src="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>

{{--    <script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>--}}
{{--    <script src="{{ asset('datatable/js/bootstrap.min.js') }}"></script>--}}
{{--    <script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>--}}
@stop

