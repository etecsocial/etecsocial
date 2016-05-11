<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Socialize;
use App\User;
use App\Amizade;

class FacebookController extends Controller
{
    public function login() {
    	return Socialize::with('facebook')->redirect();
    }

    public function feedback() {

        $user_facebook = Socialize::with('facebook')->user();
        $check_user = User::where('provider_user_id', $user_facebook->id)->limit(1)->get()->first();
        if($check_user){
            // array diff para checar se o usuário mudou algo

            auth()->login($check_user);
            return redirect('/');
        }

        $check_user_email = User::where('email', $user_facebook->email)->limit(1)->get()->first();
        if(empty($check_user) && $check_user_email){
            return redirect('/login')->with('social_error', 'Você já se cadastrou com esse email do facebook :(');
        }

        $user = User::create([
            'nome' => $user_facebook->name,
            'email' => $user_facebook->email,
            'tipo' => 1, // aluno
            'username' => $user_facebook->nickname,
            'id_escola' => 1,
            'id_modulo' => 1,
            'id_turma' => 1,
            'provider_user_id' => $user_facebook->id,
            'password' => bcrypt('temp' . rand() . 'temp'), // @TODO: algo não está certo aqui
        ]);
        Amizade::insert(['id_user1' => $user->id, 'id_user2' => $user->id, 'aceitou' => 1]);
		$this->make_avatar($user->id, $user_facebook->avatar);
	    auth()->login($user, true);
        return redirect('/');
    }

    private function make_avatar($user_id, $avatar){

    }
}
