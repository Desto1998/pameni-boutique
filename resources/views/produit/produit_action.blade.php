<div class="d-flex">
    <a href="#" class="btn btn-warning btn-sm" title="Modifier le produit"
       data-toggle="modal" data-target="#produitsModal{{ $value->produit_id }}"><i
            class="fa fa-edit"></i></a>
    @if (Auth::user()->is_admin==1)
        <button class="btn btn-danger btn-sm ml-1 "
                title="Supprimer ce produit" id="deletebtn{{ $value->produit_id }}"
                onclick="deleteFun({{ $value->produit_id }})"><i
                class="fa fa-trash"></i></button>
    @endif
</div>
<div class="modal fade" id="produitsModal{{ $value->produit_id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier un produit</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="text-left" action="#" method="post" id="edit-product-form{{ $value->produit_id }}">
                    @csrf
                    <input type="hidden" name="produit_id"
                           value="{{ $value->produit_id }}">
                    <input type="hidden" name="reference"
                           value="{{ $value->reference }}">

                    <div class="form-group">
                        <label for="titre_produit{{ $value->produit_id }}">Désignation
                            un
                            produit<span
                                class="text-danger">*</span></label>
                        <input type="text" name="titre_produit"
                               id="titre_produit{{ $value->produit_id }}" required
                               value="{{ $value->titre_produit }}"
                               placeholder="Titre"
                               class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="quantite_produit{{ $value->produit_id }}">Quantité<span
                                class="text-danger">*</span></label>
                        <input type="number" name="quantite_produit" min="1"
                               id="quantite_produit{{ $value->produit_id }}"
                               value="{{ $value->quantite }}" required
                               class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="prix_produit{{ $value->produit_id }}">Prix
                            unitaire<span
                                class="text-danger">*</span></label>
                        <input type="number" name="prix_produit" min="0"
                               id="prix_produit{{ $value->produit_id }}" required
                               value="{{ $value->prix }}" step="any"
                               class="form-control">
                    </div>


                    <div class="form-group">
                        <label for="categorie{{ $value->produit_id }}">Catégorie
                            <span
                                class="text-danger">*</span></label>
                        <select class="form-control" required name="idcategorie"
                                id="categorie{{ $value->produit_id }}">
                            <option disabled="disabled" selected>Sélectionner une
                                charge
                            </option>
                            @foreach($categories as $item)
                                <option
                                    {{ $item->categorie_id==$value->idcategorie?'selected':'' }} value="{{ $item->categorie_id }}">{{ $item->titre_cat }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description_produit{{ $value->produit_id }}">Description
                            du
                            produit </label>
                        <textarea name="description_produit"
                                  id="description_produit{{ $value->produit_id }}"
                                  placeholder="Description"
                                  class="form-control">{{ $value->description }}</textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">Annuler
                        </button>
                        <button type="button" id="edit-btn{{ $value->produit_id }}" onclick="editFun({{ $value->produit_id }})" class="btn btn-primary">Enregistrer
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
