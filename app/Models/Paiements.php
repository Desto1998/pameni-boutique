<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiements extends Model
{
    use HasFactory;
    protected $primaryKey = 'paiement_id';
    protected $fillable = [
        'mode',
        'date_paiement',
        'description',
        'montant',
        'statut',
        'idcommande',
        'iddevis',
        'idfacture',
        'iduser',
    ];
}
