<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comportes extends Model
{
    use HasFactory;
    protected $primaryKey = 'comporte_id';
    protected $fillable = [
        'quantite',
        'prix',
        'remise',
        'tva',
        'idcommande',
        'idproduit',
        'iduser',
    ];
}
