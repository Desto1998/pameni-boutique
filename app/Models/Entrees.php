<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrees extends Model
{
    use HasFactory;
    protected $primaryKey = 'entre_id';
    protected $fillable = [
        'montant_entre',
        'raison_entre',
        'description_entre',
        'date_entre',
        'statut_entre',
        'iduser',
    ];
}
