@extends('_layouts.site_layout')
@section('title','| SHOP')
@section('content')
    <div class="album py-5 bg-light bg-white">
        <div class="container">
            @include('_partial._flash-message')
            <div class="col-md-12 col-sm-12">
                <div class="row">
                   <div class="col-md-3 col-sm-12 bg-light pt-4">
                       @foreach($categories as $cat)
                           <ul class="cat-ul nodecoration">
                               <li class="cat-list link-danger"><a class="titre-color-1 titre-hover nav-link h5" href="{{ route('site.categories',['id'=>$cat->idcat]) }}">{{ $cat->titre }}</a></li>
                           </ul>
                       @endforeach

                   </div>
                   <div class="col-md-9 col-sm-12">
                       @foreach($categories as $cat)
                           <div class="alert my-3 alert-secondary alert-dismissible fade show">

                               <strong>
                                   <label class="cat-titre"><a class="cat-link link-danger nav-link h5" href="{{ route('site.categories',['id'=>$cat->idcat]) }}">{{ $cat->titre }}</a></label>
                               </strong>
                           </div>
                           <div class="cat-ul">
                           </div>
                           <div class="row row-cols-0 row-cols-sm-3 row-cols-md-2 g-3">
                               {{--            {{ dd(session('panier')) }}--}}
                               <?php foreach ($produits as $produit): ?>
                               @if ($produit->idcat===$cat->idcat)
                                   <div class="col justify-content-center text-center">
                                       <div class="card shadow-sm p-4">
                                           <a  href="{{ route('site.detail',['id'=>$produit->id]) }}" class="titre-color-1 titre-hover nav-link" title="Voir les details" >
                                               <h4 class="text-yello my-2 mx-3 text-center titre-color-1 titre-hover nav-link"><?= $produit->nom ?></h4>
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
                                                           <button type="button" class="btn btn-pro-title" name="add_to_cart">
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
                               @endif

                               <?php endforeach; ?>
                           </div>

                       @endforeach
                   </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('script')
@endsection
