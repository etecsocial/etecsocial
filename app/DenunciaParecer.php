<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DenunciaParecer extends Model
{

    protected $table    = 'denuncia_parecer';
    protected $fillable = [
        'post_id',
        'denuncia_id',
        'excluir',
        'parecer',
    ];

}
