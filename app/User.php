<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable,
        CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email_instuticional',
        'email', 'password', 'type',
        'provider_id', 'provider_user_id',
        'birthday', 'first_login', 'confirmation_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'provider_id', 'provider_user_id', 'confirmation_code'
    ];

    /**
     * @return \Iluminate\Database\Elequoment\Relations\HasMany
     * @return \Iluminate\Database\Elequoment\Relations\BelongsTo
     */
    public function profInfo() {
        return $this->hasOne('App\ProfessoresInfo');
    }

    public function tarefas() {
        return $this->hasMany('App\Tarefa');
    }

    // aluno
    public function turma() {
        return $this->belongsTo('App\AlunosTurma');
    }

    // professor
    public function turmas() {
        return $this->hasMany('App\ProfessoresTurma');
    }

    public function grupos() {
        return $this->belongsTo('App\Grupo');
    }

    public function scopeTaskValid($query) {
        return $query->where(function ($query) {
                    $query->where("data_checked", ">", time() - 3 * 24 * 60 * 60)
                            ->orWhere('checked', false);
                });
    }

    public function posts() {
        return $this->hasMany('App\Post');
    }

    public function desafios() {
        return $this->hasMany('App\Desafio');
    }

    public function eventos() {
        return $this->hasMany('App\Evento');
    }

    public function scopeGetFriends() {
        $this->join('amizades', 'amizades.user_id1', '=', 'users.id')
                ->where('amizades.aceitou', 1)
                ->where('amizades.user_id2', auth()->user()->id);
    }

    public static function verUser($id) {
        return User::where('id', $id)->first();
    }
    
    public function countAmigos($uid) {
        DB::table('amizades')->where(['user_id1' => $uid, 'aceitou' => 1])->count() - 1;
    }
    public function Listamigos($uid) {
        DB::table('amizades')->where(['user_id1' => $uid, 'aceitou' => 1]);
        //@TODO terminar isso
    }

    public static function avatar($id) {
        $avatar_path = 'midia/avatar/' . md5($id) . '.jpg';
        if (file_exists($avatar_path)) {
            return url($avatar_path);
        } else {
            return url('/images/default-user.png');
        }
    }

    public static function myAvatar() {
        return User::avatar(auth()->user()->id);
    }

    public function makeAvatar() {
        
    }

    public static function isTeacher($id) {
        return User::select('type')->where('id', $id)->where('type', 2)->limit(1)->get()->first();
    }

    public function escola() {
        if ($this->type == 1) {
            $dados = User::where('users.id', $this->id)
                    ->join('alunos_turma', 'alunos_turma.user_id', '=', 'users.id')
                    ->join('escolas', 'escolas.id', '=', 'alunos_turma.escola_id')
                    ->select('escolas.nome as escola_nome')
                    ->limit(1)
                    ->first();
        } else if ($this->type == 2) {
            $dados = (object) ['escola_nome' => 'erro'];
        }
        if (isset($dados->escola_nome)) {
            return $dados->escola_nome;
        } else {
            return "Não adicionado ainda";
        }
    }

    public static function create_username($name) {
        $username = strtolower(strtr(str_replace(' ', '', $name), "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ", "aaaaeeiooouucAAAAEEIOOOUUC"));

        $cont = 1;
        if (User::where('username', $username)->select('id')->first()) {
            $nova = $username . '.' . $cont;
            while (User::where('username', $nova)->select('id')->first()) {
                $cont++;
                $nova = $username . '.' . $cont;
            }
        } return isset($nova) ? $nova : $username;
    }

    public static function getInfoAcademica($uid = null) {
        $u = isset($uid) ? User::findOrFail($uid) : auth()->user();
        //VOU OTIMIZAR ISSO AINDA.
        switch ($u->type) {
            case 1:
                //Aluno
                if ($u->first_login == 0) {
                    return AlunosTurma::where('user_id', $u->id)
                                    ->join('turmas', 'turmas.id', '=', 'alunos_turma.turma_id')
                                    ->join('escolas', 'turmas.escola_id', '=', 'escolas.id')
                                    ->select(['turmas.nome as turma', 'turmas.sigla as sigla', 'escolas.nome as etec', 'alunos_turma.modulo as modulo', 'escolas.nome as etec'])
                                    ->get()[0];
                }
                //facebook login aqui, o first_login vai ser diferente...
                break;
            case 2 or 3:
                //PROFESSOR
                $info = ProfessoresInfo::
                                where('user_id', $u->id)
                                ->select(['escola_id as id', 'escolas.nome as escola', 'professores_info.*'])
                                ->join('escolas', 'escolas.id', '=', 'professores_info.escola_id')
                                ->get()[0];
                break;
        }return $info;
    }

}
