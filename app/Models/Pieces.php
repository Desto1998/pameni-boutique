<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pieces extends Model
{
    use HasFactory;
    protected $primaryKey = 'piece_id';
    protected $fillable = [
        'ref',
        'chemin',
        'remise',
        'idcommande',
        'iddevis',
        'idfacture',
        'date_piece',
        'iduser',
    ];
}
