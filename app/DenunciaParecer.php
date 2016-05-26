<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DenunciaParecer extends Model
{

    protected $table    = 'denuncia_parecer';
    protected $fillable = [
        'id_post',
        'id_denuncia',
        'excluir',
        'parecer',
    ];

}
