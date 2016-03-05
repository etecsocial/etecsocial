<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Pontuacao;
use App\User;

class DesafioController extends Controller
{
    public function index(){
    	return view('desafio.home');
    }

    public function ranking() {
    	$usuarios = Pontuacao::total_users();
    	
    	return view('desafio.ranking', ['usuarios' => $usuarios]);
    }
}
