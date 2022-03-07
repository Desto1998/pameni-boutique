<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseurs extends Model
{
    use HasFactory;
    protected $primaryKey = 'fournisseur_id';
    protected $fillable = [
        'raison_s_fr',
        'nom_fr',
        'prenom_fr',
        'type_fr',
        'email_fr',
        'phone_1_fr',
        'phone_2_fr',
        'idpays',
        'ville_fr',
        'adresse_fr',
        'logo_fr',
        'date_ajout_fr',
        'contribuable',
        'slogan',
        'siteweb',
        'rcm',
        'postale',
        'iddevise',
        'iduser',
    ];
}
