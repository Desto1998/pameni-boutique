{{--modal pour modifier un produit--}}

@foreach($data as $key=> $value)
    <div class="modal fade" id="produitsModal{{ $value->produit_id }}">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier un produit</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="edit-product-form{{ $value->produit_id }}">
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
                                   value="{{ $value->quantite_produit }}" required
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="prix_produit{{ $value->produit_id }}">Prix
                                unitaire<span
                                    class="text-danger">*</span></label>
                            <input type="number" name="prix_produit" min="0"
                                   id="prix_produit{{ $value->produit_id }}" required
                                   value="{{ $value->prix_produit }}" step="any"
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
                                      class="form-control">{{ $value->description_produit }}</textarea>
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

@endforeach
    {{--    Mondal pour ajouter un nouveau produit--}}
    <!-- Modal add produts -->

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter des produits</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="product-form">
                        @csrf

                        <div class="form-content" id="form-content">
                            <div class="form-group">
                                <label for="titre_produit">Désignation du produit<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="titre_produit" placeholder="Désignation" id="titre_produit"
                                       class="form-control"
                                       required>
                            </div>
                            <div class="row col-md-12">
                                <div class="form-group col-md-6">
                                    <label class="" for="categorie">Catégorie <span class="text-danger">*</span></label>
                                    <select class="form-control" required name="idcategorie" id="single-select">
                                        <option disabled="disabled" selected>Sélectionner une catégorie</option>
                                        @foreach($categories as $item)

                                            <option value="{{ $item->categorie_id }}">{{ $item->titre_cat }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="quantite_produit">Quantité<span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="quantite_produit"
                                           value="" required min="1" id="quantite_produit"
                                           class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="prix_produit">Prix
                                        unitaire<span
                                            class="text-danger">*</span></label>
                                    <input type="number" id="prix_produit" name="prix_produit"
                                           required step="any"
                                           value="" min="0"
                                           class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description_produit">Description du produit </label>
                                <textarea name="description_produit" id="description_produit" placeholder="Description"
                                          class="form-control"></textarea>
                            </div>

                        </div>
                        <div class="row col-md-12 d-flex justify-content-end mb-3">
                            <button type="submit" class="btn btn-sm btn-success float-right" id="addFields"
                                    title="Cliquez pour ajouter une nouvelle section!">
                                <i class="fa fa-plus"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-light float-right ml-2" id="removeFields"
                                    title="Supprimer tous!">
                                <i class="fa fa-trash-o"></i>
                            </button>
                        </div>
                    </form>
{{--                    formulaire contenant les produits validées --}}
                    <form method="post" action="{{ route('produit.store') }}" id="product-form-value">

                        <div class="created-element" style="overflow: auto; max-height: 300px;">
                            <table id="validated-element" style="width: 100%; border-collapse: collapse"
                                   class="table col-md-12 table-striped table-responsive">
                                <thead class="bg-primary">
                                <tr class="text-center">
                                    <th style="border:1px solid #eaeaea; width: 250px">Titre</th>
                                    <th style="border:1px solid #eaeaea; width: 100px">Quantité</th>
                                    <th style="border:1px solid #eaeaea; width: 100px">Prix</th>
                                    <th style="border:1px solid #eaeaea; width: 200px">Categorie</th>
                                    <th style="border:1px solid #eaeaea; width: 250px">Description</th>
                                    <th style="border:1px solid #eaeaea; width: 20px"></th>
                                </tr>
                                </thead>
                                <tbody id="content-item">

                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

