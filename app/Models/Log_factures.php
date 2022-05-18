<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log_factures extends Model
{
    use HasFactory;

    protected $primaryKey = 'log_f_id';
    protected $table = 'log_factures';
    protected $fillable = [
        'log_date_fact',
        'log_statut',
        'log_tva_statut',
        'log_idclient',
        'log_objet',
        'log_disponibilite',
        'log_garentie',
        'log_condition_financiere',
        'log_iduser',
        'log_idfacture',
        'iduser',
    ];
}
