<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\User;
use App\Post;

use Auth;
use DB;
use Input;

use Carbon\Carbon;

class HomeController extends Controller
{

    public function index()
    {
        if (Auth::check()) {
            return $this->feed();
        } else {
            return $this->login();
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }

    public function login() 
    {
        if (Input::has('confirmation_code')) {
            $user = User::where('confirmation_code', Input::get('confirmation_code'))->first();
        } else {
            $user = 'false';
        }

        return view('home.newhome', [
            'user'      => $user,
            'cadastro'  => Input::has('cadastro')
        ]);
    }

    public function login_or_cadastro(){
        if(Input::get('type') == 'login'){
            $email = Input::get('email');
            $senha = Input::get('senha');
            $remember = (Input::get('remember') == 'on') ? true : false;

            if(empty($email) || empty($senha)){
                return redirect('/');
            }
            
            if (Auth::attempt(['email' => $email, 'password' => $senha], $remember)) {
                return redirect('/');
            } else {
                return 'login errado';
            }

        } else if(Input::get('type') == 'cadastro'){
            


        } else {
            return redirect('/');
        }
        
    }
    
    public function feed($id = 0) 
    {   
        Carbon::setLocale('pt_BR');
        
        $posts = Post::join('users', 'users.id', '=', 'posts.id_user')
                ->join('amizades', 'amizades.id_user1', '=', 'users.id')
                ->limit(9)
                ->orderBy('created_at', 'desc')
                ->select([ 'posts.id', 'posts.id_user', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.nome', 'users.username'])
                //->where('amizades.aceitou', 1)
                //->where('amizades.id_user2', Auth::user()->id)
                ->get();
        

        Carbon::setLocale('pt_BR');
        
        $tasks = DB::table('tarefas')
                ->select(['desc', 'data', 'checked', 'id'])
                ->where('id_user', Auth::user()->id)
                ->where(function($query)
                {
                    $query->where('data_checked', '>', time() - 3 * 24 * 60 * 60)
                          ->orWhere('checked', false);
                })
                ->orderBy('data')
                ->limit(4)
                ->get();
        
        return view('home.feed', ['posts' => $posts, 'tasks' => $tasks, 'id' => $id]);
    }
    
    public function newpost(Request $request) 
    {
        Carbon::setLocale('pt_BR');
        
        $posts = DB::table('posts')
                ->join('users', 'users.id', '=', 'posts.id_user')
                ->join('amizades', 'amizades.id_user1', '=', 'users.id')
                ->orderBy('created_at', 'desc')
                ->select([ 'posts.id', 'posts.id_user', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.nome', 'users.username' ])
                ->where('amizades.aceitou', 1)
                ->where('amizades.id_user2', Auth::user()->id)
                ->where('posts.id', '>', $request->id)
                ->get();
        
        return view('home.posts', ['posts' => $posts]);
    }
    
    public function morepost(Request $request) 
    {
        Carbon::setLocale('pt_BR');
        $n = 9 - $request->tamanho % 9;
                
        $posts = DB::table('posts')
                ->join('users', 'users.id', '=', 'posts.id_user')
                ->join('amizades', 'amizades.id_user1', '=', 'users.id')
                ->limit($n)
                ->orderBy('created_at', 'desc')
                ->select([ 'posts.id', 'posts.id_user', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.nome', 'users.username' ])
                ->where('amizades.aceitou', 1)
                ->where('amizades.id_user2', Auth::user()->id)
                ->where('posts.id', '<', $request->id)
                ->get();
        
        return view('home.posts', [ 'posts' => $posts ]);
    }
}
