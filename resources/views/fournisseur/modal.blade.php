
<!-- Modal -->
<div class="modal fade" data-backdrop="static" id="fournisseursModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un fournisseur</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('fournisseur.store') }}" method="post" id="fournisseur-form">
                    @csrf
                    <div class="form-group">
                        <label for="type_fr">Sélectionner le type du fournisseur</label>
                        <select class="form-control" onchange="filterFormInput()" required name="type_fr" id="type_fr">
                            <option value="0">Personne physique</option>
                            <option value="1">Entreprise</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6 clienthide">
                            <label for="nom_fr">Nom<span class="text-danger">*</span></label>
                            <input type="text"  name="nom_fr" id="nom_fr" required placeholder="Nom" class="form-control">
                        </div>

                        <div class="form-group col-md-6 clienthide">
                            <label for="prenom_fr">prenom</label>
                            <input type="text" name="prenom_fr" id="prenom_fr" placeholder="Prénom" class="form-control">
                        </div>
                    </div>

                    <div class="form-group enterprisehide" >
                        <label for="raison_s_fr">Raison sociale<span class="text-danger">*</span></label>
                        <input type="text" disabled name="raison_s_fr" id="raison_s_fr" placeholder="Raison sociale" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="email_fr">Email<span class="text-danger"></span></label>
                        <input type="email" name="email_fr" id="email_fr" required placeholder="Email" class="form-control">
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="phone_1">Téléphone 1<span class="text-danger">*</span></label>
                            <input type="tel" name="phone_1" id="phone_1" required placeholder="Téléphone" class="form-control">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="phone_2">Téléphone 2</label>
                            <input type="tel" name="phone_2" id="phone_2" placeholder="Téléphone" class="form-control">
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="single-select">Pays</label>
                        <select class="form-control" required name="idpays" id="single-select">
                            <option disabled="disabled" selected>Sélectionner un pays</option>
                            @foreach($pays as $item)
                                <option value="{{ $item->pays_id }}">{{ $item->nom_pays }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="ville_fr">Ville<span class="text-danger">*</span></label>
                            <input type="text" name="ville_fr" required id="ville_fr" placeholder="Ville" class="form-control">
                        </div>

                        <div class="form-group  col-md-6">
                            <label for="postale">Boite postale</label>
                            <input type="text" name="postale" id="postale" placeholder="" class="form-control">
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="adresse_fr">Adresse</label>
                        <input type="text" name="adresse_fr" id="adresse_fr" placeholder="Adresse" class="form-control">
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 enterprisehide">
                            <label for="contribuabe">Numéro de contibuabe</label>
                            <input type="text" disabled name="contribuabe" id="contribuabe" placeholder="Contribuabe" class="form-control">
                        </div>

                        <div class="form-group enterprisehide col-md-6">
                            <label for="rcm">RC</label>
                            <input type="text" name="rcm" disabled id="rcm" placeholder="RC" class="form-control">
                        </div>
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
