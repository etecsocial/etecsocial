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
        Amizade::insert(['user_id1' => $event->user->id, 'user_id2' => $event->user->id, 'aceitou' => 1]);

        // adiciona no grupo da sala
        if ($event->user->type == 1) {
            $turma = DB::table('alunos_info')->select('turma_id')->where('user_id', $event->user->id)->limit(1)->first();
            $grupo = Grupo::select('id')->where('turma_id', $turma->turma_id)->limit(1)->first();

            $turma_grupo           = new GrupoUsuario;
            $turma_grupo->grupo_id = $grupo->id; //@TODO: checar se o grupo existe
            $turma_grupo->user_id  = $event->user->id;
            $turma_grupo->save();
        }

        // envia o email de confirmação
//        $data = ['name' => $event->user->name, 'email' => $event->user->email, 'confirmation_code' => $event->user->confirmation_code];
//        Mail::send('emails.verifica', $data, function ($message) use ($data) {
//            $message->from('contato@etecsocial.com.br', 'ETEC Social');
//            $message->subject('Confirmação do ETEC Social');
//            $message->to($data['email']);
//        });
    }
}
