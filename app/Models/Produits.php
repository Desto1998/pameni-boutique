<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produits extends Model
{
    use HasFactory;
    protected $table = 'produits';
    protected $primaryKey = 'id';
    protected $fillable = ['nom','quantite','prix','description','image','idcat'];
}
