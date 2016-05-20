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
use Carbon\Carbon;
use DB;

class ContaController extends Controller
{
    public $avatar_ext  = ['jpg', 'JPG', 'png', 'PNG'];
    public $avatar_path = 'midia/avatar/';
    
    public function consultarEscola(Request $request) {        
        return Escola::select([ 'id', 'nome'])
                ->where('nome', 'LIKE', '%' . $request->termo . '%')
                ->get();      
    }
    
    public function consultarTurma(Request $request) {
    $turma = $request->turma;        
        $turmas = Turma::select([ 'id', 'nome', 'sigla'])
                ->where('id_escola', $request->escola)
                ->where(function ($query) use ($turma) {
                    $query->where('nome', 'LIKE', '%' . $turma . '%')
                          ->orWhere('sigla', 'LIKE', '%' . $turma . '%');
                })
                ->get();
                
        return view('ajax.turma', ['turmas' => $turmas]);
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
                
        if(auth()->user()->username != $request->username &&
           User::where('username', $request->username)->limit(1)->first()){
            return Response::json(['status' => false, 'msg' => 'Já existe esse usuário']);
        }

        if(auth()->user()->email != $request->email &&
            User::where('email', $request->email)->limit(1)->first()){
            return Response::json(['status' => false, 'msg' => 'Esse email já está sendo usado']);
        }

        $user->name     = $request->name;
        $user->username = $request->username;
        $user->birthday = Carbon::createFromTimeStamp(strtotime($request->birthday))->format("Y-m-d");
        $user->email = $request->email;
        
        if($request->has('senha')) {
            if (bcrypt($request->senha_atual) != auth()->user()->password) {
                return Response::json(['status' => false, 'msg' => 'Senha atual incorreta']);
            } else if ($request->senha != $request->senha_confirmation) {
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

    public function professor(Request $request){
        foreach($request->turmas as $turma){
            DB::table('professores_info')->insert(['user_id' => auth()->user()->id,
                                                'id_turma' => $turma,
                                                'id_escola' => $request->id_escola]);
        }

        auth()->user()->first_login = 0;
        auth()->user()->save();
    }
}