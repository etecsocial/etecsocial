<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Comentario;
use App\Post;
use App\Notificacao;
use Response;
use Auth;

use Carbon\Carbon;

class ComentarioController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
     if($request->comentario == ""){ return 'empty';}
        
        Post::where('id', $request->id_post)->increment('num_comentarios');
      
        Comentario::create([
            'id_post'       => $request->id_post,
            'id_user'       => Auth::user()->id,
            'comentario'    => $request->comentario
        ]);
        
        $post = Post::where('id', $request->id_post)->first();     
        
        if ($post->id_user != Auth::user()->id) {
            Notificacao::create([
                'id_rem' => Auth::user()->id,
                'id_dest' => $post->id_user,
                'data' => time(),
                'texto' =>  'Comentou sua publicação',
                'is_post' => true,
                'action' => '/post/' . $request->id_post,
            ]);
        }

        return view('comentario', [ 'id_post' => $request->id_post, 'id_comentario' => $request->id_comentario ]);
    }


    public function destroy($id_comentario)
    {
        $comentario = Comentario::where('id', $id_comentario)->limit(1)->first();
        
        if (Auth::user()->id === $comentario->id_user) {
            $post = Post::where('id', $comentario->id_post)->limit(1)->first();
            $post->num_comentarios -= 1;
            $post->save();
            
            $comentario->delete();
            
            return Response::json([ 'status' => true, 'id' => $comentario->id  ]);
        }
        
        return Response::json([ 'status' => false ]);
    }
}
