@extends('layouts.app')
@section('title','| CHARGES')
@section('css_before')
    <link href="{{asset('template/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
    <style>
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
                    <h4>Charges</h4>
                    {{--                    <p class="mb-0">Your business dashboard template</p>--}}
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Gestion</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Taches</a></li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card px-3">
                    <div class="card-body">
                        <!-- Button trigger modal -->
                        <span class="float-left h4">Liste des charges</span>
                        <button type="button" class="btn btn-primary float-right mb-3" data-toggle="modal"
                                data-target="#chargesModal"><i class="fa fa-plus">&nbsp; Ajouter</i></button>

                        <div class="table-responsive">
                            <table id="example" class="display text-center w-100">
                                <thead class="bg-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Titre</th>
                                    <th>Description</th>
                                    <th>type</th>
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
@include('gestion.charge_modal')
@endsection
@section('script')
    <script>
        function deleteFun(id) {
            var table = $('#example').DataTable();
            swal.fire({
                title: "Supprimer cette charge?",
                icon: 'question',
                text: "Cette charge sera supprimée de façon définitive.",
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
                        url: "{{ route('gestion.charge.delete') }}",
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
        function loadCharges(){
            // $('#example').dataTable().fnClearTable();
            // $('#example').dataTable().fnDestroy();
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
                    url: "{{ route('gestion.load.charge') }}",

                },

                columns: [
                    {data: 'DT_RowIndex',name:'charge_id'},
                    {data: 'titre',name:'titre'},
                    {data: 'description',name:'description'},
                    {data: 'type',name:'type_charge'},
                    {data: 'firstname',name:'users.firstname'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ],
                order: ['0','desc']
            })
        }
        // load table on page load
        $(document).ready(function () {
            loadCharges()

        });

        $("#charge-form").on("submit", function (event) {
            event.preventDefault();

            $('#charge-form .btn-primary').attr("disabled", true).html("En cours...")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var data = $('#charge-form').serialize()

            $.ajax({
                type: "POST",
                url: "{{ route('gestion.charge.add') }}",
                data: data,
                dataType: 'json',
                success: function (res) {
                    console.log(res);
                    if (res) {
                        // swal.fire("Effectué!", "Enregistré avec succès!", "success")
                        // on recharge le tableau de produit
                        toastr.success("Enregistré avec succès!");

                        loadCharges()
                        // on reinitialise le formulaire qui contient les produits
                        $('#charge-form .btn-primary').attr("disabled", false).html("Enregistrer")
                        $('#charge-form')[0].reset()

                        $('#chargesModal').modal('hide');
                    }
                    if (res===[]|| res===undefined || res==null) {
                        sweetAlert("Désolé!", "Erreur lors de l'enregistrement!", "error")
                        $('#charge-form .btn-primary').attr("disabled", false).html("Enregistrer")
                    }

                },
                error: function (resp) {
                    sweetAlert("Désolé!", "Une erreur s'est produite.", "error");
                    console.log(resp)
                    $('#charge-form .btn-primary').attr("disabled", false).html("Enregistrer")
                }
            });
        });

        // id cette methode fait la mise a jour d'une charge
        function editeCharge(id){
            $("#edit-charge-form"+id).on("submit", function (event) {
                event.preventDefault();
                $('#edit-charge-form'+id +' .btn-primary').attr("disabled", true).html("En cours...")
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var data = $('#edit-charge-form'+id).serialize()

                $.ajax({
                    type: "POST",
                    url: "{{ route('gestion.charge.add') }}",
                    data: data,
                    dataType: 'json',
                    success: function (res) {

                        if (res) {
                            // swal.fire("Effectué!", "Enregistré avec succès!", "success")
                            // on recharge le tableau de produit
                            toastr.success("Enregistré avec succès!");


                            // on reinitialise le formulaire qui contient les charges
                            $('#edit-charge-form'+id+' .btn-primary').attr("disabled", false).html("Enregistrer")

                            $('#chargesModal'+id).modal('hide');
                            loadCharges()
                        }
                        if (res===[]|| res===undefined || res==null) {
                            sweetAlert("Désolé!", "Erreur lors de l'enregistrement!", "error")
                            $('#edit-charge-form'+id+' .btn-primary').attr("disabled", false).html("Enregistrer")
                        }


                    },
                    error: function (resp) {
                        sweetAlert("Désolé!", "Une erreur s'est produite.", "error");
                        $('#edit-charge-form'+id+'++ .btn-primary').attr("disabled", false).html("Enregistrer")
                    }
                });
            });
        }
    function showAlerte(number){
        $('.hide').hide(1000);
       if ($('#type_charge_'+number).val()==1){
           $('#alerte_'+number).show(1000)
       } else {
           $('.hide').hide(700);
          /// $('#alerte_'+number).hide()
       }
    }
    </script>
    <!-- Datatable -->
    <script src="{{asset('template/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
{{--    <script src="{{asset('template/js/plugins-init/datatables.init.js')}}"></script>--}}
    <script src="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
@endsection
