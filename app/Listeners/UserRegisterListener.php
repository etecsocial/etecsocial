<?php

namespace App\Listeners;

use App\Events\UserRegister;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Amizade;
use App\GrupoUsuario;
use App\Tarefa;

class UserRegisterListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRegister  $event
     * @return void
     */
    public function handle(UserRegister $event)
    {
        Amizade::insert(['id_user1' => $event->user->id, 'id_user2' => $event->user->id, 'aceitou' => 1]);
        $turma_grupo = new GrupoUsuario;
        $turma_grupo->id_grupo = 1;
        $turma_grupo->id_user = $event->user->id;
        $turma_grupo->save();

        $tarefas = ['Adicionar próximas provas na agenda', 'Adicionar atividades para essa semana'];

        foreach($tarefas as $tarefa){
            $task= new Tarefa;
            $task->desc = $tarefa;
            $task->id_user = $event->user->id;
            $task->save();    
        }           
    }
}
