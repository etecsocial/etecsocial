<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoPergunta extends Model {
    
    protected $table = 'grupo_pergunta';

    protected $fillable = [
        'id',
        'data',
        'id_user',
        'assunto',
        'tags',
        'pergunta',
        'id_autor'
    ];

}
