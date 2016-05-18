<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Escola;
use App\Turma;
use App\User;
use Response;
use Input;
use Image;

class ContaController extends Controller
{
    public $avatar_ext  = ['jpg', 'JPG', 'png', 'PNG'];
    public $avatar_path = 'midia/avatar/';
    
    public function consultarEscola() {
        $termo = Input::get('termo');
        
        return Escola::select([ 'id_etec', 'nome'])
                ->where('nome', 'LIKE', '%' . $termo . '%')
                ->get();      
    }
    
    public function consultarTurma() {
        $turma = Input::get('turma');
        $escola = Input::get('escola');
        
        $turmas = Turma::select([ 'id', 'nome', 'sigla'])
                ->where('id_escola', $escola)
                ->where(function ($query) use ($turma) {
                    $query->where('nome', 'LIKE', '%' . $turma . '%')
                          ->orWhere('sigla', 'LIKE', '%' . $turma . '%');
                })
                ->get();
                
        return view('turma', [ 'turmas' => $turmas ]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function editar(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        
        if ($request->hasFile('foto')) {
            $this->addfoto($request->foto);
        } 
        
        $user->nome                 = $request->nome;
        $user->username             = $request->username;
        $user->nascimento           = $request->nascimento;
        $user->email_alternativo    = $request->email_alternativo;
        
        if($request->has('senha')) {
           // if (bcrypt($request->senha_atual) != auth()->user()->password) {
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
           
        if (!in_array($ext, $this->avatar_ext)) {
            return 'Formato inválido';
        }

        $path = $this->avatar_path . md5(auth()->user()->id) . '.jpg';
        $avatar = Image::make(Input::file('foto'))->fit(200, 200)->save($path);
    }
}