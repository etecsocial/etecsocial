<?php

namespace App\Http\Controllers;

use App\Escola;
use App\Http\Controllers\Controller;
use App\Turma;
use App\User;
use Carbon\Carbon;
use Image;
use Input;
use Response;
use App\Notificacao;
use App\ProfessoresTurma;
use Illuminate\Http\Request;

class ContaController extends Controller {

    public $avatar_ext = ['jpg', 'JPG', 'png', 'PNG'];
    public $avatar_path = 'midia/avatar/';

    public function getEscolas(Request $request) {
        return Escola::select(['id', 'nome'])
                        ->where('nome', 'LIKE', '%' . $request->termo . '%')
                        ->get();
    }

    public function hasCoord($request) {
        return ProfessoresTurma::where('id_escola', $request->escola)
                        ->join('users', 'professores_turma.user_id', '=', 'users.id')
                        ->select('users.id')
                        ->where('type', '=', 3)
                        ->get();
    }

    public function getTurmas(Request $request) {
        $this->validate($request, ['id_escola' => 'required|integer']);

        $turmas = Turma::select(['id', 'nome', 'sigla'])
                ->where('id_escola', $request->id_escola)
                ->get();

        return view('ajax.turmas', ['turmas' => $turmas]);
    }

    public function getModulos(Request $request) {
        $this->validate($request, ['id_turma' => 'required']);

        $modulos = Turma::select('modulos')
                ->where('id', $request->id_turma)
                ->get();

        return view('ajax.modulos', ['modulos' => $modulos[0]->modulos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function editar(Request $request) {
        $user = User::where('id', auth()->user()->id)->first();

        if ($request->hasFile('foto')) {
            $this->addfoto($request->foto);
        }

        if (auth()->user()->username != $request->username &&
                User::where('username', $request->username)->limit(1)->first()) {
            return Response::json(['status' => false, 'msg' => 'Já existe esse usuário']);
        }

        if (auth()->user()->email != $request->email &&
                User::where('email', $request->email)->limit(1)->first()) {
            return Response::json(['status' => false, 'msg' => 'Esse email já está sendo usado']);
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->birthday = Carbon::createFromTimeStamp(strtotime($request->birthday))->format("Y-m-d");
        $user->email = $request->email;

        if ($request->has('senha')) {
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

    public function setProfilePhoto($midia) {
        $ext = $midia->getClientOriginalExtension();

        if (!in_array($ext, $this->avatar_ext)) {
            return 'Formato inválido';
        }

        $path = $this->avatar_path . md5(auth()->user()->id) . '.jpg';
        $avatar = Image::make(Input::file('foto'))->fit(200, 200)->save($path);
    }

    public function setTurmaProfessor(Request $request) {

        $this->validate($request, ['id_turma' => 'required', 'modulo' => 'required']);

        ProfessoresTurma::create([
            'user_id' => auth()->user()->id,
            'id_turma' => $request->id_turma,
            'modulo' => $request->modulo,
        ]);
        auth()->user()->first_login = 0;
        auth()->user()->save();

        return response()->json(['status' => true]);
    }

    public function setTurmas(\App\Http\Requests\CreateTurmaRequest $request) {

        Turma::create(Input::all());
        auth()->user()->first_login = 2;
        auth()->user()->save();

        return response()->json(['status' => true]);
    }

    public function doneTurmas() {
        auth()->user()->first_login = 2;
        auth()->user()->save();
    }

// @TODO

    public function confirmEmail(Request $request) {
        $confirmation_code = $request->confirmation_code;
        if (!empty($confirmation_code)) {
            $user = User::where('confirmation_code', '=', $confirmation_code)->first();
            $user->confirmed = 1;
            $user->confirmation_code = null;
            $user->save();

            $notifica = new Notificacao;
            $notifica->id_dest = $user->id;
            $notifica->id_rem = $user->id;

            $notifica->data = '';
            $notifica->texto = 'Você confirmou seu email!';


            auth()->login($user);
        }

        return redirect('/');
    }

}
