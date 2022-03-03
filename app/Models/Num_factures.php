<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Num_factures extends Model
{
    use HasFactory;
    protected $primaryKey = 'idnum_facture';
    protected $fillable = [
        'numero',
        'date_num',
        'iddevis',
        'iduser',
    ];
}
