<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;

class PoliticaController extends Controller
{    

    public function index(Request $request) // @no use
    {
        $dados = DB::table('alunos_pfa')->where('rm', $request->rm)->first();
        
        $nomes = explode(' ', $dados->nome);
        $nome = ucfirst(strtolower($nomes[0])) . ' ' . ucfirst(strtolower($nomes[count($nomes)]));
        $username = strtolower($nomes[0] . $nomes[count($nomes)]);
        $senha = str_random(30);
        
        User::create([
            'email'             => $dados->email,
            'tipo'              => 1,
            'password'          => bcrypt($senha),
            'username'          => $username,
            'birthday'        => $dados->birthday, 
            'nome'              => $nome,
            'confirmed'         => 1,
            'confirmation_code' => NULL
        ]);
    }

    protected function convert_name($name){
        return ucwords(strtolower($name));
    }

    public function get_aluno_info(Request $request){ // checar segurança disso daqui
        $aluno = DB::table('alunos_pfa')->where('rm', $request->rm)->first();
        if($aluno){
            return response()->json($aluno);
        } else {
            return response('Nenhum aluno com o rm ' . $request->rm . ' encontrado');
        }
    }
}
