<div class="d-flex text-center justify-content-center">
    <a href="javascript:void(0);" class="btn btn-warning btn-sm" title="Modifier"
       data-toggle="modal" data-target="#chargesModal{{ $value->entre_id }}"><i
            class="fa fa-edit"></i></a>
    @if (Auth::user()->is_admin==1)
        <button class="btn btn-danger btn-sm ml-1 "
                title="Supprimer cet encaissement" id="deletebtn{{ $value->entre_id }}"
                onclick="deleteFun({{ $value->entre_id }})"><i
                class="fa fa-trash"></i></button>
        {{--                                            Auth::user()->id--}}
    @endif
</div>


<!--- Modal pour editer les charges ---->
<div class="modal fade" data-backdrop="static" id="chargesModal{{ $value->entre_id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier une charge</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="text-left" action="{{ route('gestion.entrees.add') }}" method="post" id="edit-charge-form{{ $value->entre_id }}">
                    @csrf
                    <input type="hidden" name="entre_id"
                           value="{{ $value->entre_id }}">
                    <div class="form-group">
                        <label for="raison{{ $value->entre_id }}">Raison <span class="text-danger">*</span></label>
                        <input type="text" name="raison" value="{{ $value->raison_entre }}" id="raison{{ $value->entre_id }}" placeholder="Raison" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="montant{{ $value->entre_id }}">Montant <span class="text-danger">*</span></label>
                        <input type="number" min="0" step="any" value="{{ $value->montant_entre }}" name="montant" id="montant{{ $value->entre_id }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="description{{ $value->entre_id }}">Description
                            de la charge </label>
                        <textarea name="description"
                                  id="description{{ $value->entre_id }}"
                                  placeholder="Description"
                                  class="form-control">{{ $value->description_entre }}</textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">Annuler
                        </button>
                        <button type="submit" onclick="editeCharge({{ $value->entre_id }})" class="btn btn-primary">Enregistrer
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
