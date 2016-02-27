<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;
use Carbon\Carbon;
use Auth;
class Tarefa extends Model
{
    protected $fillable = [
        'desc',
        'data'
    ];
    
    public static function carrega() {
        $tasks = DB::table('tarefas')
                ->select([ 'desc', 'data', 'checked', 'id'])
                ->where("id_user", Auth::user()->id)
                ->where(function($query)
                {
                    $query->where("data_checked", ">", time() - 3*24*60*60)
                          ->orWhere('checked', false);
                })
                ->orderBy('data')
                ->limit(4)
                ->get();
                
                
          return $tasks;
    }
}
