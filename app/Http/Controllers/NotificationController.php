<?php

namespace App\Http\Controllers;

use App\Models\Commandes;
use App\Models\Devis;
use App\Models\Factures;
use App\Models\Paiements;
use App\Models\Produit_Factures;
use App\Models\Produits;
use App\Models\Taches;
use DateInterval;
use DateTime;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    //
    public function notify(Request $request)
    {
        $data = [];
        $data1 = "";
        if ($request->ajax()) {
            $time = date('H:i');
            $factures = Factures::all();
            $devisNV = Devis::all();
            $commandes = Commandes::all();
            $commandesV = Commandes::where('statut', 1)->get();
            $factureNV = Factures::where('statut', 0)->get();
            $paye = Paiements::all();
            $factID = [];
            $compt = 0;

            // Ici on calcul le montant total des charges du jmois dernier. Chaque 1er du mois
            if (date('d') == 1) {
                $tache = Taches::whereMonth('created_at', (int)date('m') - 1)
                    ->whereYear('created_at', date('Y'))
                    ->get();;
                $mont = 0;
                foreach ($tache as $t) {
                    $mont += $t->prix * $t->nombre;
                }
                $data1 .= "<li class=\"media dropdown-item\" title=\"Vos avez dépensé $mont F CFA pour les charges de l'entreprise le mois dernier.\">
                      <span class=\"lightSpeedIn\"><i class=\"fa fa-dollar\"></i></span>
                      <div class=\"media-body\">
                      <a href=\"#\">
                      <p>Vos avez dépensé:<strong> $mont F CFA</strong> <strong> pour les charges de l'entreprise le mois dernier.</strong>

                      </p>
                      </a>
                      </div>
                      <span class=\"notify-time\">$time</span>
                      </li>";
                $compt++;

            }

//            $updateP[$key] = Produits::where('produit_id',$value->idproduit)->update(['quantite_produit'=>DB::raw('quantite_produit + '.$value->quantite)]);
//            $lastNum = Commandes::whereYear('created_at', date('Y'))
//                ->whereRaw('commande_id = (select max(`commande_id`) from commandes)')
//                ->get();


//        $date->sub(new DateInterval('P1D'));
            // ici on affiche les notifications pour les commandes qui doivent etre livre damns 3 jours
            foreach ($commandes as $cm) {
                $date = new DateTime($cm->date_commande);
                $nbjour = (int)$cm->delai_liv - 3;
                $date->add(new DateInterval("P{$nbjour}D"));
                $date = date("Y-m-d", strtotime($date->format('Y-m-d')));
                $date2 = new DateTime(date('Y-m-d'));
                if ($date2 >= $date) {
                    $link = route('commandes.view', ['id' => $cm->commande_id]);
                    $ref = $cm->reference_commande;
                    $data1 .= "<li class=\"media dropdown-item\" title=\"La commande N: $ref  doit se livrer dans moins de 3 jours.\">
                      <span class=\"primary\"><i class=\"fa fa-database\"></i></span>
                      <div class=\"media-body\">
                      <a href=\"$link\">
                      <p><strong>La commande N: $ref </strong> <strong> doit se livrer dans moins de 3 jours.</strong>

                      </p>
                      </a>
                      </div>
                      <span class=\"notify-time\">$time</span>
                      </li>";
                    $compt++;
                }
            }
            $date = new DateTime(date('Y-m-d'));
            $nbjour = 3;
            $date->add(new DateInterval("P{$nbjour}D"));
            $date = date("Y-m-d", strtotime($date->format('Y-m-d')));
            $devisSF = Devis::where('echeance', '<=', $date)
                ->where('statut', '=', 1)
                ->whereRaw('devis_id not in (select iddevis from factures)')
                ->get();

            // Ici on affiche les devis sans facture dont la valitite expire dans 2 jours
            foreach ($devisSF as $d => $sf) {
                $link = route('devis.view', ['id' => $sf->devis_id]);
                $ref = $sf->reference_devis;
                $data1 .= "<li class=\"media dropdown-item\" title=\"Le devis N: $ref  expire bientot et n'a pas de facture.\">
                      <span class=\"dark\"><i class=\"fa fa-database\"></i></span>
                      <div class=\"media-body\">
                      <a href=\"$link\">
                      <p><strong>Le devis N: $ref </strong> <strong> expire bientot et n'a pa de facture.</strong>

                      </p>
                      </a>
                      </div>
                      <span class=\"notify-time\">$time</span>
                      </li>";
                $compt++;
            }
            // Ici on affiche les facture qui ont ete valide mais qui n'ont pas ete soldee
            foreach ($factures as $f => $fact) {
                $dejapayer = 0;

                if ($fact->statut >= 1) {
                    $pocedes = Produit_Factures::join('produits', 'produits.produit_id', 'produit_factures.idproduit')->where('idfacture', $fact->facture_id)->get();
                    $montantTVA = 0;
                    $montantTTC = 0;
                    foreach ($pocedes as $p) {

                        $remise = ($p->prix * $p->quantite * $p->remise) / 100;
                        $montant = ($p->quantite * $p->prix) - $remise;
                        $tva = ($montant * $p->tva) / 100;
                        $montant = $tva + $montant;
//                        $montant += (($montant * 19.25)/100)+$montant;
                        $montantTVA += $montant;

                    }
                    if ($fact->tva_statut == 1) {
                        $montantTTC = (($montantTVA * 19.25) / 100) + $montantTVA;
                    } else {
                        $montantTTC = $montantTVA;
                    }
                    foreach ($paye as $p) {
                        if ($p->idfacture === $fact->facture_id) {
                            $dejapayer += $p->montant;
                        }
                    }

                    if ($dejapayer < $montantTTC) {
                        $factID[$f] = $fact;
                        $link = route('factures.view', ['id' => $fact->facture_id]);
                        $ref = $fact->reference_fact;
                        $data1 .= "<li class=\"media dropdown-item\" title='La facture N: $ref est non soldée'>
                      <span class=\"danger\"><i class=\"fa fa-file\"></i></span>
                      <div class=\"media-body\">
                      <a href=\"$link\">
                      <p><strong>la facture N: $ref </strong> <strong>est non soldée</strong>

                      </p>
                      </a>
                      </div>
                      <span class=\"notify-time\">$time</span>
                      </li>";
                        $compt++;
                    }

                }
            }

            // Ici on fait les notifications pour les produits dont la quantite en stock est inferieur a 3
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

            if (count($stock) > 0) {
                $link = route('produit.all');
                $data1 .= "<li class=\"media dropdown-item\">
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
                $compt++;
            }
            $data[0] = $data1;
            $data[1] = $compt;
            return Response()->json($data);
        }
        return Response()->json($data);
    }
}
