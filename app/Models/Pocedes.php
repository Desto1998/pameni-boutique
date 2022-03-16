<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pocedes extends Model
{
    use HasFactory;
    protected $primaryKey = 'pocede_id';
    protected $fillable = [
        'quantite',
        'prix',
        'remise',
        'tva',
        'num_serie',
        'iddevis',
        'idproduit',
        'iduser',
    ];
}
