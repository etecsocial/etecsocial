<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\GrupoUsuario;
use DB;
use App\Events\UserRegister;

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
        if($data['tipo'] == 1){ // aluno
            
            return Validator::make($data, [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'username' => 'required|max:255|unique:users',
                'email_instuticional' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6|confirmed',
                'id_turma' => 'required|exists:escolas,id|integer',
                'id_modulo' => 'required|exists:modulos,id|integer',
                'id_turma' => 'required|exists:turmas,id|integer',
                ]);

        } else if($data['tipo'] == 2){ // professor
            return Validator::make($data, [
                'name' => 'required|max:255',
                'username' => 'required|max:255|unique:users',
                'email' => 'required|email|max:255|unique:users',
                'email_instuticional' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6|confirmed',
                'formacao' => 'required',
                ]);
        }
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
            'nome' => $data['nome'],
            'username' => $data['username'],
            'email' => $data['email'],
            'email_instuticional' => $data['email_instuticional'],
            'username' => $data['username'],
            'tipo' => $data['tipo'],
            'password' => bcrypt($data['password']),
            'first_login' => false,
        ]);

        if($data['tipo'] == 1){
            $this->create_aluno($user, $data);
        } else if($data['tipo'] == 2) {
            $this->create_professor($user, $data);
        }

         event(new UserRegister($user));

        return $user;
    }

    protected function create_aluno($user, $data){
        
        // coloca num grupo
        // $add = new GrupoUsuario;
        // $add->id_grupo = $id_grupo;
        // $add->id_user = $aluno;
        // $add->save();
        // $this->IncParticipante($id_grupo);
        DB::table('alunos_info')->insert(['user_id' => $user->id, 
                                   'id_turma' => $data['id_turma'],
                                   'id_escola' => $data['id_escola'],
                                   'id_modulo' => $data['id_modulo']]);
    }

    protected function create_professor($user, $data){
        DB::table('professores_info')->insert(['user_id' => $user->id, 
                                   'id_escola' => $data['id_escola']]);
    }

    protected function logout() {
        auth()->logout();
        session()->flush();
        return redirect('/');
    }
    
}