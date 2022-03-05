@extends('layouts.app')
@section('css_before')
    <link href="{{asset('template/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">

@endsection
@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Liste des utilisateurs</h4>
                    {{--                    <p class="mb-0">Your business dashboard template</p>--}}
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Users</a></li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card px-3">
                    <div class="card-body">
                        <!-- Button trigger modal -->
                        <h4 class="w-50">Liste des charges</h4>
                        <button type="button" class="btn btn-primary float-right mb-3" data-toggle="modal" data-target="#chargesModal"><i class="fa fa-plus">&nbsp; Ajouter</i></button>

                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Titre</th>
                                    <th>Description</th>
                                    <th>Créer par</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($charges as $key=> $value)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $value->titre }}</td>
                                        <td>{{ $value->description }}</td>
                                        <td>{{ $value->firstname }}</td>
                                        <td class="d-flex">
                                            <a href="#" class="btn btn-warning btn-sm" title="Modifier la la charge" data-toggle="modal" data-target="#chargesModal{{ $value->charge_id }}"><i class="fa fa-edit"></i></a>
                                            <button class="btn btn-danger btn-sm ml-1 " title="Supprimer cette charge" onclick="deleteUser({{ $value->charge_id }})"><i class="fa fa-trash"></i></button>
{{--                                            Auth::user()->id--}}
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="chargesModal{{ $value->charge_id }}">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Modifier une charge</h5>

                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('gestion.charge.add') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="charge_id" value="{{ $value->charge_id }}">
                                                        <div class="form-group">
                                                            <label for="titre">Titre de la charge <span class="text-danger">*</span></label>
                                                            <input type="text" name="titre" id="titre{{ $value->charge_id }}" placeholder="Titre" value="{{ $value->titre }}" required class="form-control">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="description{{ $value->charge_id }}">Description de la charge </label>
                                                            <textarea  name="description" id="description{{ $value->charge_id }}" placeholder="Description" class="form-control">{{ $value->description }}</textarea>
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
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Titre</th>
                                    <th>Description</th>
                                    <th>Créer par</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Modal -->
    <div class="modal fade" id="chargesModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Charge</h5>

                </div>
                <div class="modal-body">
                    <form action="{{ route('gestion.charge.add') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="titre">Titre de la charge <span class="text-danger">*</span></label>
                            <input type="text" name="titre" id="titre" placeholder="Titre" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="description">Description de la charge </label>
                            <textarea  name="description" id="description" placeholder="Description" class="form-control"></textarea>
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
        function deleteUser(id)
        {
            if (confirm("Supprimer cette charge?") == true) {
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
                            alert("Supprimé avec succès!");
                            window.location.reload(200);

                        } else {
                            alert("Une erreur s'est produite!");
                        }

                    }
                });
            }
        }

    </script>
    <!-- Datatable -->
    <script src="{{asset('template/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/datatables.init.js')}}"></script>

@endsection
