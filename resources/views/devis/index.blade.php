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
                    <h4>LISTE DES DEVIS</h4>
                    {{--                    <p class="mb-0">Your business dashboard template</p>--}}
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Devis</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Index</a></li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card px-3">
                    <div class="card-body">
                        <!-- Button trigger modal -->
                        <span class="float-left h4">Liste des Devis</span>
                        <a type="button" class="btn btn-primary float-right mb-3" data-toggle="modal"
                                data-target="#clientsModal"><i class="fa fa-plus">&nbsp; Ajouter</i></a>

                        <div class="table-responsive">
                            <table id="example" class="display text-center" style="min-width: 845px">
                                <thead class="bg-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Refernce</th>
                                    <th>Client</th>
                                    <th>Titre</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th>Montant TTC</th>
                                    <th>Par</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $key=> $value)
                                    @php
                                        $montant = 0;
                                    @endphp
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $value->reference }}</td>
                                        <td>{{ $value->nom_client }} {{ $value->prenom_client }} {{ $value->raison_s_client }}</td>
                                        <td>{{ $value->objet }}</td>
                                        <td>{{ $value->date_devis }}</td>
                                        <td>
                                            @if ($value->statut==0)
                                                <span class="text-danger">Non validé</span>
                                            @else
                                                <span class="text-success">Validé</span>
                                            @endif

                                        </td>
                                        <td>
                                            @foreach($pocedes as $item)
                                                @if ($item->iddevis==$value->devis_id)
                                                    @php
                                                        $montant += $item->quantite * $item->prix;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            {{ $montant }}
                                        </td>
                                        <td>
                                            @foreach($users as $u)
                                                @if ($u->id==$value->iduser)
                                                    {{ $u->firstname }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="d-flex">
                                            <a href="{{ route('devis.view',['id' =>$value->devis_id]) }}" class="btn btn-success btn-sm" title="Visualiser le client"><i
                                                    class="fa fa-eye"></i></a>
                                            <a href="{{ route('devis.edit',['id' =>$value->devis_id]) }}" class="btn btn-warning btn-sm ml-1" title="Modifier le client"><i
                                                    class="fa fa-edit"></i></a>
                                            @if (Auth::user()->is_admin==1)
                                                <button class="btn btn-danger btn-sm ml-1 "
                                                        title="Supprimer ce devis"
                                                        onclick="deleteFun({{ $value->devis_id }})"><i
                                                        class="fa fa-trash"></i></button>
                                                {{--                                            Auth::user()->id--}}
                                            @endif
                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>

                            </table>
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
            swal.fire({
                title: "Supprimer ce client?",
                icon: 'question',
                text: "Ce devis sera supprimé de façon définitive.",
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
                                window.location.reload(200);

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
    </script>
    <!-- Datatable -->
    <script src="{{asset('template/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/datatables.init.js')}}"></script>
    <script src="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
    <!-- Selet search -->
    <script src="{{asset('template/vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/select2-init.js')}}"></script>

@endsection
