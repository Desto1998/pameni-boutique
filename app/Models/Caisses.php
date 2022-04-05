<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caisses extends Model
{
    use HasFactory;
    protected $primaryKey = 'caisse_id';
    protected $fillable = [
        'montant',
        'raison',
        'date_depot',
        'description',
        'iduser',
        'idtache',
        'identre',
        'type_operation',
    ];
}
