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
                            <table id="example" class="display text-center" style="min-width: 845px">
                                <thead class="bg-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Nom</th>
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
                                @foreach($data as $key=> $value)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $value->nom_client }} {{ $value->prenom_client }} {{ $value->raison_s_client }}</td>
                                        <td>{{ $value->phone_1_client }} / {{ $value->phone_2_client }}</td>
                                        <td>{{ $value->email_client }}</td>
                                        <td>
                                            @foreach($pays as $p)
                                                @if ($p->pays_id==$value->idpays)
                                                    {{ $p->nom_pays }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $value->ville_client }}</td>
                                        <td>{{ $value->adresse_client }}</td>
                                        <td>{{ $value->postale }}</td>
                                        <td class="d-flex">
                                            <a href="{{ route('client.view',['id' =>$value->client_id]) }}" class="btn btn-success btn-sm" title="Visualiser le client"><i
                                                    class="fa fa-eye"></i></a>
                                            <a href="{{ route('client.edit',['id' =>$value->client_id]) }}" class="btn btn-warning btn-sm ml-1" title="Modifier le client"><i
                                                    class="fa fa-edit"></i></a>
                                            @if (Auth::user()->is_admin==1)
                                                <button class="btn btn-danger btn-sm ml-1 "
                                                        title="Supprimer ce client"
                                                        onclick="deleteFun({{ $value->client_id }})"><i
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
    <!-- Modal -->
    <div class="modal fade" id="clientsModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un client</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('client.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="type_client">Sélectionner le type du client</label>
                            <select class="form-control" onchange="filterFormInput()" required name="type_client" id="type_client">
                                <option value="0">Personne physique</option>
                                <option value="1">Entreprise</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6 clienthide">
                                <label for="nom_client">Nom<span class="text-danger">*</span></label>
                                <input type="text"  name="nom_client" id="nom_client" required placeholder="Nom" class="form-control">
                            </div>

                            <div class="form-group col-md-6 clienthide">
                                <label for="prenom_client">prenom</label>
                                <input type="text" name="prenom_client" id="prenom_client" placeholder="Prénom" class="form-control">
                            </div>
                        </div>

                        <div class="form-group enterprisehide" >
                            <label for="raison_s_client">Raison sociale<span class="text-danger">*</span></label>
                            <input type="text" disabled name="raison_s_client" id="raison_s_client" placeholder="Raison sociale" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="email_client">Email<span class="text-danger">*</span></label>
                            <input type="email" name="email_client" id="email_client" required placeholder="Email" class="form-control">
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="phone_1">Téléphone 1<span class="text-danger">*</span></label>
                                <input type="tel" name="phone_1" id="phone_1" required placeholder="Téléphone" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="phone_2">Téléphone 2</label>
                                <input type="tel" name="phone_2" id="phone_2" placeholder="Téléphone" class="form-control">
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="categorie">Pays</label>
                            <select class="form-control" required name="idpays" id="single-select">
                                <option disabled="disabled" selected>Sélectionner un pays</option>
                                @foreach($pays as $item)
                                    <option value="{{ $item->pays_id }}">{{ $item->nom_pays }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="ville_client">Ville<span class="text-danger">*</span></label>
                                <input type="text" name="ville_client" required id="ville_client" placeholder="Ville" class="form-control">
                            </div>

                            <div class="form-group  col-md-6">
                                <label for="postale">Boite postale</label>
                                <input type="text" name="postale" id="postale" placeholder="" class="form-control">
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="adresse_client">Adresse</label>
                            <input type="text" name="adresse_client" id="adresse_client" placeholder="Adresse" class="form-control">
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 enterprisehide">
                                <label for="contribuabe">Numéro de contibuabe</label>
                                <input type="text" disabled name="contribuabe" id="contribuabe" placeholder="Contribuabe" class="form-control">
                            </div>

                            <div class="form-group enterprisehide col-md-6">
                                <label for="rcm">RC</label>
                                <input type="text" name="rcm" disabled id="rcm" placeholder="RC" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
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
