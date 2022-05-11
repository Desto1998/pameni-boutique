<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonLivraison extends Model
{
    use HasFactory;
    protected $table = 'bon_livraisons';
    protected $primaryKey = 'bonlivraison_id';
    protected $fillable =[
        'reference_bl',
        'objet',
        'date_bl',
        'statut',
        'iddevis',
        'idfacture',
        'delai_liv',
        'lieu_liv',
        'iduser',
    ];

    public function getProduit($id){
        $bon = BonLivraison::find($id);
        $produits = [];
        if (!empty($bon->iddevis)) {
            $produits = Pocedes::join('produits','produits.produit_id','pocedes.idproduit')->where('iddevis',$bon->iddevis)->get();
        }
        if (!empty($bon->idfacture)) {
            $produits = Produit_Factures::join('produits','produits.produit_id','produit_factures.idproduit')->where('idfacture',$bon->idfacture)->get();
        }
        return $produits;
    }
}
