@extends('_layouts.site_layout')
@section('title','| COMMANDES')
@section('css_before')
    <link rel="stylesheet" href="{{ asset('assets/commande.css') }}">
@stop
@section('content')
<div class="container">
    <h1><strong>commande</strong></h1>
    <div class="row" >
        <div class="col-md-12">
            <div class="titre"><span>déjà client?</span> Cliquer ici pour vous connecter</div>
            <div class="titre"><span>Avez-vous déjà un code promo?</span> Cliquer ici pour saisir votre code </div>
        </div>
    </div>
    @include('_partial._flash-message')
    <div class="col-md-12">
        <form class="form" method="post" action="{{ route('commande.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-7">
                    <h2>details de facturation</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="prenom">Prenom*</label>
                                <input type="text" id="prenom" name="prenom" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="nom">Nom*</label>
                                <input type="text" id="nom" name="nom" class="form-control">
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="Quartier">Quartier*</label>
                        <input type="text" id="Quartier" name="adresse" class="form-control" placeholder="Quartier">
                    </div>

                    <div class="form-group">
                        <label for="Ville">Ville*</label>
                        <input type="text" id="Ville" name="ville" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="telephone">Telephone*</label>
                        <input type="text" id="telephone" name="tel" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="adresse-de-messagerie">Email*</label>
                        <input type="text" id="adresse-de-messagerie" name="email" class="form-control">
                    </div>

                    <div class="checkbox">
                        <label for=""><input type="checkbox">creer un compte?</label>
                    </div>

                    <h2>Informtions complementaires</h2>

                    <div class="textarea">
                        <label for="notes-de-commande">notes de commande (facultatif)</label>
                        <textarea name="note" id="notes-de-commande"
                                  cols="30" rows="5"  class="form-control" placeholder="commentaires concernant votre commande. ex:consigne de livraison. "></textarea>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="votre-commande">

                        <h2>Votre commande</h2>
                        <div class="row">
                            <div class="col-md-6 text-left"> Produit</div>
                            <div class="col-md-4 text-right">Sous-total</div>
                            <hr>
                        </div>
                        <?php
                        if (!empty(session('panier'))) {
                        //        $target_dir = "../../assets/images/";
                        $nb_produit = 0;
                        $data= (session('panier'));
                        foreach ($data as $key => $value) {
                        ?>
                        <div class="row">
                            <input type="hidden" name="produit[]" value="<?= $data[$key]["id"] ?>">
                            <input type="hidden" name="qte[]" value="<?= $data[$key]["qte"] ?>">
                            <div class="col-md-6 text-left"><?= $data[$key]["nom"] ?> <span class="fw-bold fs-3">&cross; <?= $data[$key]["qte"] ?></span></div>
                            <div class="col-md-4 text-right"><?= $data[$key]["prix"] * $data[$key]["qte"] ?> CFA</div>
                            <hr>
                        </div>
                        <?php }
                        } else {
                            echo "<h2>Vous n'avez auccun produit dans le panier</h2>";
                        }
                        ?>

                        <div class="row">
                            <div class="col-md-6 text-left"> Sous-total</div>
                            <div class="col-md-4 text-right fw-bold">{{ (new \App\Models\Panier())->totalCartFromCard() }} CFA</div>
                            <hr>
                        </div>

                        <div class="row">
                            <div class="col-md-6 text-left d"> Total</div>
                            <div class="col-md-4 text-right fw-bold">{{ (new \App\Models\Panier())->totalCartFromCard() }}CFA</div>
                            <hr>
                        </div>

                        <h3>Paiement a la livraison</h3>
                        <td></td>

                        <h3>Payer en argent comptant a la livraison</h3>

{{--                        <p>your personnal data will be used to process your order , support your experience throughout this website,--}}
{{--                            and for other purposes described in our politique de confidentialité.</p>--}}

                        <div class="form-group">
                            <label for=""><input type="checkbox">  j'ai lu et j'accepte les conditions generales</label>
                        </div>
                        <div class="form-group">
                            <button type="submit"  class="btn  btn-block btn-lg btn-primary" >Commander</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>

    </div>
</div>
@endsection
@section('script')
@endsection
