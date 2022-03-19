<!-- Modal make facture -->
<div class="modal fade" id="fature-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Informations de la facture</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" id="modal-form">
                    @csrf
                    <input type="hidden" name="iddevis" id="iddevis" value="" required>
                    <div class="form-group">
                        <label for="date">Date de la facture <span class="text-danger">*</span></label>
                        <input type="date" name="date" id="date"  class="form-control">
                    </div>
                    <label class="nav-label">Informations du bon de commande</label>
                    <div class="form-group">
                        <label for="ref_bon">Référence <span class="text-danger">*</span></label>
                        <input type="text" name="ref_bon" maxlength="20" id="ref_bon" placeholder="Reference" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="date_bon">Date  <span class="text-danger">*</span></label>
                        <input type="date" name="date_bon" id="date_bon" minlength="4" maxlength="6"  class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="logo-upload">Joindre un fichier</label>
                        <input type="file" name="logo" id="logo-upload" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3 ml-5" title="Cliquer pour selectioner une image">
                            <img id="logo-zone" style="width: 200px; height: 200px; min-height: 200px; min-width: 200px" src="{{ asset('images/logo-thumbnail.png') }}" alt="Ouopps! Auncune image disponible">
                        </div>
                        {{--                                    <div class="kv-avatar-hint">--}}
                        {{--                                        <small>Sélectionner un fichier< 1500 KB</small>--}}
                        {{--                                    </div>--}}
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
