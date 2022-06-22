<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxe extends Model
{
    use HasFactory;
    public static function ApplyTVA($montant)
    {
       $tva =  ($montant* 19.25)/100;
//       $tva += $montant;
       return number_format($tva ,2,'.','');
    }
    public static function ApplyIS($montant)
    {
       $tva =  ($montant* 5.5)/100;
//       $tva += $montant;
       return number_format($tva ,2,'.','');
    }
}
