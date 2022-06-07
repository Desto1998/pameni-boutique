
<div class="modal fade bd-example-modal-lg" tabindex="-1" data-backdrop="static" role="dialog" aria-hidden="true">
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

                            <div class="form-group col-md-3">
                                <label for="quantite_produit">Quantité<span
                                        class="text-danger">*</span></label>
                                <input type="number" name="quantite_produit"
                                       value="" required min="0" id="quantite_produit"
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
                            <div class="form-group col-md-3">
                                <label class="" for="remp">Remise <span class="text-danger"></span></label>
                                <input type="number" step="any" name="rem" id="remp" value="0" min="0" max="100" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description_produit">Description du produit </label>
                            <textarea name="description_produit" id="description_produit" placeholder="Description"
                                      class="form-control"></textarea>
                        </div>

                    </div>
                    <div class="row col-md-12 d-flex justify-content-end mb-3">
                        <button type="button" class="btn btn-sm btn-success float-right" id="addFields"
                                title="Cliquez pour ajouter une nouvelle section!">
                            <i class="fa fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-light float-right ml-2" id="removeFields"
                                title="Supprimer tout!">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </div>
                </form>
                {{--                    formulaire contenant les produits validées --}}

                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
{{--                        <button type="submit" class="btn btn-primary">Enregistrer</button>--}}
                    </div>
            </div>

        </div>
    </div>
</div>

