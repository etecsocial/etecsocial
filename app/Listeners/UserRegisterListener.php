<?php

namespace App\Listeners;

use App\Amizade;
use App\Events\UserRegister;
use App\Grupo;
use App\GrupoUsuario;
use DB;
use Mail;

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
        // adiciona o usuário a ele mesmo
        Amizade::insert(['id_user1' => $event->user->id, 'id_user2' => $event->user->id, 'aceitou' => 1]);

        // adiciona no grupo da sala
        if ($event->user->type == 1) {
            $turma = DB::table('alunos_info')->select('id_turma')->where('user_id', $event->user->id)->limit(1)->first();
            $grupo = Grupo::select('id')->where('id_turma', $turma->id_turma)->limit(1)->first();

            $turma_grupo           = new GrupoUsuario;
            $turma_grupo->id_grupo = $grupo->id; //@TODO: checar se o grupo existe
            $turma_grupo->id_user  = $event->user->id;
            $turma_grupo->save();
        }

        // envia o email de confirmação
        $data = ['name' => $event->user->name, 'email' => $event->user->email, 'confirmation_code' => $event->user->confirmation_code];
        Mail::send('emails.verifica', $data, function ($message) use ($data) {
            $message->from('contato@etecsocial.com.br', 'ETEC Social');
            $message->subject('Confirmação do ETEC Social');
            $message->to($data['email']);
        });
    }
}
