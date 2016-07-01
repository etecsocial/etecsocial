<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class RankingController extends Controller
{
  public function geral()
  {
      $usuarios = Pontuacao::ranking();

      return view('desafio.ranking', ['usuarios' => $usuarios, 'tipo' => 'Ranking de todas as ETEC']);
  }

  public function etec()
  {
      $usuarios = Pontuacao::ranking('etec');

      return view('desafio.ranking', ['usuarios' => $usuarios, 'tipo' => 'Ranking de toda a sua ETEC']);
  }

  public function turma()
  {
      $usuarios = Pontuacao::ranking('turma');

      return view('desafio.ranking', ['usuarios' => $usuarios, 'tipo' => 'Ranking da sua turma']);
  }
}
