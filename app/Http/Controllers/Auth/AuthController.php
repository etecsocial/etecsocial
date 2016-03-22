<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Amizade;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'username' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'escola' => 'required',
            'modulo' => 'required',
            'turma' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'nome' => $data['name'],
            'email' => $data['email'],
            'tipo' => 1, // aluno
            'username' => $data['username'],
            'id_escola' => $data['escola'],
            'id_modulo' => $data['modulo'],
            'id_turma' => $data['turma'],
            
            // temp (info_academica)
            'info_academica' => '{"is_prof":false,"instituicao":"ETEC Pedro Ferreira Alves","modulo":"3\u00ba S\u00e9rie","curso":"Ensino M\u00e9dio Integrado a Inform\u00e1tica para Internet","conclusao":"2015"}',
            'password' => bcrypt($data['password']),
        ]);
        Amizade::insert(['id_user1' => $user->id, 'id_user2' => $user->id, 'aceitou' => 1]);
        return $user;
    }
    
}
