<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produits extends Model
{
    use HasFactory;

    protected $primaryKey = 'produit_id';
    protected $fillable = [
        'reference',
        'titre_produit',
        'description_produit',
        'quantite_produit',
        'prix_produit',
        'idcategorie',
        'iduser',
    ];
}
