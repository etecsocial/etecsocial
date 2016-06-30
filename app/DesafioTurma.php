<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DesafioTurma extends Model
{
    
    /**
     * @return \Iluminate\Database\Elequoment\Relations\BelongsTo
     */
    public function turma() {
        return $this->belongsTo('App\Turma');
    }
}
