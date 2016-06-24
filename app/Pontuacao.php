<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Pontuacao extends Model
{

    public static function pontuar($pontos, $motivo = '')
    {
        $pontuacao          = new Pontuacao;
        $pontuacao->pontos  = $pontos;
        $pontuacao->motivo  = $motivo;
        $pontuacao->user_id = auth()->user()->id;
        $pontuacao->save();
    }

    public static function total()
    {
        $pontuacao = DB::table('pontuacaos')
            ->selectRaw('sum(pontos) as pontos')
            ->where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'DESC')
            ->limit(1)
            ->get()[0]->pontos;
        return ($pontuacao == null) ? 0 : $pontuacao;
    }

    public static function ranking($tipo = 'geral')
    {
        switch ($tipo) {
            case 'etec': // @todo
                $pontuacao = DB::table('pontuacaos')
                    ->selectRaw('sum(pontos) as pontos, users.name, users.id, users.username')
                    ->join('users', 'users.id', '=', 'pontuacaos.user_id')
                    ->join('alunos_info', 'users.id', '=', 'alunos_info.user_id')
                    ->join('turmas', 'turmas.id', '=', 'alunos_info.turma_id')
                    ->join('escolas', 'escolas.id', '=', 'turmas.escola_id')
                    ->orderBy('pontos', 'DESC')
                    ->groupBy('users.id')
                    ->where('turmas.escola_id', auth()->user()->escola_id)
                    ->limit(100)
                    ->get();
                break;

            case 'turma': // @todo
                $pontuacao = DB::table('pontuacaos')
                    ->selectRaw('sum(pontos) as pontos, users.name, users.id, users.username')
                    ->join('users', 'users.id', '=', 'pontuacaos.user_id')
                    ->join('alunos_info', 'users.id', '=', 'alunos_info.user_id')
                    ->join('turmas', 'turmas.id', '=', 'alunos_info.turma_id')
                    ->join('escolas', 'escolas.id', '=', 'turmas.escola_id')
                    ->orderBy('pontos', 'DESC')
                    ->groupBy('users.id')
                    ->where('turmas.escola_id', auth()->user()->escola_id)
                    ->limit(100)
                    ->get();
                break;

            default:
                $pontuacao = DB::table('pontuacaos')
                    ->selectRaw('sum(pontos) as pontos, name, user_id, username')
                    ->join('users', 'users.id', '=', 'pontuacaos.user_id')
                    ->orderBy('pontos', 'DESC')
                    ->groupBy('user_id')
                    ->limit(100)
                    ->get();
        }
        return $pontuacao;
    }

}
