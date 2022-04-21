<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avoirs extends Model
{
    use HasFactory;
    protected $primaryKey = 'avoir_id';
    protected $fillable =[
        'reference_avoir',
        'objet',
        'date_avoir',
        'statut',
        'tva_statut',
        'idfacture',
        'service',
        'direction',
        'mode_paiement',
        'condition_paiement',
        'delai_liv',
        'observation',
        'note',
        'lieu_liv',
        'iduser',
    ];
}
