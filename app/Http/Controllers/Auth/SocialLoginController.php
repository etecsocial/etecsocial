<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Socialize;
use App\User;
use App\Events\RegisterUser;

class SocialLoginController extends Controller
{
    private $avalible_providers = ['facebook'];
    private $redirect = '/';

    // checa se pode utilizar
    public function __construct(Request $request){
        if(!in_array($request->provider, $this->avalible_providers)){
            abort(404, 'Provedor de login não suportado');
        }
    }

	/**
     * Função apenas para acionar a route de login
     *
     * @param object Request | usado para pegar qual provider vai utilizar
     * @return void
     */
	public function login($provider) {
        return Socialize::with($provider)->redirect();	
    }

    // genérica para os dois
    public function fallback($provider){
        return $this->$provider();
    }

	/**
     * Função que é acionada quando o facebook valida e volta a requisição de login
     *
     * @return void
     */
    protected function facebook() {
        $user = Socialize::with('facebook')->user();
        
        $check_user = User::where('provider_user_id', $user->id)->where('provider_id', 1)->limit(1)->first();
        if($check_user){
            $this->check_diff($user, $check_user);

            auth()->login($check_user);
            return redirect($this->redirect);
        }

        $check_user_email = User::where('email', $user->email)->limit(1)->first();
        if(empty($check_user) && $check_user_email){
            $check_user_email->provider_id = 1;
            $check_user_email->provider_user_id = $user->id;
            $check_user_email->save();
            auth()->login($check_user_email);

            return redirect($this->redirect);
        }

        $user_db = new User;
        $user_db->name = $user->name;
        $user_db->email = $user->email;
        $user_db->username = 'social' . rand(1, 100);
        $user_db->provider_id = 1;
        $user_db->provider_user_id = $user->id;
        $user_db->password = bcrypt('temp' . rand() . 'temp');
        $user_db->first_login = 1;
        $user_db->confirmed = true;
        $user_db->save();

        $user_db->makeAvatar($user->avatar);
        
        event(new RegisterUser($user_db));

        return redirect($this->redirect);
    }

    /**
     * Função que é acionada quando o google valida e volta a requisição de login
     *
     * @return void
     */
    protected function google() { }

    /**
     * Função diff para checar se o usuário mudou algo no provider, se sim moda no banco de dados
     *
     * @return void
     */    
    protected function check_diff($provider, $db){
        $user_1 = ['name' => $provider->name,
                   'email' => $provider->email];
        $user_2 = ['name' => $db->name,
                   'email' => $db->email,
                   'gender' => $db->gender];
        
        if(!empty(array_diff($user_1, $user_2))){
            $db->email = $provider->email;
            $db->name = $provider->name;
            $db->gender = $provider->gender;
        }
    }
}
