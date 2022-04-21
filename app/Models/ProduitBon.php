<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduitBon extends Model
{
    use HasFactory;
    protected $table = 'produit_bon';
    protected $primaryKey = 'produit_bon_id';
    protected $fillable =[
        'quantite',
        'prix',
        'remise',
        'tva',
        'idbonlivraison',
        'idproduit',
        'iduser',
    ];
}
