<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use DB;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Validator;
use App\AlunosTurma;
use App\ProfessoresInfo;
use App\GrupoUsuario;
use App\GrupoTurma;

class AuthController extends Controller {
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

use AuthenticatesAndRegistersUsers,
    ThrottlesLogins;

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
    public function __construct() {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {

        switch ($data['type']) {
            case 1: //ALUNO
                $validator = [
                    'name' => 'required|max:50|regex:^[A-ZÉÚÍÓÁÈÙÌÒÀÕÃÑÊÛÎÔÂËYÜÏÖÄ][a-zéúíóáèùìòàõãñêûîôâëyüïöä]+( [A-ZÉÚÍÓÁÈÙÌÒÀÕÃÑÊÛÎÔÂËYÜÏÖÄ][a-zéúíóáèùìòàõãñêûîôâëyüïöä]+)+$^',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|min:6|confirmed|regex:^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$^',
                    'escola_id' => 'required|exists:escolas,id|integer',
                    'turma_id' => 'required|exists:turmas,id',
                    'modulo' => 'required|max:6'
                ];
                break;
            case 2: //PROFESSOR
                $validator = [
                    'name' => 'required|max:50|regex:^[A-ZÉÚÍÓÁÈÙÌÒÀÕÃÑÊÛÎÔÂËYÜÏÖÄ][a-zéúíóáèùìòàõãñêûîôâëyüïöä]+( [A-ZÉÚÍÓÁÈÙÌÒÀÕÃÑÊÛÎÔÂËYÜÏÖÄ][a-zéúíóáèùìòàõãñêûîôâëyüïöä]+)+$^',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|min:6|confirmed|regex:^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$^',
                    'escola_id' => 'required|exists:escolas,id|integer',
                    'cod_prof' => 'required|exists:escolas,cod_prof,id,' . $data['escola_id']
                ];
                break;
            case 3: //COORDENADOR
                $validator = [
                    'name' => 'required|max:50|regex:^[A-ZÉÚÍÓÁÈÙÌÒÀÕÃÑÊÛÎÔÂËYÜÏÖÄ][a-zéúíóáèùìòàõãñêûîôâëyüïöä]+( [A-ZÉÚÍÓÁÈÙÌÒÀÕÃÑÊÛÎÔÂËYÜÏÖÄ][a-zéúíóáèùìòàõãñêûîôâëyüïöä]+)+$^',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|min:6|confirmed|regex:^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$^',
                    'escola_id' => 'required|exists:escolas,id|integer',
                    'cod_coord' => 'required|exists:escolas,cod_coord,id,' . $data['escola_id']
                ];
                break;

            default:
                break;
        }

        return Validator::make($data, $validator);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) {
        $user = User::create([
                    'name' => $data['name'],
                    'username' => User::create_username($data['name']),
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'first_login' => $data['type'] != 1 ? $data['type'] : 0,
                    'confirmation_code' => str_random(30),
                        //'type' => $data['type']
                        //Não ta inserindo por nada essa droga, tava inserindo na linha 119 como gambiarra, mas nem la ta inserindo 0 tambem..
        ]);
        //return abort(404);
        $data['type'] == 1 ? $this->create_aluno($user, $data) : $this->create_prof($user, $data);
        return $user;
    }

    protected function create_aluno($user, $data) {

        AlunosTurma::create([
            'user_id' => $user->id,
            'turma_id' => $data['turma_id'],
            'modulo' => $data['modulo'],
        ]);
        DB::table('users')
                ->where('id', $user->id)
                ->update(['type' => $data['type']]);

        if ($data['type'] == 1) {
            $this->addGrupo($data, $user);
        }
    }

    public function addGrupo($data, $user) {
        $q = GrupoTurma::where('turma_id', $data['turma_id'])->where('modulo', $data['modulo'])->select('grupo_id')->get()[0];
        GrupoUsuario::create([
            'grupo_id' => $q->grupo_id,
            'user_id' => $user->id
        ]);
    }

    protected function create_prof($user, $data) {
        ProfessoresInfo::create([
            'user_id' => $user->id,
            'escola_id' => $data['escola_id']]);
        DB::table('users')
                ->where('id', $user->id)
                ->update(['type' => $data['type']]);
    }

    protected function logout() {
        auth()->logout();
        session()->flush();
        return redirect('/');
    }

    public function showRegistrationForm() {
        return redirect('/#register');
    }

    public function showLoginForm() {
        return redirect('/#login');
    }

}
