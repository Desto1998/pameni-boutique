@extends('_layouts.app')
@section('title','| PRODUITS')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <span class="float-left h4">Liste des produits</span>
                        <button type="button" class="btn btn-primary float-right mb-3" data-toggle="modal"
                                data-target="#categoriesModal"><i class="fa fa-plus">&nbsp; Ajouter</i></button>

                        <div class="table-responsive">
                            <table id="example" class="display w-100 text-center">
                                <thead class="bg-primary">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">nom</th>
                                    <th scope="col">prix</th>
                                    <th scope="col">Qte</th>
                                    <th scope="col">Categorie</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($data as $key => $produit): ?>
                                <tr>
                                    <th scope="row"><?= $key+1 ?></th>
                                    <td>
                                        <img src="<?= $produit->image ?>" style="width: 10%" alt="Not found">
                                    </td>
                                    <td><?= $produit->nom ?></td>
                                    <td style="font-weight: bold; color: green"><?= $produit->prix ?> FCFA</td>
                                    <td style="font-weight: bold; color: green"><?= $produit->quantite ?></td>
                                    <td style="font-weight: bold; color: green">
                                        <?= $produit->quantite ?>
                                        @foreach($categories as $cat)
                                            @if ($cat->idcat == $produit->idcat)
                                                {{ $cat->titre }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td><?= mb_strimwidth($produit->description, 0, 100, "..."); ?></td>
                                    <td class="d-flex">
                                        <a href="{{ route('product.edit',['id'=>$produit->id]) }}"  class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>

                                        <a href="javascript:void(0);" onclick="deleteFun(<?= $produit->id ?>)" class="btn btn-danger btn-sm ms-2"> <i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('script')
    <script>
        function deleteFun(id) {
            // var table = $('#example').DataTable();

            if (confirm("Supprimer ce produit?")===true) {
                // if (confirm("Supprmer cette tâches?") == true) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('produit.delete') }}",
                    data: {id: id},
                    dataType: 'json',
                    success: function (res) {
                        if (res) {
                            // alert("Supprimé avec succès!")
                            table.row( $('#deletebtn'+id).parents('tr') )
                                .remove()
                            window.location.reload()
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
