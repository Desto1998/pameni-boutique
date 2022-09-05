@extends('_layouts.app')
@section('title','| CATEGORIES')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <span class="float-left h4">Liste des catégories</span>
                        <button type="button" class="btn btn-primary float-right mb-3" data-toggle="modal"
                                data-target="#categoriesModal"><i class="fa fa-plus">&nbsp; Ajouter</i></button>

                        <div class="table-responsive">
                            <table id="example" class="display w-100 text-center">
                                <thead class="bg-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Titre</th>
                                    <th>Description</th>
                                    <th>Crée le</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $key=>$value)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $value->titre }}</td>
                                        <td>{{ $value->description_cat }}</td>
                                        <td>{{ $value->created_at }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="javascript:void(0);" class="btn btn-warning btn-sm" title="Modifier la categorie"
                                                   data-toggle="modal" data-target="#categoriesModal{{ $value->idcat }}"><i
                                                        class="fa fa-edit"></i></a>
                                                @if (Auth::user()->is_admin==1)
                                                    <button class="btn btn-danger btn-sm ml-1 "
                                                            title="Supprimer cette catégorie" id="deletebtn{{ $value->idcat }}"
                                                            onclick="deleteFun({{ $value->idcat }})"><i
                                                            class="fa fa-trash"></i></button>
                                                    {{--                                            Auth::user()->id--}}
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade" data-backdrop="static" id="categoriesModal{{ $value->idcat }}">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Modifier une catégorie</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="text-left" action="{{ route('categories.store') }}" method="post" id="edit-categorie-form{{ $value->categorie_id }}">
                                                        @csrf
                                                        <input type="hidden" name="categorie_id"
                                                               value="{{ $value->idcat }}">
                                                        <div class="form-group">
                                                            <label for="titre">Titre de la catégorie <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" name="titre_cat"
                                                                   id="titre{{ $value->idcat }}" placeholder="Titre"
                                                                   value="{{ $value->titre }}" required
                                                                   class="form-control">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="description_cat{{ $value->idcat }}">Description
                                                                de la catégorie </label>
                                                            <textarea name="description_cat"
                                                                      id="description_cat{{ $value->idcat }}"
                                                                      placeholder="Description"
                                                                      class="form-control">{{ $value->description_cat }}</textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Annuler
                                                            </button>
                                                            <button type="submit"  id="edit-btn" class="btn btn-primary">Enregistrer
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

    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="categoriesModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une catégorie</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="categorie-form">
                        @csrf
                        <div class="form-group">
                            <label for="titre_cat">Titre de la catégorie <span class="text-danger">*</span></label>
                            <input type="text" name="titre_cat" id="titre_cat" placeholder="Titre" class="form-control">
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
@stop
@section('script')
<script>
    function deleteFun(id) {
        var table = $('#example').DataTable();

            if (confirm("Supprimer cette categorie?")===true) {
                // if (confirm("Supprmer cette tâches?") == true) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('categories.delete') }}",
                    data: {id: id},
                    dataType: 'json',
                    success: function (res) {
                        if (res) {
                            // alert("Supprimé avec succès!")
                            table.row( $('#deletebtn'+id).parents('tr') )
                                .remove()
                            toastr.success("Supprimé avec succès!");
                        } else {
                            alert( "Erreur lors de la suppression!")
                        }

                    },
                    error: function (resp) {
                        alert("Une erreur s'est produite.");
                    }
                });
            }

        // }
    }
</script>
@endsection
