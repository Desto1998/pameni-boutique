<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charges extends Model
{
    use HasFactory;
    protected $primaryKey = 'charge_id';
    protected $fillable = [
        'titre',
        'description',
        'description_cat',
        'iduser',
    ];
}
