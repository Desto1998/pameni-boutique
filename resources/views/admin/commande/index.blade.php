@extends('_layouts.app')
@section('title','| CATEGORIES')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <span class="float-left h4">Liste des commandes</span>

                        <div class="table-responsive mt-3">
                            <table id="example" class="display w-100 text-center">
                                <thead class="bg-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Client</th>
                                    <th>Ville</th>
                                    <th>Adresse</th>
                                    <th>Produits</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $key=>$value)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $value->date_com }}</td>
                                        <td>{{ $value->nom }} {{ $value->prenom }}</td>
                                        <td>{{ $value->ville }}</td>
                                        <td>{{ $value->adresse }}</td>
                                        <td>
                                            @php
                                                $prix = 0;
                                            @endphp
                                            @foreach($produits as $p)
                                                @if ($p->idcommande==$value->idcommande)
                                                    <small>{{ $p->nom }} (* {{ $p->qte }})</small><br>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @php
                                                $prix = 0;
                                            @endphp
                                            @foreach($produits as $p)
                                                @if ($p->idcommande==$value->idcommande)
                                                    @php
                                                    $prix += $p->prix;
                                                    @endphp
                                                    {{ $prix }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @if ($value->statut==0)
                                                <span class="text-warning">En attente</span>
                                            @elseif($value->statut==1)
                                                <span class="text-success">En cours</span>
                                            @else
                                                <span class="text-primary">Traité</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                @if ($value->statut==0)
                                                    <a href="{{ route('commande.encours',['id'=>$value->idcommande]) }}" class="btn btn-success btn-sm" title="Marquer comme en cours"
                                                    ><i class="fa fa-check"></i></a>
                                                @elseif($value->statut==1)
                                                    <a href="{{ route('commande.traite',['id'=>$value->idcommande]) }}" class="btn btn-light btn-sm" title="Marquer comme traite"
                                                    ><i class="fa fa-archive"></i></a>
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="categoriesModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une catégorie</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="categorie-form">
                        @csrf
                        <div class="form-group">
                            <label for="titre_cat">Titre de la catégorie <span class="text-danger">*</span></label>
                            <input type="text" name="titre_cat" id="titre_cat" placeholder="Titre" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="description_cat">Description de la catégorie </label>
                            <textarea name="description_cat" id="description_cat" placeholder="Description"
                                      class="form-control"></textarea>
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
@stop
@section('script')
    <script>
        function deleteFun(id) {
            var table = $('#example').DataTable();

            if (confirm("Supprimer cette categorie?")===true) {
                // if (confirm("Supprmer cette tâches?") == true) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('categories.delete') }}",
                    data: {id: id},
                    dataType: 'json',
                    success: function (res) {
                        if (res) {
                            // alert("Supprimé avec succès!")
                            table.row( $('#deletebtn'+id).parents('tr') )
                                .remove()
                            toastr.success("Supprimé avec succès!");
                        } else {
                            alert( "Erreur lors de la suppression!")
                        }

                    },
                    error: function (resp) {
                        alert("Une erreur s'est produite.");
                    }
                });
            }

            // }
        }
    </script>
@endsection
