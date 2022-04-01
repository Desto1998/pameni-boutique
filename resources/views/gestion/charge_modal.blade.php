<!-- Modal ajouter une charge -->
<div class="modal fade" data-backdrop="static" id="chargesModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter charge</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('gestion.charge.add') }}" method="post" id="charge-form">
                    @csrf
                    <div class="form-group">
                        <label for="titre">Titre de la charge <span class="text-danger">*</span></label>
                        <input type="text" name="titre" id="titre" placeholder="Titre" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="description">Description de la charge </label>
                        <textarea name="description" id="description" placeholder="Description"
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




