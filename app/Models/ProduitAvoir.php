<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduitAvoir extends Model
{
    use HasFactory;
    protected $table = 'produit_avoir';
    protected $primaryKey = 'produitavoir_id';
    protected $fillable =[
        'quantite',
        'prix',
        'remise',
        'tva',
        'idbonlivraison',
        'idproduit',
        'iduser',
        'idavoir',
    ];

    public function produitFAvoir($id)
    {
        return ProduitAvoir::join('produits','produits.produit_id','produit_avoir.idproduit')->where('idavoir',$id)->get();
    }
}
