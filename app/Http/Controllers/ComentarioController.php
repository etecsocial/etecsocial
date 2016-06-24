<?php

namespace App\Http\Controllers;

use App\Comentario;
use App\ComentarioDiscussao;
use App\Http\Controllers\Controller;
use App\Notificacao;
use App\Post;
use App\RelevanciaComentarios;
use Illuminate\Http\Request;
use Response;

class ComentarioController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        if ($request->comentario == "") {
            return 'empty';
        }

        Post::where('id', $request->id_post)->increment('num_comentarios');

        Comentario::create([
            'id_post'    => $request->id_post,
            'user_id'    => auth()->user()->id,
            'comentario' => $request->comentario,
        ]);

        $post = Post::where('id', $request->id_post)->first();

        if ($post->user_id != auth()->user()->id) {
            Notificacao::create([
                'id_rem'  => auth()->user()->id,
                'id_dest' => $post->user_id,
                'data'    => time(),
                'texto'   => 'Comentou sua publicação',
                'is_post' => true,
                'action'  => '/post/' . $request->id_post,
            ]);
        }

        return view('comentarios.comentario', ['id_post' => $request->id_post, 'id_comentario' => $request->id_comentario]);
    }

    public function editar(Request $request)
    {
        $comentario = Comentario::where('id', $request->id_comentario)->limit(1)->first();
        if (isset($request->novo_comentario) and (auth()->user()->id === $comentario->user_id)) {
            if (!empty($request->novo_comentario)) {
                $comentario->comentario = $request->novo_comentario;
                $comentario->save();
                return Response::json(['status' => true, 'comentario' => $comentario->comentario]);
            }return Response::json(['status' => true, 'empty' => true]);
        }return Response::json(['status' => false]);
    }

    public function editarDiscussao(Request $request)
    {
        $comentario = ComentarioDiscussao::where('id', $request->id_comentario)->limit(1)->first();
        if (isset($request->novo_comentario) and (auth()->user()->id === $comentario->user_id)) {
            $comentario->comentario = $request->novo_comentario;
            $comentario->save();
            return Response::json(['status' => true, 'comentario' => $comentario->comentario]);
        }return Response::json(['status' => false]);
    }

    public function relevancia(Request $request)
    {
        $comentario = Comentario::where('id', $request->id_comentario)->limit(1)->first();
        if (isset($request->rel) and (auth()->user()->id != $comentario->user_id)) {
            $request->rel == 'up' ? $comentario->relevancia += 1 : $comentario->relevancia -= 1;
            $comentario->save();
            if ($rv_ant = RelevanciaComentarios::where('id_usuario', auth()->user()->id)->where('id_comentario', $request->id_comentario)->where('id_post', $request->id_post)->first()) {
                $rv_ant->delete();
            }
            $rv                = new \App\RelevanciaComentarios();
            $rv->id_usuario    = auth()->user()->id;
            $rv->id_comentario = $request->id_comentario;
            $rv->id_post       = $request->id_post;
            $rv->relevancia    = $request->rel == 'up' ? 'up' : 'down';
            return $rv->save() ? Response::json(['status' => true]) : Response::json(['status' => false]);
        }return Response::json(['status' => false]);
    }

    public function destroy($id_comentario)
    {
        if ($comentario = Comentario::where('id', $id_comentario)->first()) {
            if (auth()->user()->id === $comentario->user_id) {
                $post = Post::where('id', $comentario->id_post)->limit(1)->first();
                $post->num_comentarios -= 1;
                $post->save();

                $comentario->delete();

                return Response::json(['status' => 122, 'id' => $comentario->id]);
            }return Response::json(['status' => false]);
        }return Response::json(['status' => 3, 'id' => $id_comentario]); //já excluido
    }

}
