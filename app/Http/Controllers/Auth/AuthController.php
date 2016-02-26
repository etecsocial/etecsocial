<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Mail;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller {

    use AuthenticatesAndRegistersUsers;

    public function __construct() {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    protected function validator(array $data) {
        return Validator::make($data, [
                    'email' => 'required|email|max:45|institucional|unique:users',
                    'senha' => 'required|confirmed|min:6'
        ]);
    }

    protected function validatorAluno(array $data) {
        return Validator::make($data, [
                    'turma' => 'required',
                    'modulo' => 'required',
                    'conclusao' => 'required|numeric|min:4',
                    'instituicao' => 'required',
                    'nome' => 'required|min:3|max:55',
                    'sobrenome' => 'required|min:3|max:55',
                    'username' => 'required|min:3|max:20|unique:users',
                    'email_alternativo' => 'email|max:45|checkmail|unique:users',
        ]);
    }

    protected function validatorProf(array $data) {
        return Validator::make($data, [
                    'atuacao' => 'required|min:3|max:55',
                    'formacao' => 'required|min:3|max:55',
                    'ano_entrada' => 'required|numeric|min:4',
                    'universidade' => 'required|min:4|max:90',
                    'nome' => 'required|min:3|max:55',
                    'sobrenome' => 'required|min:3|max:55',
                    'username' => 'required|min:3|max:20|unique:users',
        ]);
    }

    protected function create(array $data, $code, $info_acad, $id_etec) {
        return User::create([
                    'email' => $data['email'],
                    'tipo' => $data['tipo'],
                    'password' => bcrypt($data['senha']),
                    'confirmation_code' => $code,
                    'info_academica' => $info_acad,
                     'id_escola' => $id_etec
        ]);
    }

    protected function update(array $data, $email) {
        $user = User::where('email', $email)->update([
            'username' => $data['username'],
            'email_alternativo' => $data['email_alternativo'],
            'nome' => $data['nome'],
            'info_academica' => $data['info_academica'],
            'confirmed' => 1,
            'confirmation_code' => NULL,
            'id_turma' => $data['turma'],
            'id_modulo' => $data['modulo'],
            'id_escola' => $data['instituicao'],
        ]);

        return \DB::table('amizades')->insert([
                    'id_user1' => User::where('email', $email)->first()->id,
                    'id_user2' => User::where('email', $email)->first()->id,
                    'aceitou' => 1
        ]);
    }

    protected function codProf($cod_prof) {
        return Validator::make(
                        [ 'codigo de acesso' => $cod_prof], [ 'codigo de acesso' => 'required|exists:lista_etecs,cod_prof']
        );
    }

    protected function send($email, $code) {
        return Mail::send('emails.verifica', [ 'code' => $code], function($message) use ($email) {
                    $message->from('contato@etecsocial.com.br', 'ETEC Social');
                    $message->to($email, $email)->subject('Verificação de e-mail');
                });
    }

}
