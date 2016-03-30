<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Pontuacao;
use App\User;
use App\Mensagens;

class DesafioController extends Controller
{
    public function index(){
    	return view('desafio.home')->with(['thisUser' => auth()->user(), 'msgsUnread' => Mensagens::countUnread()]);
    }

    public function geral() {
    	$usuarios = Pontuacao::ranking();
    	
    	return view('desafio.ranking', ['usuarios' => $usuarios, 'tipo' => 'Ranking de todas as ETEC'])->with(['thisUser' => auth()->user(), 'msgsUnread' => Mensagens::countUnread()]);
    }

    public function etec() {
    	$usuarios = Pontuacao::ranking('etec');
    	
    	return view('desafio.ranking', ['usuarios' => $usuarios, 'tipo' => 'Ranking de toda a sua ETEC'])->with(['thisUser' => auth()->user(), 'msgsUnread' => Mensagens::countUnread()]);
    }

    public function turma() {
    	$usuarios = Pontuacao::ranking('turma');
    	
    	return view('desafio.ranking', ['usuarios' => $usuarios, 'tipo' => 'Ranking da sua turma'])->with(['thisUser' => auth()->user(), 'msgsUnread' => Mensagens::countUnread()]);
    }
}
