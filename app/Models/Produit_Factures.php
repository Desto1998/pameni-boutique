<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit_Factures extends Model
{
    use HasFactory;

    protected $table = 'produit_factures';
    protected $primaryKey = 'produit_f_id';
    protected $fillable = [
        'quantite',
        'prix',
        'remise',
        'tva',
        'num_serie',
        'idfacture',
        'idproduit',
        'iduser',
    ];
}
