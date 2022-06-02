<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proformats extends Model
{
    use HasFactory;

    protected $table = 'proformats';
    protected $primaryKey = 'proformat_id';
    protected $fillable = [
        'reference_pro',
        'date_pro',
        'statut',
        'tva_statut',
        'idclient',
        'objet',
        'disponibilite',
        'garentie',
        'condition_financiere',
        'date_paie',
        'echeance',
        'iduser',
    ];
}
