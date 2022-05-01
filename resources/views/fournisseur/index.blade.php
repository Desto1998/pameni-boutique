@extends('layouts.app')
@section('title','| FOURNISSUERS')
@section('css_before')
    <link href="{{asset('template/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('template/vendor/select2/css/select2.min.css')}}">
    <style>
        .enterprisehide{
            display: none;
        }
    </style>
@stop
@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Fournisseurs</h4>
                    {{--                    <p class="mb-0">Your business dashboard template</p>--}}
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Fournisseurs</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Index</a></li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card px-3">
                    <div class="card-body">
                        <!-- Button trigger modal -->
                        <span class="h4 float-left">Liste des Fournisseurs</span>
                        <button type="button" class="btn btn-primary float-right mb-3" data-toggle="modal"
                                data-target="#fournisseursModal"><i class="fa fa-plus">&nbsp; Ajouter</i></button>

                        <div class="table-responsive">
                            <table id="example" class="display text-center w-100">
                                <thead class="bg-primary">

                                <tr>
                                    <th>#</th>
                                    <th>Nom</th>
                                    <th>Téléphone</th>
                                    <th>Email</th>
{{--                                    <th>Pays</th>--}}
                                    <th>Ville</th>
                                    <th>Adresse</th>
{{--                                    <th>Boite postale</th>--}}
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
{{--                                @foreach($data as $key=> $value)--}}
{{--                                    <tr>--}}
{{--                                        <td>{{ $key+1 }}</td>--}}
{{--                                        <td>{{ $value->nom_fr }} {{ $value->prenom_fr }} {{ $value->raison_s_fr }}</td>--}}
{{--                                        <td>{{ $value->phone_1_fr }} / {{ $value->phone_2_fr }}</td>--}}
{{--                                        <td>{{ $value->email_fr }}</td>--}}
{{--                                        <td>--}}
{{--                                            @foreach($pays as $p)--}}
{{--                                                @if ($p->pays_id==$value->idpays)--}}
{{--                                                    {{ $p->nom_pays }}--}}
{{--                                                @endif--}}
{{--                                            @endforeach--}}
{{--                                        </td>--}}
{{--                                        <td>{{ $value->ville_fr }}</td>--}}
{{--                                        <td>{{ $value->adresse_fr }}</td>--}}
{{--                                        <td>{{ $value->postale }}</td>--}}
{{--                                        <td class="d-flex">--}}
{{--                                            <a href="{{ route('fournisseur.view',['id' =>$value->fournisseur_id]) }}" class="btn btn-success btn-sm" title="Visualiser le fournissuer"><i--}}
{{--                                                    class="fa fa-eye"></i></a>--}}
{{--                                            <a href="{{ route('fournisseur.edit',['id' =>$value->fournisseur_id]) }}" class="btn btn-warning btn-sm ml-1" title="Modifier le fournissuer"><i--}}
{{--                                                    class="fa fa-edit"></i></a>--}}
{{--                                            @if (Auth::user()->is_admin==1)--}}
{{--                                                <button class="btn btn-danger btn-sm ml-1 "--}}
{{--                                                        title="Supprimer ce fournissuer"--}}
{{--                                                        onclick="deleteFun({{ $value->fournisseur_id }})"><i--}}
{{--                                                        class="fa fa-trash"></i></button>--}}
{{--                                                --}}{{--                                            Auth::user()->id--}}
{{--                                            @endif--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}

{{--                                @endforeach--}}
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    @include('fournisseur.modal')

@stop
@section('script')
    <script>
        // delete funtion
        function deleteFun(id) {
            var table = $('#example').DataTable();
            swal.fire({
                title: "Supprimer ce fournisseur?",
                icon: 'question',
                text: "Ce fournisseur sera supprimé de façon définitive.",
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
                        url: "{{ route('fournisseur.delete') }}",
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
            var type = $('#type_fr').val();
            if (type==1){
                $('.enterprisehide').show(200)
                $('.clienthide').hide(200)
                $('#nom_fr').prop('required',false)
                $('#raison_s_fr').prop('required',true)
                $('#raison_s_fr').attr('disabled',false)
                $('#nom_fr').attr('disabled',true)
                // $('#rcm').prop('required',true)
                $('#rcm').attr('disabled',false)
                $('#contribuabe').attr('disabled',false)
            }else {
                $('#raison_s_fr').prop('required',false)
                $('#raison_s_fr').attr('disabled',true)
                $('.enterprisehide').hide(200)
                $('.clienthide').show(200)
                $('#nom_fr').prop('required',true)
                $('#nom_fr').attr('disabled',false)
                $('#rcm').attr('disabled',true)
                $('#contribuabe').attr('disabled',true)
            }

        }

        // load all clients on datatable
        function loadFournisseur(){
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
                    url: "{{ route('fournisseur.load') }}",

                },
                columns: [
                    {data: 'DT_RowIndex',name:'DT_RowIndex'},
                    {data: 'nom',name:'nom'},
                    {data: 'phone',name:'phone'},
                    {data: 'email_fr',name:'email_fr'},
                    // {data: 'nom_pays',name:'nom_pays'},
                    {data: 'ville_fr',name:'ville_fr'},
                    {data: 'adresse_fr',name:'adresse_fr'},
                    // {data: 'postale',name:'postale'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ],
                order: []
            })
        }
        $(document).ready(function () {
            loadFournisseur()

        });

        // add new client
        $("#fournisseur-form").on("submit", function (event) {
            event.preventDefault();

            $('#fournisseur-form .btn-primary').attr("disabled", true).html("En cours...")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var data = $('#fournisseur-form').serialize()

            $.ajax({
                type: "POST",
                url: "{{ route('fournisseur.store') }}",
                data: data,
                dataType: 'json',
                success: function (res) {
                    console.log(res);
                    if (res) {
                        // swal.fire("Effectué!", "Enregistré avec succès!", "success")
                        // on recharge le tableau de produit
                        toastr.success("Enregistré avec succès!");


                        // on reinitialise le formulaire
                        $('#fournisseur-form .btn-primary').attr("disabled", false).html("Enregistrer")
                        $('#fournisseur-form')[0].reset()
                        $('#fournisseursModal').modal('hide');
                        loadFournisseur();
                    } else {
                        sweetAlert("Désolé!", "Erreur lors de l'enregistrement!", "error")
                        $('#fournisseur-form .btn-primary').attr("disabled", false).html("Enregistrer")
                    }

                },
                error: function (resp) {
                    sweetAlert("Désolé!", "Une erreur s'est produite.", "error");
                    $('#fournisseur-form .btn-primary').attr("disabled", false).html("Enregistrer")
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

@stop
