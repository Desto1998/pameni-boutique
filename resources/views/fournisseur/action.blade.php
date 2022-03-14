<div class="d-flex text-center">
    <a href="{{ route('fournisseur.view',['id' =>$row->fournisseur_id]) }}" class="btn btn-success btn-sm" title="Visualiser le fournissuer"><i
            class="fa fa-eye"></i></a>
    <a href="{{ route('fournisseur.edit',['id' =>$row->fournisseur_id]) }}" class="btn btn-warning btn-sm ml-1" title="Modifier le fournissuer"><i
            class="fa fa-edit"></i></a>
    @if (Auth::user()->is_admin==1)
        <button class="btn btn-danger btn-sm ml-1 "
                title="Supprimer ce fournissuer" id="deletebtn{{ $row->fournisseur_id }}"
                onclick="deleteFun({{ $row->fournisseur_id }})"><i
                class="fa fa-trash"></i></button>
        {{--                                            Auth::user()->id--}}
    @endif
</div>
