<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit_Divers extends Model
{
    use HasFactory;

    protected $table = 'produit_divers';
    protected $primaryKey = 'pdivers_id';
    protected $fillable = [
        'reference_pp',
        'titre_produit',
        'description_produit',
        'quantite',
        'prix',
        'remise',
        'tva',
        'num_serie',
        'idproformat',
        'idfactured',
        'iduser',
    ];
}
