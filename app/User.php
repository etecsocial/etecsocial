<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Auth;
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
        'username',
        'email',
        'email_alternativo',
        'username',
        'tipo',
        'id_turma',
        'password',
        'nome',
        'info_academica',
        'status',
        'confirmation_code',
        'confirmed',
        'reputacao',
        'num_desafios',
        'num_auxilios',
        'id_escola',
        'nasc',
        'habilidades',
        'empresa',
        'cidade'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token'
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
    
    public static function myAvatar() 
    {
        return User::avatar(Auth::user()->id);
    }
    
    public static function infoAcademica($id) 
    {
        $user = User::where('id', $id)->select("info_academica")->first(); 
        
        return json_decode($user->info_academica);
    }
    
    public static function myInfoAcademica() 
    {
        return User::infoAcademica(Auth::user()->id);
    }
    
    public static function infos() 
    {
        return DB::table('outras_infos')->where('id_user', Auth::user()->id)->first();
    }
       
    public static function isTeacher($uid) 
    {
       return User::where('id', $uid)->where('tipo', 2)->first(); 
    }
    
    public static function turmas() {
       $info = User::myInfoAcademica();
       
       return Turma::where('id_escola', $info->etecs->default)->get();
    }
}
