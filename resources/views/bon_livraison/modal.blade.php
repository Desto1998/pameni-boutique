{{--modal pour modifier un produit--}}

{{--    Mondal pour ajouter un nouveau produit--}}
<!-- Modal add produts -->

<div class="modal fade" tabindex="-1" id="new-bon-liv" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Créer un bon de livraison</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="newBon-form">
                    @csrf

                    <div class="form-content" id="form-content">
                        <div class="form-group">
                            <label for="objet">Objet<span
                                    class="text-danger">*</span></label>
                            <input type="text" name="objet" placeholder="Objet" id="objet"
                                   class="form-control"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="date">Date<span
                                    class="text-danger">*</span></label>
                            <input type="date" name="date" placeholder="Date" id="date"
                                   class="form-control"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="date">Utiliser une proformat &nbsp;&nbsp;&nbsp;
                            <input type="checkbox" name="choice" id="choice"
                                   class="checkbox" value="1">
                            </label>
                        </div>
                        <div class="form-group col-md-12 facture-group">
                            <label for="titre_produit">Facture<span
                                    class="text-danger">*</span></label>

                            <select class="form-control dropdown-groups" name="idfacture" required id="idfacture">
                                <option selected="selected" disabled>Selectionner une facture</option>
                                @foreach($factures as $f=>$fact)
                                    <option value="{{ $fact->facture_id }}">{{ $fact->reference_fact }}
                                        ({{ $fact->objet }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-12 hide devis-group">
                            <label for="titre_produit">Proformat<span
                                    class="text-danger">*</span></label>

                            <select class="form-control dropdown-groups" name="iddevis" id="iddevis">
                                <option selected="selected" disabled>Selectionner une proformat</option>
                                @foreach($devis as $d=>$dev)
                                    <option value="{{ $dev->devis_id }}">{{ $dev->reference_devis }}
                                        ({{ $dev->objet }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="lieu_liv">Lieu de livraison<span
                                    class="text-danger"></span></label>
                            <input type="text" name="lieu_liv" placeholder="Lieu de livraison" id="lieu_liv"
                                   class="form-control">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" id="register-btn">Enregistrer</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

