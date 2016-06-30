<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {

    protected $fillable = [
        'name', 'id'
    ];

    /**
     * Get the posts associated whith the given tag.
     * 
     * @return \Iluminate\Database\Elequoment\Relations\BelongsToMany
     */
    public function posts() {
        return $this->belongsToMany('App\Post')->withTimestamps();
    }

}
