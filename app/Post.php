<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;
use DB;

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
        'is_repost'
    ];
    
    public static function favoritou($id) 
    {
        $count = DB::table('favoritos')
                ->where([ "id_post" => $id, "id_user" => Auth::user()->id ])
                ->count();
         
        if ($count) {
            return true;
        } 
           
        return false;
    }
}
