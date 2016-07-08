<?php

namespace App\Http\Controllers;

use App\Pontuacao;
use App\Turma;
use DB;

class RankingController extends Controller
{
    public function geral()
    {
        $usuarios = Pontuacao::selectRaw('sum(pontos) as pontos, pontuacaos.user_id')
                          ->orderBy('pontos', 'DESC')
                          ->limit(100)
                          ->get();

        return view('desafio.ranking', ['usuarios' => $usuarios, 'tipo' => 'Ranking de todas as ETEC']);
    }

    public function etec()
    {
        if(auth()->user()->turma != null){
            $turma_id = auth()->user()->turma->turma_id;
            $escola_id = Turma::select('escola_id')->where('id', $turma_id)->first()->escola_id;
        } else {
            $escola_id = auth()->user()->profInfo->escola_id;
        }

        DB::statement(DB::raw('set @position:=0')); // numero da posição

        $usuarios = Pontuacao::selectRaw('@position:=@position+1 as position, sum(pontos) as pontos, pontuacaos.user_id')
                          ->join('alunos_turma', 'pontuacaos.user_id', '=', 'alunos_turma.user_id')
                          ->join('turmas', 'alunos_turma.turma_id', '=', 'turmas.id')
                          ->orderBy('pontos', 'DESC')
                          ->where('turmas.escola_id', $escola_id)
                          ->limit(100)
                          ->get();

        return view('desafio.ranking', ['usuarios' => $usuarios, 'tipo' => 'Ranking de toda a sua ETEC']);
    }

    public function turma()
    {
        if(auth()->user()->turma != null){
          $turma_id = auth()->user()->turma->turma_id;
        } else {
          return "Não é possível visualizar turma por turma, veja o ranking geral de sua escola";
        }
        DB::statement(DB::raw('set @position:=0')); // numero da posição

        $usuarios = Pontuacao::selectRaw('@position:=@position+1 as position, sum(pontos) as pontos, pontuacaos.user_id')
                          ->join('alunos_turma', 'pontuacaos.user_id', '=', 'alunos_turma.user_id')
                          ->orderBy('pontos', 'DESC')
                          ->where('alunos_turma.turma_id', $turma_id)
                          ->limit(50)
                          ->get();

        return view('desafio.ranking', ['usuarios' => $usuarios, 'tipo' => 'Ranking da sua turma']);
    }
}
