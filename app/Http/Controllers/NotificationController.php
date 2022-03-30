<?php

namespace App\Http\Controllers;

use App\Models\Commandes;
use App\Models\Devis;
use App\Models\Factures;
use App\Models\Paiements;
use App\Models\Produit_Factures;
use App\Models\Produits;
use http\Env\Response;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //
    public function notify(Request $request)
    {
        $data = [];
        if ($request->ajax()) {
            $factures = Factures::all();
            $devisNV = Devis::where('statut', 0)->get();
            $commandesNV = Commandes::where('statut', 0)->get();
            $factureNV = Factures::where('statut', 0)->get();
            $paye = Paiements::all();
            $factID = [];
            $produit = Produits::all();
            $proFact = Produit_Factures::all();
            $prodID = [];
            foreach ($produit as $key => $item) {
                $use = 0;
                foreach ($proFact as $pf) {
                    if ($pf->idproduit == $item->produit_id) {
                        $use += $pf->quantite;
                    }
                }
                if ($item->quantite_produit - $use <= 3) {
                    $prodID[$item->produit_id] = $item->produit_id;
                }
            }
            $stock = Produits::whereIn('produit_id', $prodID)->get();
            $nbstock = count($stock);
            $time = date('H:i:s');
            if (count($stock)>0) {
                $link = route('produit.all');
                $data[0] = "<li class=\"media dropdown-item\">
                      <span class=\"success\"><i class=\"fa fa-product-hunt\"></i></span>
                      <div class=\"media-body\">
                      <a href=\"$link\">
                      <p><strong>Stock: </strong> <strong>$nbstock</strong>
                           produits en rupture de stock
                      </p>
                      </a>
                      </div>
                      <span class=\"notify-time\">$time</span>
                      </li>";
            }
            return Response()->json($data);
        }
        return Response()->json($data);
    }
}
