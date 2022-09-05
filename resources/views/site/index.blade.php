@extends('_layouts.site_layout')
@section('title','| ACCEUIL')
@section('content')
<div class="album py-5 bg-light">
    <div class="container">
        @include('_partial._flash-message')
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
{{--            {{ dd(session('panier')) }}--}}
            <?php foreach ($produits as $produit): ?>
            <div class="col">
                <div class="card shadow-sm p-4">
                    <a  href="{{ route('site.detail',['id'=>$produit->id]) }}" class="detail-link nav-link" title="Voir les details" >
                        <h4 class="titre-color-1 titre-hover my-3 mx-3 text-center"><?= $produit->nom ?></h4>
                    </a>
                    <a href="{{ route('site.detail',['id'=>$produit->id]) }}" class="detail-link">
                        <img class="product-img" title="Voir les details" src="<?= $produit->image ?>" alt="Image introuvable">
                    </a>
                    <h6>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </h6>

                    <div class="card-body">
                        <p class="card-text"><?= substr($produit->description, 0, 100); ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <!--                                        <form action="panier.php" method="GET">-->
                                <!--                                            <input type="hidden" name="" value="">-->
                                <a href="{{ route('site.add.tocard',['id'=>$produit->id]) }}">
                                    <button type="button" class="btn btn-pro-title my-3" name="add_to_cart">
                                        Ajouter au panier <i class="fas fa-shopping-cart"></i></button>
                                </a>

                                <!--                                        </form>-->

                            </div>
                            <small><s class="text-secondary"><?= $produit->prix + $produit->prix * 10 / 100 ?></s></small>
                            <small class="text-muted"><?= $produit->prix ?> fcf</small>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection
