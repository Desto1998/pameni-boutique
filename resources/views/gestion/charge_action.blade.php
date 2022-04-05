<div class="d-flex text-center justify-content-center">
    <a href="javascript:void(0);" class="btn btn-warning btn-sm" title="Modifier la charge"
       data-toggle="modal" data-target="#chargesModal{{ $value->charge_id }}"><i
            class="fa fa-edit"></i></a>
    @if (Auth::user()->is_admin==1)
        <button class="btn btn-danger btn-sm ml-1 "
                title="Supprimer cette charge" id="deletebtn{{ $value->charge_id }}"
                onclick="deleteFun({{ $value->charge_id }})"><i
                class="fa fa-trash"></i></button>
        {{--                                            Auth::user()->id--}}
    @endif
</div>


<!--- Modal pour editer les charges ---->
<div class="modal fade" data-backdrop="static" id="chargesModal{{ $value->charge_id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier une charge</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="text-left" action="{{ route('gestion.charge.add') }}" method="post" id="edit-charge-form{{ $value->charge_id  }}">
                    @csrf
                    <input type="hidden" name="charge_id"
                           value="{{ $value->charge_id }}">
                    <div class="form-group">
                        <label for="titre">Titre de la charge <span
                                class="text-danger">*</span></label>
                        <input type="text" name="titre"
                               id="titre{{ $value->charge_id }}" placeholder="Titre"
                               value="{{ $value->titre }}" required
                               class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="titre">Type la charge <span class="text-danger">*</span></label>
                        <select name="type_charge" id="type_charge_{{ $value->charge_id }}" onchange="showAlerte({{ $value->charge_id }})" class="form-control">
                            <option {{ $value->type_charge !=1 ?'selected':'' }} value="0">Charge variable</option>
                            <option {{ $value->type_charge ==1 ?'selected':'' }} value="1">Charge fixe</option>
                        </select>
                    </div>
                    <div class="form-group hide" id="alerte_{{ $value->charge_id }}">
                        <label for="titre">Jour de paiement <span class="text-danger">*</span></label>
                        <input type="number" min="1" name="alerte" value="{{ $value->alerte }}" id="alerte{{ $value->charge_id }}" max="30" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="description{{ $value->charge_id }}">Description
                            de la charge </label>
                        <textarea name="description"
                                  id="description{{ $value->charge_id }}"
                                  placeholder="Description"
                                  class="form-control">{{ $value->description }}</textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">Annuler
                        </button>
                        <button type="submit" onclick="editeCharge({{ $value->charge_id }})" class="btn btn-primary">Enregistrer
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
