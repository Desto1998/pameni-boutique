{{--modal pour modifier un produit--}}

{{--    Mondal pour ajouter un nouveau produit--}}
<!-- Modal add produts -->

<div class="modal fade bd-example-modal-lg" tabindex="-1" id="new-facture-avoir" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Créer une facture avoir</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="newAvoir-form">
                    @csrf

                    <div class="form-content" id="form-content">
                        <div class="form-group">
                            <label for="titre_produit">Objet<span
                                    class="text-danger">*</span></label>
                            <input type="text" name="objet" placeholder="Objet" id="titre_produit"
                                   class="form-control"
                                   required>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="date">Date<span
                                        class="text-danger">*</span></label>
                                <input type="date" name="date" placeholder="Date" id="date"
                                       class="form-control"
                                       required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="titre_produit">Factures<span
                                        class="text-danger">*</span></label>

                                <select class="form-control facture" name="idfacture" required id="single-select">
                                    <option selected="selected" disabled>Selectionner une facture</option>
                                    @foreach($factures as $f=>$fact)
                                        <option value="{{ $fact->facture_id }}">{{ $fact->reference_fact }}
                                            ({{ $fact->objet }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row my-4">
                        <div class="col-md-6">
                            <label>Désignation des produits</label>
                        </div>
                        <div class="col-md-3">
                            <label>Montant des produits</label>
                        </div>
                        <div class="col-md-3">
                            <label>Quantités à réduire</label>
                        </div>
                    </div>
                    @foreach($factures as $f=>$fact)
                        <input type="hidden" value="{{ $fact->tva_statut }}" name="tva_statut[{{ $fact->facture_id }}]" id="tva_statut{{ $fact->facture_id }}">
                       <div class="f-product-block hide" id="f-product-block{{ $fact->facture_id }}">
                          @foreach($produits as $p)
                              @if ($p->idfacture===$fact->facture_id)
                                   <div class="row my-2" id="f-product{{ $p->produit_f_id }}">
                                       <div class="col-md-6 form-group">
                                           <label>
                                               <input type="checkbox" class="checkbox produit_f_id" value="{{ $p->produit_f_id }}" name="produit_f_id[]">
                                               &nbsp;&nbsp;{{ $p->titre_produit }}({{ $p->reference }})
                                           </label>
                                       </div>
                                       <input type="hidden" class="" value="{{ $p->remise }}" name="remise[{{ $p->produit_f_id }}]" id="remise{{ $p->produit_f_id }}">
                                       <div class="col-md-3 form-group">
                                           <input type="number" disabled min="0"  value="{{ $p->prix }}"
                                                  class="form-control" id="prix{{ $p->produit_f_id }}">
                                       </div>
                                       <div class="col-md-3 form-group">
                                           <input type="number" min="0" max="{{ $p->quantite }}" value="{{ $p->quantite }}"
                                                  name="quantite[{{ $p->produit_f_id }}]" class="form-control quantite" id="qte{{ $p->produit_f_id }}">
                                       </div>
                                   </div>
                              @endif
                           @endforeach
                       </div>

                    @endforeach
                    <div class="row justify-content-end">
                        <div class="col-md-3 float-right">
                            <div class="form-group float-right">
                                <label>Net à déduire</label>
                                <input type="number" value="0" class="disabled form-control" disabled name="net" id="montantNet">
                            </div>
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

