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

            for ($modulo = 3; $modulo > 0; $modulo--) {
                //Neste caso, ele cria 3 grupos, pois, caso seja curso técnico de 3 semestres, consideramos
                //os semestres como "anos", e quando for 6 semestres, é como se o 1º 2 2º semestre 
                //equivalesse ao 1º semestre de curso técnico, nao sei se deu pra entender...
                $grupo = new Grupo;
                $grupo->nome = $turma->sigla . ' ' . date('Y');
                $grupo->assunto = "Grupo da turma " . $modulo . "º " . $turma->sigla;
                $grupo->url = $grupo->makeUrl($turma->sigla, $modulo);
                $grupo->id_criador = auth()->user()->id;
                $grupo->num_participantes = 1;
                $grupo->id_turma = $turma->id;
                $grupo->criacao = \Carbon\Carbon::today();
                $grupo->save();

                    $grupoUsuario = new GrupoUsuario;
                    $grupoUsuario->id_grupo = $grupo->id;
                    $grupoUsuario->id_user = auth()->user()->id;
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
