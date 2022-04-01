<div class="d-flex justify-content-center">
    <a href="javascript:void(0);" class="btn btn-warning btn-sm" title="Modifier la charge"
       data-toggle="modal" data-target="#categoriesModal{{ $value->categorie_id }}"><i
            class="fa fa-edit"></i></a>
    @if (Auth::user()->is_admin==1)
        <button class="btn btn-danger btn-sm ml-1 "
                title="Supprimer cette catégorie" id="deletebtn{{ $value->categorie_id }}"
                onclick="deleteFun({{ $value->categorie_id }})"><i
                class="fa fa-trash"></i></button>
        {{--                                            Auth::user()->id--}}
    @endif
</div>

<div class="modal fade" data-backdrop="static" id="categoriesModal{{ $value->categorie_id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier une catégorie</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="text-left" action="{{ route('categorie.store') }}" method="post" id="edit-categorie-form{{ $value->categorie_id }}">
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
                        <button type="submit" onclick="getCategorieId({{ $value->categorie_id }})" id="edit-btn{{ $value->categorie_id }}" class="btn btn-primary">Enregistrer
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
