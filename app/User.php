<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use DB;

use App\Turma;

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
        'birthday', 'first_login'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'provider_id', 'provider_user_id'
    ];

    public function scopeGetFriends() {
        $this->join('amizades', 'amizades.id_user1', '=', 'users.id')
                ->where('amizades.aceitou', 1)
                ->where('amizades.id_user2', auth()->user()->id);
    }
    
    public static function verUser($id) 
    {
        return User::where('id', $id)->first();
    }
    
    public static function avatar($id) 
    {
        $avatar_path = 'midia/avatar/' . md5($id) . '.jpg';
        if (file_exists($avatar_path)){
            return url($avatar_path);
        } else {
            return url('/images/default-user.png');
        }
    }
    
    public static function myAvatar()  {
        return User::avatar(auth()->user()->id);
    }

    public function makeAvatar() { }
       
    public static function isTeacher($id) 
    {
       return User::select('type')->where('id', $id)->where('type', 2)->limit(1)->get()->first(); 
    }
    
	// @TODO: refazer tudo
    public static function turmas() {
		/*
       $info = User::myInfoAcademica();
       
       return []; // #@todo: rever isso daqui

       return Turma::where('id_escola', $info->etecs->default)->get(); */
	   return [];
    }

    public function escola(){
        if($this->type == 1){
            $dados = User::where('users.id', $this->id)
                        ->join('alunos_info', 'users.id', '=', 'alunos_info.user_id')
                        ->join('turmas', 'turmas.id', '=', 'alunos_info.id_turma')
                        ->join('escolas', 'escolas.id', '=', 'turmas.id_escola')
                        ->select('escolas.nome as escola_nome')
                        ->limit(1)
                        ->first();
        } else if($this->type == 2){
            $dados = (object) ['escola_nome' => 'erro'];
        }
        if(isset($dados->escola_nome)){
            return $dados->escola_nome;
        } else {
            return "Não adicionado ainda";
        }
    }
}
