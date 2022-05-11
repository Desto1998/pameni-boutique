<!-- Modal -->
<div class="modal fade" data-backdrop="static" id="tachesModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter une Dépense</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('gestion.taches.add') }}" method="post" id="tache-form">
                    @csrf
                    <div class="d-flex justify-content-center">
                        <label>Utiliser la caisse?</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label class="fw-700"><input type="radio" checked name="is_caisse" class="radio" value="1"> Oui</label>&nbsp;&nbsp;&nbsp;&nbsp;
                        <label class="fw-700"><input type="radio" name="is_caisse" class="radio" value="0"> Non</label>
                    </div>
                    <div class="form-group">
                        <label for="raison">Raison<span class="text-danger">*</span></label>
                        <input type="text" name="raison" id="raison" placeholder="Raison" class="form-control"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="nombre">Quantité <span class="text-danger">*</span></label>
                        <input type="number" name="nombre" min="1" id="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="prix">Prix <span class="text-danger">*</span></label>
                        <input type="number" name="prix" min="0" step="any" id="prix" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="charge">Charges <span class="text-danger">*</span></label>
                        <select class="form-control" required name="idcharge" id="single-select">
                            <option disabled="disabled" selected>Sélectionner une charge</option>
                            @foreach($charges as $item)
                                <option value="{{ $item->charge_id }}">{{ $item->titre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date_debut">Date <span class="text-danger">*</span></label>
                        <input type="date" name="date_debut" required id="date_debut" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="statut">Statut <span class="text-danger">*</span></label>
                        <select class="form-control" required name="statut" id="statut">
                            <option value="1">Effectué</option>
                            <option value="0">Mettre attente</option>
                        </select>
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

