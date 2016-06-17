<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use DB;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Validator;

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
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users',
                    'password' => 'required|min:6|confirmed',
                    'id_escola' => 'required|exists:escolas,id|integer',
                    'id_turma' => 'required|exists:turmas,id|integer'
                ];
                break;
            case 2: //PROFESSOR
                //if ($this->hasCoord($data['id_escola'])) {// VERIFICA SE HÁ COORDENADOR NA ESCOLA
                    $validator = [
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:255|unique:users',
                        'password' => 'required|min:6|confirmed',
                        'id_escola' => 'required|exists:escolas,id|integer',
                        'cod_prof' => 'required|exists:escolas,cod_prof,id,'.$data['id_escola'] 
                    ];
//                } else {
//                    //Não pode ser cadastrado! Não há coordenador cadastrado!
//                    return false;
//                }
                break;
            case 3: //COORDENADOR
                $validator = [
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users',
                    'password' => 'required|min:6|confirmed',
                    'id_escola' => 'required|exists:escolas,id|integer',
                    'cod_coord' => 'required|exists:escolas,cod_coord,id,'.$data['id_escola'] 
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
        if ($data['type'] > 1) {
            $first_login = 3;
        } else {
            $first_login = 0;
        }

        $user = User::create([
                    'name' => $data['name'],
                    'username' => User::create_username($data['name']),
                    'email' => $data['email'],
                    'type' => isset($this->is_coord) ? 3 : $data['type'],
                    'password' => bcrypt($data['password']),
                    'first_login' => $first_login,
                    'confirmation_code' => str_random(30),
        ]);

        $data['type'] == 1 ? $this->create_aluno($user, $data) : false;
        return $user;
    }

    protected function create_aluno($user, $data) {
        DB::table('alunos_info')->insert(['user_id' => $user->id,
            'id_turma' => $data['id_turma'],
            'id_escola' => $data['id_escola']]);
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

    public function hasCoord($id) {
        return DB::table('users')
                        ->join('professores_info', 'users.id', '=', 'professores_info.user_id')
                        ->select('users.id')
                        ->where('users.type', 3)
                        ->where('professores_info.id_escola', $id)->first();
    }

}
