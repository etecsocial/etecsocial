<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DenunciaGrupo extends Model
{
    protected $table    = 'denuncias_grupo';
    protected $fillable = [
        'tipo',
        'id_pub',
        'denuncia',
        'data',
    ];

}
