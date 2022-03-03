<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    use HasFactory;
    protected $primaryKey = 'devis_id';
    protected $fillable = [
        'reference_devis',
        'date_devis',
        'statut',
        'idclient',
        'validite',
        'objet',
        'disponibilite',
        'garentie',
        'condition_financiere',
        'iduser',

    ];
}
