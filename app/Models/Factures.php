<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factures extends Model
{
    use HasFactory;

    protected $primaryKey = 'facture_id';
    protected $fillable = [

        'reference_fact',
        'date_fact',
        'statut',
        'idclient',
        'objet',
        'disponibilite',
        'garentie',
        'condition_financiere',
        'tva_statut',
        'iduser',
        'iddevis'
    ];
}
