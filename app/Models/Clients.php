<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;
    protected $primaryKey = 'client_id';
    protected $fillable = [
        'raison_s_client',
        'email_client',
        'prenom_client',
        'nom_client',
        'type_client',
        'phone_1_client',
        'phone_2_client',
        'idpays',
        'ville_client',
        'adresse_client',
        'logo_client',
        'date_ajout',
        'contribuable',
        'slogan',
        'siteweb',
        'rcm',
        'note',
        'postale',
        'iddevise',
        'iduser',
    ];
}
