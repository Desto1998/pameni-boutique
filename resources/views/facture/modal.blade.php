<!-- Modal make facture -->
<div class="modal fade" data-backdrop="static" id="paiement-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Informations du paiement</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" id="modal-form">
                    @csrf
                    <input type="hidden" name="idfacture" id="idfacture" value="" required>
                    <div class="form-group">
                        <label for="date">Mode de paiement <span class="text-danger">*</span></label>
                        <select name="mode" class="form-control">
                            <option>Espèce</option>
                            <option>Chèque</option>
                            <option>Carte de crédit</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="montant">Montant <span class="text-danger">*</span></label>
                        <input type="number" step="any" name="montant" id="montant" min="0" class="form-control" required>
                        <div id="alert">

                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description  <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control"></textarea>
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

