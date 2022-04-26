<!-- Modal -->
<div class="modal fade" data-backdrop="static" id="clientsModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un client</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('client.store') }}" method="post" id="client-form">
                    @csrf
                    <div class="form-group">
                        <label for="type_client">Sélectionner le type du client</label>
                        <select class="form-control" onchange="filterFormInput()" required name="type_client" id="type_client">
                            <option value="0">Personne physique</option>
                            <option value="1">Entreprise</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6 clienthide">
                            <label for="nom_client">Nom<span class="text-danger">*</span></label>
                            <input type="text"  name="nom_client" id="nom_client" required placeholder="Nom" class="form-control">
                        </div>

                        <div class="form-group col-md-6 clienthide">
                            <label for="prenom_client">prenom</label>
                            <input type="text" name="prenom_client" id="prenom_client" placeholder="Prénom" class="form-control">
                        </div>
                    </div>

                    <div class="form-group enterprisehide" >
                        <label for="raison_s_client">Raison sociale<span class="text-danger">*</span></label>
                        <input type="text" disabled name="raison_s_client" id="raison_s_client" placeholder="Raison sociale" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="email_client">Email<span class="text-danger"></span></label>
                        <input type="email" name="email_client" id="email_client" placeholder="Email" class="form-control">
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
                        <label for="categorie">Pays</label>
                        <select class="form-control" required name="idpays" id="single-select">
                            <option disabled="disabled" selected>Sélectionner un pays</option>
                            @foreach($pays as $item)
                                <option value="{{ $item->pays_id }}">{{ $item->nom_pays }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="ville_client">Ville<span class="text-danger">*</span></label>
                            <input type="text" name="ville_client" required id="ville_client" placeholder="Ville" class="form-control">
                        </div>

                        <div class="form-group  col-md-6">
                            <label for="postale">Boite postale</label>
                            <input type="text" name="postale" id="postale" placeholder="" class="form-control">
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="adresse_client">Adresse</label>
                        <input type="text" name="adresse_client" id="adresse_client" placeholder="Adresse" class="form-control">
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
