<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfessoresInfo extends Model {

    protected $table = 'professores_info';
    protected $fillable = [
        'user_id',
        'escola_id',
        'profile_photo',
        'status',
        'cidade',
        'formacao',
        'email',
        'livro',
        'filme',
        'materia',
    ];

    /**
     * @return \Iluminate\Database\Elequoment\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('App\User');
    }
    
        //para professores
    public function escolas() {
        return $this->hasMany('App\Escola');
    }


}
