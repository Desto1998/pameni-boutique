@extends('_layouts.app')
@section('title','| AJOUTER-PRODUIT')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin">
                <div class="card">
                    <div class="card-body ps-3">
                        <div class="row text-center">
                            <label class="text-center w-100 h4">Ajouter un produits</label>
                        </div>


                        <form method="post" class="mt-4" action="{{ route('product.update') }}">
                            <input type="hidden" name="id" value="<?php if (isset($product[0]->id)) echo $product[0]->id; ?>">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-5 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1" class="form-label">Nom du produit <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nom" value="<?=  isset($product[0]->nom) ? $product[0]->nom : ''; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1" class="form-label">Prix <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="prix" value="<?=  isset($product[0]->prix) ? $product[0]->prix : ''; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1" class="form-label">Quantite <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="quantite" value="<?=  isset($product[0]->quantite) ? $product[0]->quantite : ''; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1" class="form-label">Categorie <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" name="idcat">
                                            <option disabled selected>Selectionnez une categorie</option>
                                            <?php
                                            foreach ($categories as $c) :?>
                                            <option <?= $product[0]->idcat==$c->idcat? 'selected':''; ?> value="<?= $c->idcat ?>"><?= $c->titre ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1" class="form-label">Description</label>
                                        <textarea class="form-control" name="description"><?=  isset($product[0]->description) ? $product[0]->description : ''; ?></textarea>
                                    </div>
                                    <div class="form-group mt-2 justify-content-end">
                                        <button type="submit" name="modifier" class="btn btn-success float-end">Enregistrer</button>
                                    </div>

                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group" id="img-bloc">
                                        <label for="exampleInputEmail1" class="form-label">Lien de l'image de mise en avant<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control mb-2" name="image[]" required
                                               placeholder="Lien de l'image" value="<?=  isset($product[0]->image) ? $product[0]->image : ''; ?>">
                                    </div>
                                    <h4 class="my-3">Autre images</h4>
                                    <?php foreach ($images as $key=>$img): if ($key!=0 && !empty($img->chemin)): ?>

                                    <div class="form-group" id="img-bloc">
                                        <label for="exampleInputEmail1" class="form-label">Lien de l'image <span
                                                class="text-danger"></span></label>
                                        <input type="text" class="form-control mb-2" name="image[]"
                                               placeholder="Lien de l'image" value="<?=  isset($img->chemin) ? $img->chemin : ''; ?>">
                                    </div>
                                    <?php endif; endforeach; ?>
                                    <div class="form-group mt-2 justify-content-end">
                                        <button type="button" class="btn btn-secondary btn-sm float-end" id="add-img"
                                                title="Ajouter une nouvelle image"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop
@section('script')
    <script>
        $('#add-img').on('click', function (e) {
            $('#img-bloc').append('<input type="text" class="form-control mb-2" name="image[]" placeholder="Lien de l\'image">')
        });
    </script>
@endsection
