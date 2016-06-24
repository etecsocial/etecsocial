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
        $pontuacao->id_user = auth()->user()->id;
        $pontuacao->save();
    }

    public static function total()
    {
        $pontuacao = DB::table('pontuacaos')
            ->selectRaw('sum(pontos) as pontos')
            ->where('id_user', auth()->user()->id)
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
                    ->join('users', 'users.id', '=', 'pontuacaos.id_user')
                    ->join('alunos_info', 'users.id', '=', 'alunos_info.id_user')
                    ->join('turmas', 'turmas.id', '=', 'alunos_info.id_turma')
                    ->join('escolas', 'escolas.id', '=', 'turmas.id_escola')
                    ->orderBy('pontos', 'DESC')
                    ->groupBy('users.id')
                    ->where('turmas.id_escola', auth()->user()->id_escola)
                    ->limit(100)
                    ->get();
                break;

            case 'turma': // @todo
                $pontuacao = DB::table('pontuacaos')
                    ->selectRaw('sum(pontos) as pontos, users.name, users.id, users.username')
                    ->join('users', 'users.id', '=', 'pontuacaos.id_user')
                    ->join('alunos_info', 'users.id', '=', 'alunos_info.id_user')
                    ->join('turmas', 'turmas.id', '=', 'alunos_info.id_turma')
                    ->join('escolas', 'escolas.id', '=', 'turmas.id_escola')
                    ->orderBy('pontos', 'DESC')
                    ->groupBy('users.id')
                    ->where('turmas.id_escola', auth()->user()->id_escola)
                    ->limit(100)
                    ->get();
                break;

            default:
                $pontuacao = DB::table('pontuacaos')
                    ->selectRaw('sum(pontos) as pontos, name, id_user, username')
                    ->join('users', 'users.id', '=', 'pontuacaos.id_user')
                    ->orderBy('pontos', 'DESC')
                    ->groupBy('id_user')
                    ->limit(100)
                    ->get();
        }
        return $pontuacao;
    }

}
