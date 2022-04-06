<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taches extends Model
{
    use HasFactory;
    protected $primaryKey = 'tache_id';
    protected $fillable = [
        'date_debut',
        'date_fin',
        'date_ajout',
        'raison',
        'iduser',
        'statut',
        'idcharge',
        'prix',
        'nombre',
    ];
}
