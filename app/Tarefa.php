<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Tarefa extends Model {

    protected $fillable = [
        'desc',
        'data',
        'data_checked'
    ];

    /**
     * @return \Iluminate\Database\Elequoment\Relations\HasMany
     * @return \Iluminate\Database\Elequoment\Relations\BelongsTo
     */

    public function user() {
        return $this->belongsTo('App\User');
    }
    
    

    public function scopeAtiva($query) {
        $query->where(function($queryy) {
            $queryy->where('data_checked', '>', time() - 3 * 24 * 60 * 60)
                    ->orWhere('checked', false);
        });
    }

    public static function carrega() {
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


        return $tasks;
    }

}
