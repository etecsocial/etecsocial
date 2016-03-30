<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use DB;
use App\Amizade;
use App\User;
use App\Post;
use Carbon\Carbon;
use App\Mensagens;

class PerfilController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($username) {


        if ($u = User::where('username', $username)->first()) {

            if ($u->tipo === 1) {
                $dados = User::where('username', $username)
                        ->join('turmas', 'turmas.id', '=', 'users.id_turma')
                        ->join('lista_etecs', 'lista_etecs.id_etec', '=', 'turmas.id_escola')
                        ->select(['users.id', 'reputacao', 'users.status', 'users.nome AS nome_usuario', 'users.username', 'users.tipo', 'lista_etecs.nome as nome_etec', 'turmas.sigla', 'users.info_academica', 'turmas.nome as nome_curso', 'created_at'])
                        ->limit(1)
                        ->first();
            } else {
                $dados = User::where('username', $username)
                        ->select(['users.id', 'reputacao', 'users.status', 'users.nome AS nome_usuario', 'users.username', 'users.tipo', 'users.info_academica', 'created_at'])
                        ->limit(1)
                        ->first();
            }
            $amizade = Amizade::verificar($dados->id);

            if ($amizade['status']) {

                $posts = Post::where('id_user', $dados->id)
                        ->join('users', 'users.id', '=', 'posts.id_user')
                        ->orderBy('created_at', 'desc')
                        ->select([ 'posts.id', 'posts.id_user', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.nome', 'users.username'])
                        ->limit(5)
                        ->get();
            } else {
                $posts = Post::where('id_user', $dados->id)
                        ->join('users', 'users.id', '=', 'posts.id_user')
                        ->orderBy('created_at', 'desc')
                        ->select([ 'posts.id', 'posts.id_user', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.nome', 'users.username'])
                        ->where("posts.is_publico", 1)
                        ->limit(5)
                        ->get();
            }

            $infoacad = User::infoAcademica($dados->id);

            $num_amigos = DB::table('amizades')->where([ 'id_user1' => $dados->id, 'aceitou' => 1])->count() - 1;
            $num_grupos = DB::table('grupo_usuario')->where([ 'id_user' => auth()->user()->id])->count();

            Carbon::setLocale('pt_BR');
            $tasks = DB::table('tarefas')
                    ->select([ 'desc', 'data', 'checked', 'id'])
                    ->where("id_user", auth()->user()->id)
                    ->where(function($query) {
                        $query->where("data_checked", ">", time() - 3 * 24 * 60 * 60)
                        ->orWhere('checked', false);
                    })
                    ->orderBy('data')
                    ->limit(4)
                    ->get();

            return view('perfil.home', [
                'user' => $dados,
                'is_my' => (auth()->user()->id == $dados->id) ? 1 : 0,
                'posts' => $posts,
                'infoacad' => $infoacad,
                'num_amigos' => $num_amigos,
                'num_grupos' => $num_grupos,
                'amizade' => $amizade,
                'tasks' => $tasks,
                'thisUser' => auth()->user(),
                'msgsUnread' => Mensagens::countUnread()
            ]);
        } else {
            return abort(404);
        }
    }

    // @TODO: verificar isso daqui:
    public function update(Request $request) {
        Carbon::setLocale('pt_BR');
        return $request;
        if (User::where('id_user', $request->id_user)->first()) {
            User::where('id', $request->id_user)->update([
                'nome'      => isset($request->nome) ? $request->nome : $u->nome, 
                'username'  => isset($request->username) ? $request->username : $u->username, 
                'nome' => isset($request->nome) ? $request->nome : $u->nome, 
                'nome' => isset($request->nome) ? $request->nome : $u->nome, 
                'nome' => isset($request->nome) ? $request->nome : $u->nome, 
                'nome' => isset($request->nome) ? $request->nome : $u->nome, 
                'nome' => isset($request->nome) ? $request->nome : $u->nome 
                ]);
        } else {
            //NÃO É USUÁRIO / NÃO LOGADO / HACK / HAUHAUA / JÁ CHEGA
            //Neste caso, sugiro a divisão da tabela users em dois, aluno e professor, pois mais a frente
            //será necessário uma maior manipulação de dados e diferentes relações para funções diferentes para cada tipo de usuario
        }
    }

    public function destroy($id) {
        //
    }

    public function status(Request $request) {
        $request->status = htmlspecialchars($request->status);
        $this->validate($request, ['status' => 'required|max:180']);

        // easter eggs :)
        $pro1 = ['Não', 'Nao', 'Não!', 'Nao!', 'não', 'nao', 'não!', 'nao!'];
        $pro2 = ['Sim', 'Sim!', 'sim', 'sim!'];

        if (in_array($request->status, $pro1)) {
            return Response::json(['error' => 'OK, quando quiser, sinta-e à vontade!']);
        } else if (in_array($request->status, $pro2)) {
            return Response::json(['error' => 'Então vamos lá, compartilhe com seus amigos!']);
        }


        User::where('id', auth()->user()->id)->update(array('status' => $request->status));


        return Response::json(['error' => false, 'status' => $request->status]);
    }

    public function newpost(Request $request) {
        Carbon::setLocale('pt_BR');

        $posts = Post::where('id_user', $request->id_user)
                ->join('users', 'users.id', '=', 'posts.id_user')
                ->orderBy('created_at', 'desc')
                ->select(['posts.id', 'posts.id_user', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.nome', 'users.username'])
                ->where('posts.id', '>', $request->id_post)
                ->get();

        return view('perfil.posts', ['posts' => $posts]);
    }

    public function morepost(Request $request) {
        Carbon::setLocale('pt_BR');

        $n = 5 - $request->tamanho % 5;

        $posts = Post::where('id_user', $request->id_user)
                ->join('users', 'users.id', '=', 'posts.id_user')
                ->orderBy('created_at', 'desc')
                ->limit($n)
                ->select(['posts.id', 'posts.id_user', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.nome', 'users.username'])
                ->where('posts.id', '<', $request->id_post)
                ->get();

        return view('perfil.posts', ['posts' => $posts]);
    }

    public function addAmigo(Request $request) {
        $amizade = new Amizade;
        $verifica = Amizade::verificar($request->id);

        if ($verifica['status']) {
            $amizade->desfazer($request->id);
            return Response::json(['status' => 'cancel']);
        }

        if ($verifica['error'] == "NAO_ACEITOU") {
            $amizade->desfazer($request->id);
            return Response::json(['status' => 'enable']);
        }

        if ($verifica['error'] == "VOCE_NAO_ACEITOU") {
            $amizade->aceitar($request->id);
            return Response::json(['status' => 'success']);
        }

        if ($verifica['error'] == "NAO_AMIGO") {
            $amizade->novo($request->id);
            return Response::json(['status' => 'disable']);
        }
    }

    public function recusarAmigo(Request $request) {
        Amizade::recusar($request->id);
        return Response::json(['status' => 'success']);
    }
}