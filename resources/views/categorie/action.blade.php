<div class="d-flex">
    <a href="javascript:void(0);" class="btn btn-warning btn-sm" title="Modifier la charge"
       data-toggle="modal" data-target="#categoriesModal{{ $row->categorie_id }}"><i
            class="fa fa-edit"></i></a>
    @if (Auth::user()->is_admin==1)
        <button class="btn btn-danger btn-sm ml-1 "
                title="Supprimer cette catégorie" id="deletebtn{{ $row->categorie_id }}"
                onclick="deleteFun({{ $row->categorie_id }})"><i
                class="fa fa-trash"></i></button>
        {{--                                            Auth::user()->id--}}
    @endif
</div>

