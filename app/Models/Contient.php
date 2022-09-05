<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contient extends Model
{
    use HasFactory;
    protected $table = 'contient';
    protected $primaryKey = 'idcontient';
    protected $fillable = ['qte','idproduit','idcommande'];

}
