<div class="d-flex text-center">
    <a href="{{ route('client.view',['id' =>$row->client_id]) }}" class="btn btn-success btn-sm" title="Visualiser le client"><i
            class="fa fa-eye"></i></a>
    <a href="{{ route('client.edit',['id' =>$row->client_id]) }}" class="btn btn-warning btn-sm ml-1" title="Modifier le client"><i
            class="fa fa-edit"></i></a>
    @if (Auth::user()->is_admin==1)
        <button class="btn btn-danger btn-sm ml-1 "
                title="Supprimer ce client" id="deletebtn{{ $row->client_id }}"
                onclick="deleteFun({{ $row->client_id }})"><i
                class="fa fa-trash"></i></button>
        {{--                                            Auth::user()->id--}}
    @endif

</div>
