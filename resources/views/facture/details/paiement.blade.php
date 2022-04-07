<div class="col-md-12 mb-3">
    <label class="float-left h4">Liste des paiements pour cette facture</label>
    @if ($data[0]->statut ==1)
        <a href="javascript:void(0);" data-toggle="modal"
           data-target="#paiement-modal" class="btn btn-secondary mb-3 btn-sm ml-1 float-right"
           title="Ajouter un paiement."><i
                class="fa fa-plus"></i></a>
    @endif

</div>
<div class="table-responsive mt-5">
    <table id="example" class="text-center">
        <thead class="bg-primary">
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Mode</th>
            <th>Montant</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @php
          $total =0;
        @endphp
        @foreach($paiements as $k =>$item)
            @php
                $total +=$item->montant;
            @endphp
            <tr>
                <td>{{ $k+1 }}</td>
                <td>{{ $item->date_paiement }}</td>
                <td>{{ $item->mode }}</td>
                <td>{{ $item->montant }}</td>
                <td>{{ $item->description }}</td>
                <td>
                    <a href="javascript:void(0)" {{ Auth::user()->id!=$item->iduser?'disabled':'' }} class="btn btn-sm btn-warning"
                       data-toggle="modal" data-target="#paiement-modal{{ $item->paiement_id }}">
                        <i class="fa fa-warning"></i>
                    </a>
                    @if (Auth::user()->is_admin==1)
                        <a href="javascript:void(0)" onclick="deletePaiement({{ $item->paiement_id }})" class="btn btn-sm btn-danger">
                            <i class="fa fa-trash"></i>
                        </a>
                    @endif
                </td>
            </tr>
            <!-- Modal make facture -->
            <div class="modal fade" data-backdrop="static" id="paiement-modal{{ $item->paiement_id }}">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Informations du paiement</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('factures.paiement.update') }}" method="post" id="modal-form{{ $item->paiement_id }}">
                                @csrf
                                <input type="hidden" name="idfacture" id="idfacture" value="{{ $data[0]->facture_id }}" required>
                                <input type="hidden" name="paiement_id" id="paiement_id" value="{{ $item->paiement_id }}" required>
                                <div class="form-group">
                                    <label>Mode de paiement <span class="text-danger">*</span></label>
                                    <select name="mode" class="form-control">
                                        <option>Espèce</option>
                                        <option>Chèque</option>
                                        <option>Carte de crédit</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="montant{{ $item->paiement_id }}">Montant <span class="text-danger">*</span></label>
                                    <input type="number" step="any" name="montant" value="{{ $item->montant }}" id="montant{{ $item->paiement_id }}" min="0" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Description  <span class="text-danger">*</span></label>
                                    <textarea name="description" class="form-control">{{ $item->description }}</textarea>
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
        @endforeach

        </tbody>
    </table>
</div>
<div class="col-md-12 mt-3">
    <label>Payé: <span class="text-warning">{{ $total }} FCFA</span></label><br>
    <label>Reste: <span class="text-danger">{{ $montantTTC-$total }} FCFA</span></label><br>
    <label>Total: <span class="text-success">{{ $montantTTC }} FCFA</span></label>
</div>

<!-- Modal make facture -->
<div class="modal fade" id="paiement-modal">
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
                    <input type="hidden" name="idfacture" id="idfacture" value="{{ $data[0]->facture_id }}" required>
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
