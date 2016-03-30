<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Post;
use Auth;
use DB;
use App\Mensagens;
use App\GrupoUsuario;



use Carbon\Carbon;

class HomeController extends Controller
{
    public function logout(){
        \Session::flush(); // limpa os cookies
        Auth::logout();
        \Session::flush(); // limpa de novo, queima
        return redirect('/');
    }

    public function index() 
    {
        
        /* if (Input::has('confirmation_code')) {
            $user = User::where('confirmation_code', Input::get('confirmation_code'))->first();
        } else {
            $user = 'false';
        } */
        return Auth::check() ?  $this->feed() : view('home.home');
    }
    
    public function feed($id = 0) 
    {           
        $posts = Post::join('users', 'users.id', '=', 'posts.id_user')
                ->join('amizades', 'amizades.id_user1', '=', 'users.id')
                ->limit(9)
                ->orderBy('created_at', 'desc')
                ->select([ 'posts.id', 'posts.id_user', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.nome', 'users.username'])
                ->where('amizades.aceitou', 1)
                ->where('amizades.id_user2', Auth::user()->id)
                ->get();
        
        $grupos = GrupoUsuario::where('id_user', Auth::user()->id)
                ->join('grupo', 'grupo.id', '=', 'grupo_usuario.id_grupo')
                ->limit(5)
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
        return view('home.feed', ['posts' => $posts, 'tasks' => $tasks, 'id' => $id, 'grupos' => $grupos, 'thisUser' => Auth::user(), 'msgsUnread' => Mensagens::countUnread()]);
    }
    
    public function newpost(Request $request) 
    {
        
        $posts = DB::table('posts')
                ->join('users', 'users.id', '=', 'posts.id_user')
                ->join('amizades', 'amizades.id_user1', '=', 'users.id')
                ->orderBy('created_at', 'desc')
                ->select([ 'posts.id', 'posts.id_user', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.nome', 'users.username' ])
                ->where('amizades.aceitou', 1)
                ->where('amizades.id_user2', Auth::user()->id)
                ->where('posts.id', '>', $request->id)
                ->get();
        
        return view('home.posts', ['posts' => $posts, 'thisUser' => Auth::user()]);
    }
    
    public function morepost(Request $request) 
    {
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
        
        return view('home.posts', [ 'posts' => $posts, 'thisUser' => Auth::user()]);
    }
}
