<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduitBon extends Model
{
    use HasFactory;
    protected $table = 'produit_bon';
    protected $primaryKey = 'produitbon_id';
    protected $fillable =[
        'quantite',
        'prix',
        'remise',
        'tva',
        'idbonlivraison',
        'idproduit',
        'iduser',
        'reference_bon',
        'titre_bon',
        'description_bon',
    ];

    public static function produitBon($id)
    {
        return ProduitBon::join('produits','produits.produit_id','produit_bon.idproduit')->where('idbonlivraison',$id)->get();
    }
}
