<!-- Modal make facture -->
<div class="modal fade" data-backdrop="static" id="print-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Impression du bon de commande</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('commandes.print.currency') }}" method="post" id="modal-form">
                    @csrf
                    <input type="hidden" name="id" id="idcommande" value="" required>
                    <div class="form-group">
                        <label for="date">Sélectionner une dévise <span class="text-danger">*</span></label>
                        <select name="currency" class="form-control" id="select-currency">
                            <option value="FCFA" selected>FCFA</option>
                            <option value="EUR">Euro EUR</option>
                            <option value="USD">Dollar des États-Unis USD </option>
                            <option value="CFA">Franc CFA  CFA</option>
                            <option value="SAR">Riyal saoudien  SAR</option>
                            <option value="XAF">Franc CFA-BEAC  XAF</option>
                            <option value="XOF">Franc CFA-BCEAO  XOF </option>
                            <option value="NGN">Naira NGN </option>

                        </select>
                    </div>
                    <div class="form-group for-amount hide">
                        <label for="montant">Montant du jour<span class="text-danger">*</span></label>
                        <input type="number" min="1" step="any" name="montant" id="montant" min="0" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Imprimer</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

