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
        'iddevis'
    ];

    public function montantHT($id){
        $pocedes = Produit_Factures::join('produits', 'produits.produit_id', 'produit_factures.idproduit')->where('idfacture', $id)->get();
        $montantHT = 0;

        foreach ($pocedes as $p) {

            $remise = ($p->prix * $p->quantite * $p->remise) / 100;
            $montant = ($p->quantite * $p->prix) - $remise;
            $montantHT += $montant;

        }
        return number_format($montantHT, 2, '.', '');
    }

    public function montantTotal($id){
        $data = Factures::join('clients', 'clients.client_id', 'factures.idclient')
            ->join('users', 'users.id', 'factures.iduser')
            ->where('facture_id', $id)
            ->get()
        ;
        $pocedes = Produit_Factures::join('produits', 'produits.produit_id', 'produit_factures.idproduit')->where('idfacture', $id)->get();
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

    public function Payer($id){
        $paye = Paiements::where('idfacture', $id)->sum('montant');
        return $paye;
    }

    public function produitFacture($id){
        return Produit_Factures::join('produits', 'produits.produit_id', 'produit_factures.idproduit')->where('idfacture', $id)->get();
    }

}
