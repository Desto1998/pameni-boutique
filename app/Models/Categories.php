<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $primaryKey = 'categorie_id';
    protected $fillable = [
        'titre_cat',
        'code_cat',
        'description_cat',
        'iduser',
    ];
}
