<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegister;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Validator;

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
        if ($data['type'] == 1) {
            // aluno
            $validator = [
                'name'      => 'required|max:255',
                'email'     => 'required|email|max:255|unique:users',
                'password'  => 'required|min:6|confirmed',
                'id_escola' => 'required|exists:escolas,id|integer',
                'id_turma'  => 'required|exists:turmas,id|integer',
            ];

        } else if ($data['type'] == 2) {
            // professor
            $validator = [
                'name'      => 'required|max:255',
                'email'     => 'required|email|max:255|unique:users',
                'password'  => 'required|min:6|confirmed',
                'cod_prof'  => 'required|exists:escolas,cod_prof|integer', // @TODO: melhorar isso daqui
                'id_escola' => 'required|exists:escolas,id|integer',
            ];

        }
        return Validator::make($data, $validator);
    }

    protected function create_username($name)
    {
        $name = strtolower($name);
        $name = str_replace(' ', '', $name);
        $name = $name . rand(1, 100);
        return $name;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        if ($data['type'] == 2) {
            $first_login = 3;
        } else {
            $first_login = 0;
        }

        $user = User::create([
            'name'        => $data['name'],
            'username'    => $this->create_username($data['name']),
            'email'       => $data['email'],
            'type'        => $data['type'],
            'password'    => bcrypt($data['password']),
            'first_login' => $first_login,
        ]);

        if ($data['type'] == 1) {
            $this->create_aluno($user, $data);
        } else if ($data['type'] == 2) {
            $this->create_professor($user, $data);
        }

        event(new UserRegister($user));

        return $user;
    }

    protected function create_aluno($user, $data)
    {

        // coloca num grupo
        // $add = new GrupoUsuario;
        // $add->id_grupo = $id_grupo;
        // $add->id_user = $aluno;
        // $add->save();
        // $this->IncParticipante($id_grupo);
        DB::table('alunos_info')->insert(['user_id' => $user->id,
            'id_turma'                                  => $data['id_turma'],
            'id_escola'                                 => $data['id_escola']]);
    }

    protected function create_professor($user, $data)
    {
        //DB::table('professores_info')->insert(['user_id' => $user->id,
        //                           'id_escola' => $data['id_escola']]);
        // @todo: adicionar todas as salas que o professor dá aula
    }

    protected function logout()
    {
        auth()->logout();
        session()->flush();
        return redirect('/');
    }

    public function showRegistrationForm()
    {
        return redirect('/#register');
    }

    public function showLoginForm()
    {
        return redirect('/#login');
    }
}
