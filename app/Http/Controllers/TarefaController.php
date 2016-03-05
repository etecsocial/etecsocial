<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tarefa;
use Response;
use Auth;
use DB;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;


class TarefaController extends Controller {
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        Carbon::setLocale('pt_BR');
        $tasks = DB::table('tarefas')
                ->select([ 'desc', 'data', 'checked', 'id'])
                ->where('id_user', Auth::user()->id)
                ->where(function($query)
                {
                    $query->where('data_checked', '>', time() - 3*24*60*60)
                          ->orWhere('checked', false);
                })
                ->orderBy('data')
                ->limit(10)
                ->get();

        return view('tarefas.tasks', [ 'tasks' => $tasks]);
    }
    
    public function moretask(Request $request) {
          Carbon::setLocale('pt_BR');
        $tasks = DB::table('tarefas')
                ->select(['desc', 'data', 'checked', 'id'])
                ->where('id_user', Auth::user()->id)
                ->where('data', '>', $request->data)
                ->where(function($query)
                {
                    $query->where('data_checked', '>', time() - 3*24*60*60)
                          ->orWhere('checked', false);
                })
                ->orderBy('data')
                ->limit(10)
                ->get();

        return view('tarefas.more', [ 'tasks' => $tasks]);
    }

    public function check(Request $request) {
        Carbon::setLocale('pt_BR');
        $task = new Tarefa;
        $is_check = $task->where('id', $request->id)->where('checked', true)->count();
        
        if ($is_check) {
            $task->where('id', $request->id)->update(['checked' => false, 'data_checked' => 0]);
            
             return Response::json([ 'status' => false]);
        } else {
            $task->where('id', $request->id)->update(['checked' => true, 'data_checked' => strtotime(date("Y-m-d")) ]);
             return Response::json(['status' => true]);
        }
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        Carbon::setLocale('pt_BR');
        $this->validate($request, ['desc' => 'required|min:3']);

        $exists = DB::table('tarefas')
                ->select('id')
                ->where(['desc' => $request->desc , 'id_user' => Auth::user()->id])
                ->count();
        
         if(!strtotime($request->data)) {
            $request->data = strtotime(date("Y-m-d"));
        }
 
        else if(strtotime($request->data) <= strtotime(date("Y-m-d"))) {
            return Response::json([ 'data' => 'invalid']);
           
        } else {
            $request->data = strtotime($request->data);
        }
        
        if (!$exists) {
            $task = new Tarefa;
            $task->data = $request->data;
            $task->desc = $request->desc;
            $task->id_user = Auth::user()->id;
            $task->save();
            
            return Response::json(['desc' => $task->desc, 'data' => Carbon::createFromTimeStamp($task->data)->format("d/m/Y"), 'cont' => Carbon::createFromTimeStamp($task->data)->diffForHumans(), 'id' => $task->id]);
        } else {
            return Response::json(['exists' => true]);
        }
    }

}
