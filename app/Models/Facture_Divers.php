<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture_Divers extends Model
{
    use HasFactory;

    protected $table = 'facture_divers';
    protected $primaryKey = 'fd_id';
    protected $fillable = [
        'reference_fd',
        'date_fd',
        'statut',
        'tva_statut',
        'idclient',
        'objet',
        'disponibilite',
        'garentie',
        'condition_financiere',
        'iduser',
        'idproformat',
    ];
}
