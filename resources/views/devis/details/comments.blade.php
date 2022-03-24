
<label class="h4">Commentaires</label>

<button  title="Ajouter un commentaire" onclick="edtiComment({{ 0 }})"
         class="btn btn-light float-right ml-1 btn-sm"><i class="fa fa-plus"></i></button>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">

            <form action="{{ route('devis.add.comment') }}" method="post" class="commentForm"
                  id="commentForm0" style="display: none">
                @csrf
                <label>Nouveau commentaire</label>
                <input type="hidden" name="iddevis" value="{{ $data[0]->devis_id }}">
                <textarea name="message" class="form-control" placeholder="Message..."></textarea>
                <button type="submit" class="btn btn-primary btn-sm float-right mt-1" title="Enregistrer"><i
                        class="fa fa-save"></i></button>
                <button type="button" onclick="closeComment()" class="btn bcompact(): Undefined variable:
tn-light btn-sm float-right mt-1 ml-1 btn-sm" title="Annuler"><i
                        class="fa fa-close"></i></button>
            </form>
        </div>
    </div>

    @foreach($commentaires as $key => $item)
        <div class="row mt-4">
            <div class="col-md-12">
                <h5 class="comment" id="comment{{ $item->commentaire_id }}">
                    {{ $item->message }}
                </h5>
                <form action="{{ route('comment.update') }}" method="post" class="commentForm"
                      id="commentForm{{ $item->commentaire_id }}" style="display: none">
                    @csrf
                    <input type="hidden" name="commentaire_id" value="{{ $item->commentaire_id }}">
                    <textarea name="message" class="form-control" placeholder="Message">{{ $item->message }}</textarea>
                    <button type="submit" class="btn btn-primary btn-sm float-right mt-1" title="Enregistrer"><i
                            class="fa fa-save"></i></button>
                    <button type="button" onclick="closeComment()" class="btn btn-light btn-sm float-right mt-1 ml-1" title="Annuler"><i
                            class="fa fa-close"></i></button>
                </form>
                <small><i class="fa fa-user"></i>&nbsp;&nbsp;{{ $item->lastname.' '.$item->firstname }} </small>
                <div class="float-right">
                    <button {{ Auth::user()->id ==$item->iduser?'':'disabled' }}
                            title="Modifier ce commentaire" onclick="edtiComment({{ $item->commentaire_id }})"
                            class="btn btn-light ml-1 btn-sm"><i class="fa fa-edit"></i></button>
                    <button {{ Auth::user()->id ==$item->iduser?'':'disabled' }}
                            title="Supprimer ce commentaire" onclick="deleteComment({{ $item->commentaire_id }})"
                            class="btn btn-light ml-1 btn-sm"><i class="fa fa-trash"></i></button>
                </div>
            </div>
            {{--                <div class="col-md-1 float-right d-flex">--}}

            {{--                </div>--}}
        </div>

    @endforeach

</div>
