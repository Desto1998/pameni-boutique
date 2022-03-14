<!-- Modal add categorie -->
<div class="modal fade" id="categoriesModal">
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
                        <label for="code_cat">Code de la catégorie <span class="text-danger">* (Min:4)</span></label>
                        <input type="text" name="code_cat" id="code_cat" minlength="4" maxlength="6" placeholder="Code" class="form-control text-uppercase">
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


{{--@foreach($data as $key=> $value)--}}
{{--    <tr>--}}
{{--        <td>{{ $key+1 }}</td>--}}
{{--        <td>{{ $value->code_cat }}</td>--}}
{{--        <td>{{ $value->titre_cat }}</td>--}}
{{--        <td>{{ $value->description_cat }}</td>--}}
{{--        <td>{{ $value->firstname }}</td>--}}
{{--        <td class="d-flex">--}}
{{--            <a href="javascript:void(0);" class="btn btn-warning btn-sm" title="Modifier la charge"--}}
{{--               data-toggle="modal" data-target="#categoriesModal{{ $value->categorie_id }}"><i--}}
{{--                    class="fa fa-edit"></i></a>--}}
{{--            @if (Auth::user()->is_admin==1)--}}
{{--                <button class="btn btn-danger btn-sm ml-1 "--}}
{{--                        title="Supprimer cette catégorie"--}}
{{--                        onclick="deleteFun({{ $value->categorie_id }})"><i--}}
{{--                        class="fa fa-trash"></i></button>--}}
{{--                --}}{{--                                            Auth::user()->id--}}
{{--            @endif--}}
{{--        </td>--}}
{{--    </tr>--}}
{{--    <div class="modal fade" id="categoriesModal{{ $value->categorie_id }}">--}}
{{--        <div class="modal-dialog" role="document">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h5 class="modal-title">Modifier une catégorie</h5>--}}
{{--                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <form action="{{ route('categorie.store') }}" method="post">--}}
{{--                        @csrf--}}
{{--                        <input type="hidden" name="categorie_id"--}}
{{--                               value="{{ $value->categorie_id }}">--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="titre">Titre de la catégorie <span--}}
{{--                                    class="text-danger">*</span></label>--}}
{{--                            <input type="text" name="titre_cat"--}}
{{--                                   id="titre{{ $value->categorie_id }}" placeholder="Titre"--}}
{{--                                   value="{{ $value->titre_cat }}" required--}}
{{--                                   class="form-control">--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="code_cat{{ $value->categorie_id }}">Code de la catégorie <span--}}
{{--                                    class="text-danger">* (Min:4)</span></label>--}}
{{--                            <input type="text" name="code_cat" min="4" max="6"--}}
{{--                                   id="code_cat{{ $value->categorie_id }}" placeholder="Code"--}}
{{--                                   value="{{ $value->code_cat }}" required--}}
{{--                                   class="form-control text-uppercase">--}}
{{--                        </div>--}}

{{--                        <div class="form-group">--}}
{{--                            <label for="description_cat{{ $value->categorie_id }}">Description--}}
{{--                                de la catégorie </label>--}}
{{--                            <textarea name="description_cat"--}}
{{--                                      id="description_cat{{ $value->categorie_id }}"--}}
{{--                                      placeholder="Description"--}}
{{--                                      class="form-control">{{ $value->description_cat }}</textarea>--}}
{{--                        </div>--}}
{{--                        <div class="modal-footer">--}}
{{--                            <button type="button" class="btn btn-secondary"--}}
{{--                                    data-dismiss="modal">Annuler--}}
{{--                            </button>--}}
{{--                            <button type="submit" class="btn btn-primary">Enregistrer--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endforeach--}}
