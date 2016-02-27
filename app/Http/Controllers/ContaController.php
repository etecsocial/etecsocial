<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Escola;
use App\Turma;
use App\User;
use Response;
use Input;
use Auth;

class ContaController extends Controller
{
    public $extensionImages = ['jpg', 'JPG', 'png', 'PNG'];
    public $destinationPath = 'midia/avatar';
    
    public function consultarEscola() {
        $termo = Input::get('termo');
        
        return Escola::select([ 'id_etec', 'nome' ])
                ->where('nome', 'LIKE', '%' . $termo . '%')
                ->get();      
    }
    
    public function consultarTurma() {
        $turma = Input::get('turma');
        $escola = Input::get('escola');
        
        $turmas = Turma::select([ 'id', 'nome', 'sigla' ])
                ->where('id_escola', $escola)
                ->where(function ($query) use ($turma) {
                    $query->where('nome', 'LIKE', '%' . $turma . '%')
                          ->orWhere('sigla', 'LIKE', '%' . $turma . '%');
                })
                ->get();
                
        Return view('turma', [ 'turmas' => $turmas ]);
      
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function editar(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        
        if ($request->hasFile('foto')) {
            $this->addfoto($request->foto);
        } 
        
        $user->nome                 = $request->nome;
        $user->username             = $request->username;
        $user->nasc                 = $request->nasc;
        $user->habilidades          = $request->habilidades;
        $user->empresa              = $request->empresa;
        $user->cidade               = $request->cidade;
        $user->email_alternativo    = $request->email_alternativo;
        
        if($request->has('senha')) {
           // if (bcrypt($request->senha_atual) != Auth::user()->password) {
                //return "Senha atual incorreta";
            //} else 
            if ($request->senha != $request->senha_confirmation) {
                 return Response::json(['status' => false, 'msg' => 'Senha não correspondem']);
            } else {
                $user->password = bcrypt($request->senha);
            }
        }
        
        $user->save();
       
        return Response::json(['status' => true, 'msg' => 'Dados alterados com sucesso!']);
    }
    
    public function addfoto($midia) {
        $ext = $midia->getClientOriginalExtension();
           
        if (!in_array($ext, $this->extensionImages)) {
           
            return 'Formato inválido';
        }
        Input::file('foto')->move($this->destinationPath, md5(Auth::user()->id) . '.jpg');
    }
}