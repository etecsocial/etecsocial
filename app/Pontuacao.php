<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pontuacao extends Model
{
    public static function pontuar($pontos, $motivo = '', $user_id = 0)
    {
        if ($user_id == 0) {
            $user_id = auth()->user()->id;
        }

        $pontuacao = new self();
        $pontuacao->pontos = $pontos;
        $pontuacao->motivo = $motivo;
        $pontuacao->user_id = $user_id;
        $pontuacao->save();
    }

    public static function total()
    {
        $pontuacao = Pontuacao::selectRaw('sum(pontos) as pontos')
            ->where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'DESC')
            ->first();
            
        return ($pontuacao->pontos == null) ? 0 : $pontuacao->pontos;
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
