<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log_P_Factures extends Model
{
    use HasFactory;

    protected $primaryKey = 'log_pf_id';
    protected $table = 'log_p_factures';
    protected $fillable = [
        'log_quantite',
        'log_prix',
        'log_remise',
        'log_tva',
        'log_num_serie',
        'log_idf',
        'log_idpf',
        'log_idproduit',
        'log_iduser',
    ];
}
