<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaires extends Model
{
    use HasFactory;
    protected $primaryKey = 'commentaire_id';
    protected $fillable = [
        'reference_commande',
        'message',
        'date_commentaire',
        'statut_commentaire',
        'idcommande',
        'iddevis',
        'idfacture',
        'iduser',
        'idbonlivraison',
        'idfactured',
        'idavoir',
        'idproformat',
    ];
}
