<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mailjet\Request;

class Factures extends Model
{
    use HasFactory;

    protected $primaryKey = 'facture_id';
    protected $fillable = [

        'reference_fact',
        'date_fact',
        'statut',
        'idclient',
        'objet',
        'disponibilite',
        'garentie',
        'condition_financiere',
        'tva_statut',
        'iduser',
        'iddevis',
        'type_fact'
    ];

    public static function montantHT($id){
        $pocedes = Produit_Factures::leftJoin('produits', 'produits.produit_id', 'produit_factures.idproduit')->where('idfacture', $id)->get();
        $montantHT = 0;

        foreach ($pocedes as $p) {

            $remise = ($p->prix * $p->quantite * $p->remise) / 100;
            $montant = ($p->quantite * $p->prix) - $remise;
            $montantHT += $montant;

        }
        return number_format($montantHT, 2, '.', '');
    }

    public static function montantTotal($id){
        $data = Factures::join('clients', 'clients.client_id', 'factures.idclient')
            ->join('users', 'users.id', 'factures.iduser')
            ->where('facture_id', $id)
            ->get()
        ;
        if ($data[0]->type_fact===2) {
            $pocedes = Produit_Factures::where('idfacture', $id)->get();
        }else{
            $pocedes = Produit_Factures::join('produits', 'produits.produit_id', 'produit_factures.idproduit')->where('idfacture', $id)->get();
        }
//        $pocedes = Produit_Factures::join('produits', 'produits.produit_id', 'produit_factures.idproduit')->where('idfacture', $id)->get();
        $montantTVA = 0;
        foreach ($pocedes as $p) {

            $remise = ($p->prix * $p->quantite * $p->remise) / 100;
            $montant = ($p->quantite * $p->prix) - $remise;
            $tva = ($montant * $p->tva) / 100;
            $montant = $tva + $montant;
//                        $montant += (($montant * 19.25)/100)+$montant;
            $montantTVA += $montant;

        }
        if ($data[0]->tva_statut == 1) {
            $montantTTC = (float)(new Taxe())->ApplyTVA($montantTVA) + number_format($montantTVA, 2, '.', '');
        } elseif ($data[0]->tva_statut == 2) {
            $montantTTC = (float)(new Taxe())->ApplyIS($montantTVA) + number_format($montantTVA, 2, '.', '');
        }else {
            $montantTTC =  number_format($montantTVA, 2, '.', '');
        }

        return $montantTTC;
    }

    public static function Payer($id){
        $paye = Paiements::where('idfacture', $id)->sum('montant');
        return $paye;
    }

    public static function produitFacture($id){
        return Produit_Factures::leftJoin('produits', 'produits.produit_id', 'produit_factures.idproduit')->where('idfacture', $id)->get();
    }

    public static function totalAvoir($id)
    {
        $data = Avoirs::where('idfacture', $id)
            ->get();
        $total =0;
        foreach ($data as $item){
            $pocedes = (new ProduitAvoir)->produitFAvoir($item->avoir_id);
            $montantHT = 0;
            foreach ($pocedes as $p) {
                $remise = ($p->prix * $p->quantite * $p->remise) / 100;
                $montant = ($p->quantite * $p->prix) - $remise;
                $montantHT += $montant;
            }
            if ($data[0]->tva_statut == 1) {
                $total += (float)(new Taxe())->ApplyTVA($montantHT) + number_format($montantHT, 2, '.', '');
            } elseif ($data[0]->tva_statut == 2) {
                $total += (float)(new Taxe())->ApplyIS($montantHT) + number_format($montantHT, 2, '.', '');
            }else {
                $total +=  number_format($montantHT, 2, '.', '');
            }
        }
        return $total;
    }
}
