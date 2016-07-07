<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model {

    protected $fillable = [
        'post_id',
        'user_id',
        'comentario',
    ];

    /**
     * @return \Iluminate\Database\Elequoment\Relations\BelongsTo
     */
    public function post() {
        return $this->belongsTo('App\Post');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public static function loadComentarios($post_id) {
        return Comentario::where('post_id', $post_id)
                        ->get();
    }

}
