<?php

namespace App\Http\Controllers;

use App\Amizade;
use App\Http\Controllers\Controller;
use App\Mensagens;
use App\Post;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Response;

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
                        ->join('alunos_info', 'users.id', '=', 'alunos_info.user_id')
                        ->join('turmas', 'turmas.id', '=', 'alunos_info.turma_id')
                        ->join('escolas', 'escolas.id', '=', 'turmas.escola_id')
                        ->select(['users.id', 'users.status', 'users.name AS nome_usuario', 'users.username', 'users.type', 'escolas.nome as nome_etec', 'turmas.sigla', 'turmas.nome as nome_curso', 'created_at'])
                        ->limit(1)
                        ->first();
            } else {
                $dados = User::where('username', $username)
                        ->select(['users.id', 'users.status', 'users.name AS nome_usuario', 'users.username', 'users.type', 'created_at'])
                        ->limit(1)
                        ->first();
            }
            $amizade = Amizade::verificar($dados->id);

            if ($amizade['status']) {

                $posts = User::find($dados->id)->posts;
//                    ->orderBy('created_at', 'desc')
//                    ->limit(5)
//                    ->get();
            } else {
                $posts = Post::where('user_id', $dados->id)
                        ->join('users', 'users.id', '=', 'posts.user_id')
                        ->orderBy('created_at', 'desc')
                        ->select(['posts.id', 'posts.user_id', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.name', 'users.username'])
                        ->where("posts.is_publico", 1)
                        ->limit(5)
                        ->get();
            }

            $num_amigos = DB::table('amizades')->where(['user_id1' => $dados->id, 'aceitou' => 1])->count() - 1;
            $num_grupos = DB::table('grupo_usuario')->where(['user_id' => auth()->user()->id])->count();

            Carbon::setLocale('pt_BR');
            $tasks = DB::table('tarefas')
                    ->select(['desc', 'data', 'checked', 'id'])
                    ->where("user_id", auth()->user()->id)
                    ->where(function ($query) {
                        $query->where("data_checked", ">", time() - 3 * 24 * 60 * 60)
                        ->orWhere('checked', false);
                    })
                    ->orderBy('data')
                    ->limit(4)
                    ->get();

            return view('perfil.home', [
                'user' => $dados,
                'is_my' => (auth()->user()->id == $dados->id) ? 1 : 0,
                'posts' => $posts->toArray(),
                'num_amigos' => $num_amigos,
                'num_grupos' => $num_grupos,
                'amizade' => $amizade,
                'tasks' => $tasks
            ]);
        } else {
            return abort(404);
        }
    }

    // @TODO: verificar isso daqui:
//    public function update(Request $request) {
//        Carbon::setLocale('pt_BR');
//        return $request;
//        if (User::where('user_id', $request->user_id)->first()) {
//            User::where('id', $request->user_id)->update([
//                'nome' => isset($request->nome) ? $request->nome : $u->nome,
//                'username' => isset($request->username) ? $request->username : $u->username,
//                'nome' => isset($request->nome) ? $request->nome : $u->nome,
//                'nome' => isset($request->nome) ? $request->nome : $u->nome,
//                'nome' => isset($request->nome) ? $request->nome : $u->nome,
//                'nome' => isset($request->nome) ? $request->nome : $u->nome,
//                'nome' => isset($request->nome) ? $request->nome : $u->nome,
//            ]);
//        } else {
//            //algum erro aqui, qualquer instrução se torna inacessível nesta seção.
//        }
//    }
    //QUE HORROR!

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
            return Response::json(['error' => 'Que triste...']);
        } else if (in_array($request->status, $pro2)) {
            return Response::json(['error' => 'Então compartilhe com seus amigos!']);
        }

        User::where('id', auth()->user()->id)->update(array('status' => $request->status));

        return Response::json(['error' => false, 'status' => $request->status]);
    }

    public function newpost(Request $request) {
        Carbon::setLocale('pt_BR');

        $posts = Post::where('user_id', $request->user_id)
                ->join('users', 'users.id', '=', 'posts.user_id')
                ->orderBy('created_at', 'desc')
                ->select(['posts.id', 'posts.user_id', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.name', 'users.username'])
                ->where('posts.id', '>', $request->post_id)
                ->get();

        return view('perfil.posts', ['posts' => $posts]);
    }

    public function morepost(Request $request) {
        Carbon::setLocale('pt_BR');

        $n = 5 - $request->tamanho % 5;

        $posts = Post::where('user_id', $request->user_id)
                ->join('users', 'users.id', '=', 'posts.user_id')
                ->orderBy('created_at', 'desc')
                ->limit($n)
                ->select(['posts.id', 'posts.user_id', 'posts.publicacao', 'posts.titulo', 'posts.num_favoritos', 'posts.num_reposts', 'posts.num_comentarios', 'posts.url_midia', 'posts.is_imagem', 'posts.is_video', 'posts.is_repost', 'posts.id_repost', 'posts.user_repost', 'posts.created_at', 'users.name', 'users.username'])
                ->where('posts.id', '<', $request->post_id)
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
