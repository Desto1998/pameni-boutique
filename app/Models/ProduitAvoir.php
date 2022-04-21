<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduitAvoir extends Model
{
    use HasFactory;
    protected $table = 'produit_avoir';
    protected $primaryKey = 'produit_avoir_id';
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
