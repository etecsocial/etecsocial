<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class PoliticaController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $dados = DB::table('alunos_pfa')->where('rm', $request->rm)->first();
        
        $nomes = explode(' ', $dados->nome);
        $nome = ucfirst(strtolower($nomes[0])) . ' ' . ucfirst(strtolower($nomes[count($nomes)]));
        $username = strtolower($nomes[0] . $nomes[count($nomes)]);
        $senha = str_random(30);
        
        $info_academica = NULL;
        
        User::create([
            'email'             => $dados->email,
            'tipo'              => 1,
            'password'          => bcrypt($senha),
            'username'          => $username,
            'nasc'              => $dados->nasc, 
            'nome'              => $nome,
            'info_academica'    => $info_academica,
            'confirmed'         => 1,
            'confirmation_code' => NULL
        ]);
    }
}
