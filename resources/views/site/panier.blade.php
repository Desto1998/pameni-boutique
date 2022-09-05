@extends('_layouts.site_layout')
@section('title','| MON-PANIER')
@section('content')
<div class="container">
    <table class="table w-100 mt-2 table-bordered text-center">
        <tr>
            <td colspan="2" class="fs-4">Votre panier</td>
            <td class="text-end fw-bold fs-3">Total</td>
            <td class="text-end fw-bold fs-3"> {{ (new \App\Models\Panier())->totalCartFromCard() }} CFA</td>
            <td></td>
        </tr>
        <tr>
            <td>Image</td>
            <td>Libellé</td>
            <td>Quantité</td>
            <td>Prix Unitaire</td>
            <td>Action</td>
        </tr>


        <?php
        if (!empty(session('panier'))) {
        //        $target_dir = "../../assets/images/";
        $nb_produit = 0;
        $data = session('panier');
        foreach ($data as $key => $value) {
        ?>
        <tr class="text-center">
            <td><img class="img-panier" src="<?= $data[$key]["image"] ?>"
                     alt="Image introuvable"/></td>
            <td class="text-center"><?= $data[$key]["nom"] ?></td>
            <td class="text-center fw-bold"><?= $data[$key]["qte"] ?></td>
            <td class="text-center fw-bold"><?= $data[$key]["prix"] * $data[$key]["qte"] ?> CFA</td>
            <td class="text-center">
                <a href="{{ route('site.removeFromCard',['id'=>$data[$key]["id"]]) }}" class="btn-sm btn-danger btn"
                   title="Retirer du pannier">Supprimer</a>
            </td>
        </tr>

        <?php }
        } else {
            echo "<h2>Vous n'avez auccun produit dans le panier</h2>";
        }

        ?>
    </table>
    <div class="col-md-12">
        <?php

        if (!empty(session('panier'))) { ?>
        <a href="{{ route('site.clearCard') }}" class="btn btn-danger float-end ms-2">Vider le panier</a>
        <a href="{{ route('site.checkout.page') }}" class="btn btn-primary float-end me-5">Commander</a>
        <?php } ?>
    </div>

</div>
@endsection
@section('script')
@endsection
