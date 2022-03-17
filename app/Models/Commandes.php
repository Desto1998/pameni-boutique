<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commandes extends Model
{
    use HasFactory;
    protected $primaryKey = 'commande_id';
    protected $fillable = [
        'reference_commande',
        'date_commande',
        'statut',
        'idfournisseur',
        'service',
        'direction',
        'mode_paiement',
        'condition_paiement',
        'delai_liv',
        'observation',
        'note',
        'lieu_liv',
        'tva_statut',
        'iduser',

    ];
}
