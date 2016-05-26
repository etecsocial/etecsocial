<?php

namespace App\Listeners;

use App\Amizade;
use App\Events\UserRegister;
use App\GrupoUsuario;

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
        $turma_grupo           = new GrupoUsuario;
        $turma_grupo->id_grupo = 1;
        $turma_grupo->id_user  = $event->user->id;
        $turma_grupo->save();
    }
}
