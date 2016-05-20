<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pontuacao extends Model {

    public static function pontuar($pontos, $motivo = '') {
        $pontuacao = new Pontuacao;
        $pontuacao->pontos = $pontos;
        $pontuacao->motivo = $motivo;
        $pontuacao->user_id = auth()->user()->id;
        $pontuacao->save();
    }

    public static function total() {
        $pontuacao = DB::table('pontuacaos')
                        ->selectRaw('sum(pontos) as pontos')
                        ->where('user_id', auth()->user()->id)
                        ->orderBy('created_at', 'DESC')
                        ->limit(1)
                        ->get()[0]->pontos;
        return ($pontuacao == null) ? 0 : $pontuacao;
    }

    public static function ranking($tipo = 'geral') {
        switch ($tipo) {
            case 'etec':
                $pontuacao = DB::table('pontuacaos')
                        ->selectRaw('sum(pontos) as pontos, nome, user_id, username')
                        ->join('users', 'users.id', '=', 'pontuacaos.user_id')
                        ->orderBy('pontos', 'DESC')
                        ->groupBy('user_id')
                        ->where('users.id_escola', auth()->user()->id_escola)
                        ->limit(100)
                        ->get();
                break;

            case 'turma':
                $pontuacao = DB::table('pontuacaos')
                        ->selectRaw('sum(pontos) as pontos, nome, user_id, username')
                        ->join('users', 'users.id', '=', 'pontuacaos.user_id')
                        ->where('users.id_escola', auth()->user()->id_escola)
                        ->where('users.id_turma', auth()->user()->id_turma)
                        ->orderBy('pontos', 'DESC')
                        ->groupBy('user_id')
                        ->limit(50)
                        ->get();
                break;

            default:
                $pontuacao = DB::table('pontuacaos')
                        ->selectRaw('sum(pontos) as pontos, nome, user_id, username')
                        ->join('users', 'users.id', '=', 'pontuacaos.user_id')
                        ->orderBy('pontos', 'DESC')
                        ->groupBy('user_id')
                        ->limit(100)
                        ->get();
        }
        return $pontuacao;
    }

}
