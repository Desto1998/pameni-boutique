<div class="d-flex">
    <a href="#" class="btn btn-warning btn-sm" title="Modifier le produit"
       data-toggle="modal" data-target="#produitsModal{{ $row->produit_id }}"><i
            class="fa fa-edit"></i></a>
    @if (Auth::user()->is_admin==1)
        <button class="btn btn-danger btn-sm ml-1 "
                title="Supprimer ce produit" id="deletebtn{{ $row->produit_id }}"
                onclick="deleteFun({{ $row->produit_id }})"><i
                class="fa fa-trash"></i></button>
    @endif
</div>
