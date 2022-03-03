<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complements extends Model
{
    use HasFactory;
    protected $primaryKey = 'complement_id';
    protected $fillable = [
        'quantite',
        'prix',
        'iduser',
        'iddevis',
        'idproduit',
    ];
}
