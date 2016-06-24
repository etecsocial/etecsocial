<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoPergunta extends Model
{

    protected $table = 'grupo_pergunta';

    protected $fillable = [
        'id',
        'data',
        'user_id',
        'assunto',
        'tags',
        'pergunta',
        'autor_id',
    ];

}
