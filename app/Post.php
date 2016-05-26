<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'id',
        'id_user',
        'titulo',
        'publicacao',
        'num_favoritos',
        'num_reposts',
        'num_comentarios',
        'url_midia',
        'is_imagem',
        'is_video',
        'is_publico',
        'is_repost',
    ];

    public static function favoritou($id)
    {
        $count = DB::table('favoritos')
            ->where(["id_post" => $id, "id_user" => auth()->user()->id])
            ->count();

        return isset($count) ? $count : false;
    }
    public static function count()
    {
        $count = DB::table('posts')
            ->where(["id_user" => auth()->user()->id])
            ->count();
        return isset($count) ? $count : 0;
    }
}
