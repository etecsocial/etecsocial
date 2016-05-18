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
        'id',
        'nome',
        'username',
        'email',
        'email_instuticional',
        'tipo',
        'status',
        'nascimento',
        'provider_user_id',
    ];

    public function scopeGetFriends() {
        $this->join('amizades', 'amizades.id_user1', '=', 'users.id')
                ->where('amizades.aceitou', 1)
                ->where('amizades.id_user2', auth()->user()->id);
    }
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token', 'password'
    ];
    
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
    
	// @deprecated
    public static function infoAcademica(){
        return [];
    }
    
	// @deprecated
    public static function myInfoAcademica(){
    }
    
    public static function infos() 
    {
        return DB::table('outras_infos')->where('id_user', auth()->user()->id)->first();
    }
       
    public static function isTeacher($id) 
    {
       return User::select('tipo')->where('id', $id)->where('tipo', 2)->limit(1)->get()->first(); 
    }
    
	// @TODO: refazer tudo
    public static function turmas() {
		/*
       $info = User::myInfoAcademica();
       
       return []; // #@todo: rever isso daqui

       return Turma::where('id_escola', $info->etecs->default)->get(); */
	   return [];
    }
}
