<div class="d-flex justify-content-center">


    <a href="javascript:void(0);" {{ Auth::user()->id!=$value->iduser?'disabled':'' }} class="btn btn-warning btn-sm"
       title="Modifier la dépense"
       data-toggle="modal" data-target="#tachesModal{{ $value->tache_id }}"><i
            class="fa fa-edit"></i>
    </a>

    @if ($value->statut==0)
        <a href="javascript:void(0);"
           {{ Auth::user()->id!=$value->iduser?'disabled':'' }} class="btn btn-success btn-sm ml-1"
           title="Marquer comme effectué" onclick="markTaskAsDoneFun({{ $value->tache_id }})">
            <i class="fa fa-check"></i>
        </a>
    @endif
    @if (Auth::user()->is_admin==1)
        <button class="btn btn-danger btn-sm ml-1 "
                title="Supprimer cette dépense" id="deletebtn{{ $value->tache_id }}"
                onclick="deleteFun({{ $value->tache_id }})"><i
                class="fa fa-trash"></i></button>
        {{--                                            Auth::user()->id--}}
    @endif

</div>

<!--- Modal pour editer les taches ---->
<div class="modal fade" data-backdrop="static" id="tachesModal{{ $value->tache_id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier une tâche</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="text-left" action="{{ route('gestion.taches.add') }}" method="post"
                      id="edit-tache-form{{ $value->tache_id }}">
                    @csrf
                    <input type="hidden" name="tache_id"
                           value="{{ $value->tache_id }}">

                    <div class="form-group">
                        <label for="raison{{ $value->tache_id }}">Raison<span
                                class="text-danger">*</span></label>
                        <input type="text" name="raison"
                               id="raison{{ $value->tache_id }}"
                               value="{{ $value->raison }}" placeholder="Raison"
                               class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="nombre{{ $value->tache_id }}">Quantité <span
                                class="text-danger">*</span></label>
                        <input type="number" name="nombre"
                               value="{{ $value->nombre }}" min="1"
                               id="nombre{{ $value->tache_id }}"
                               class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="prix{{ $value->tache_id }}">Prix <span
                                class="text-danger">*</span></label>
                        <input type="number" name="prix" min="0"
                               value="{{ $value->prix }}" step="any"
                               id="prix{{ $value->tache_id }}" class="form-control"
                               required>
                    </div>


                    <div class="form-group">
                        <label for="charge{{ $value->tache_id }}">Charges <span
                                class="text-danger">*</span></label>
                        <select class="form-control" required name="idcharge"
                                id="charge{{ $value->tache_id }}">
                            <option disabled="disabled" selected>Sélectionner une
                                charge
                            </option>
                            @foreach($charges as $item)
                                <option
                                    {{ $item->charge_id==$value->idcharge?'selected':'' }} value="{{ $item->charge_id }}">{{ $item->titre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date_debut{{ $value->tache_id }}">Date <span
                                class="text-danger">*</span></label>
                        <input type="date" name="date_debut"
                               id="date_debut{{ $value->tache_id }}" required
                               value="{{ $value->date_debut }}"
                               class="form-control">
                    </div>
                    <input type="hidden" name="statut" value="{{ $value->statut }}">
{{--                    <div class="form-group">--}}
{{--                        <label for="statut{{ $value->tache_id }}">Statut <span class="text-danger">*</span></label>--}}
{{--                        <select class="form-control" required name="statut" id="statut{{ $value->tache_id }}">--}}
{{--                            <option {{ $value->statut==1?'selected':'' }} value="1">Effectué</option>--}}
{{--                            <option {{ $value->statut==0?'selected':'' }} value="0">Mettre attente</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">Annuler
                        </button>
                        <button type="submit" onclick="editTache({{ $value->tache_id }})" class="btn btn-primary">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
