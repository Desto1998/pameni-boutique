<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pays extends Model
{
    use HasFactory;
    protected $primaryKey = 'pays_id';
    protected $fillable = [
        'nom_pays',
        'code_pays',
        'drapeau',
    ];
}
