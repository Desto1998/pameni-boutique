@extends('layouts.app')
@section('css_before')
    <link href="{{asset('template/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">

@endsection
@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Catégorie</h4>
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
                        <h4 class="w-50">Liste des catégorie</h4>
                        <button type="button" class="btn btn-primary float-right mb-3" data-toggle="modal"
                                data-target="#categoriesModal"><i class="fa fa-plus">&nbsp; Ajouter</i></button>

                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
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
                                @foreach($data as $key=> $value)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $value->code_cat }}</td>
                                        <td>{{ $value->titre_cat }}</td>
                                        <td>{{ $value->description_cat }}</td>
                                        <td>{{ $value->firstname }}</td>
                                        <td class="d-flex">
                                            <a href="javascript:void(0);" class="btn btn-warning btn-sm" title="Modifier la charge"
                                               data-toggle="modal" data-target="#categoriesModal{{ $value->categorie_id }}"><i
                                                    class="fa fa-edit"></i></a>
                                            @if (Auth::user()->is_admin==1)
                                                <button class="btn btn-danger btn-sm ml-1 "
                                                        title="Supprimer cette catégorie"
                                                        onclick="deleteFun({{ $value->categorie_id }})"><i
                                                        class="fa fa-trash"></i></button>
                                                {{--                                            Auth::user()->id--}}
                                            @endif
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="categoriesModal{{ $value->categorie_id }}">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Modifier une catégorie</h5>

                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('categorie.store') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="categorie_id"
                                                               value="{{ $value->categorie_id }}">
                                                        <div class="form-group">
                                                            <label for="titre">Titre de la catégorie <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" name="titre_cat"
                                                                   id="titre{{ $value->categorie_id }}" placeholder="Titre"
                                                                   value="{{ $value->titre_cat }}" required
                                                                   class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="code_cat{{ $value->categorie_id }}">Code de la catégorie <span
                                                                    class="text-danger">* (Min:4)</span></label>
                                                            <input type="text" name="code_cat" min="4" max="6"
                                                                   id="code_cat{{ $value->categorie_id }}" placeholder="Code"
                                                                   value="{{ $value->code_cat }}" required
                                                                   class="form-control text-uppercase">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="description_cat{{ $value->categorie_id }}">Description
                                                                de la catégorie </label>
                                                            <textarea name="description_cat"
                                                                      id="description_cat{{ $value->categorie_id }}"
                                                                      placeholder="Description"
                                                                      class="form-control">{{ $value->description_cat }}</textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Annuler
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">Enregistrer
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
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
    <div class="modal fade" id="categoriesModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une catégorie</h5>

                </div>
                <div class="modal-body">
                    <form action="{{ route('categorie.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="titre_cat">Titre de la catégorie <span class="text-danger">*</span></label>
                            <input type="text" name="titre_cat" id="titre_cat" placeholder="Titre" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="code_cat">Code de la catégorie <span class="text-danger">* (Min:4)</span></label>
                            <input type="text" name="code_cat" id="code_cat" placeholder="Code" class="form-control text-uppercase">
                        </div>

                        <div class="form-group">
                            <label for="description_cat">Description de la catégorie </label>
                            <textarea name="description_cat" id="description_cat" placeholder="Description"
                                      class="form-control"></textarea>
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
        function deleteFun(id) {
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

    </script>
    <!-- Datatable -->
    <script src="{{asset('template/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/datatables.init.js')}}"></script>
    <script src="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
@endsection
