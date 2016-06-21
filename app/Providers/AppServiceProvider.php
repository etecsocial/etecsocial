<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Events\UserRegister;
use App\User;
use App\Grupo;
use App\GrupoUsuario;
use App\Turma;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        User::created(function ($user) {
            event(new UserRegister($user));
        });

        Turma::created(function ($turma) {
            for ($modulo = $turma->modulos; $modulo > 0; $modulo--) {
                $grupo = new Grupo;
                $grupo->nome = $turma->sigla . ' ' . \Carbon\Carbon::today('y');
                $grupo->assunto = "Grupo da turma " . $modulo . "º " . $turma->sigla;
                $grupo->url = $grupo->makeUrl($turma->sigla, $modulo);
                $grupo->id_criador = 1;
                $grupo->num_participantes = 1;
                $grupo->id_turma = $turma->id;
                $grupo->criacao = \Carbon\Carbon::today();
                $grupo->save();

                $grupoUsuario = new GrupoUsuario;
                $grupoUsuario->id_grupo = $grupo->id;
                $grupoUsuario->id_user = 1;
                $grupoUsuario->is_admin = 1;
                $grupoUsuario->save();
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
