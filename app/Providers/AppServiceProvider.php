<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Events\UserRegister;
use App\User;
use App\Grupo;
use App\GrupoUsuario;
use App\Turma;
use App\GrupoTurma;

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
                $grupo = $this->setGrupo($turma, $modulo);

                ($turma->modulos == 3) ? $this->grupoTurma($grupo, $turma->id, $modulo) : $this->grupoTurmas($grupo, $turma->id, $modulo);
            }
        });

        Grupo::created(function ($data) {
            GrupoUsuario::create([
                'id_grupo' => $data->id,
                'id_user' => auth()->user()->id,
                'is_admin' => 1
            ]);
        });



        GrupoUsuario::created(function ($data) {
            Grupo::where('id', $data->id_grupo)->increment('num_participantes');
        });
        GrupoUsuario::deleted(function ($data) {
            Grupo::where('id', $data->id_grupo)->decrement('num_participantes');
        });
        GrupoUsuario::updated(function ($data) {
            isset($data->is_banido) ? Grupo::where('id', $data->id_grupo)->decrement('num_participantes') : false;
        });
        \App\GrupoDiscussao::deleted(function ($data) {
            //como fazer para pegar o id do grupo cuja discussão já foi excluida? Parece que neste caso ele no passa
            //os dados antigos da tabela excluida...
            Grupo::where('id', $data->id_grupo)->decrement('num_discussoes');
        });
        \App\GrupoDiscussao::created(function ($data) {
            Grupo::where('id', $data->id_grupo)->increment('num_discussoes');
        });
        \App\GrupoPergunta::deleted(function ($data) {
            Grupo::where('id', $data->id_grupo)->decrement('num_perguntas');
        });
        \App\GrupoPergunta::created(function ($data) {
            Grupo::where('id', $data->id_grupo)->increment('num_perguntas');
        });
    }

    public function setGrupo($turma, $modulo) {
        //Neste caso, ele cria 3 grupos, pois, caso seja curso técnico de 3 semestres, consideramos
        //os semestres como "anos", e quando for 6 semestres, é como se o 1º 2 2º semestre 
        //equivalesse ao 1º semestre de curso técnico, nao sei se deu pra entender...
        $grupo = Grupo::create([
                    'nome' => $turma->sigla . ' ' . date('Y'),
                    'assunto' => "Grupo da turma " . $modulo . "º " . $turma->sigla,
                    'url' => Grupo::makeUrl($turma->sigla, $modulo),
                    'id_criador' => auth()->user()->id,
                    'num_participantes' => 1,
                    'id_turma' => $turma->id, // REMOVER ESTE CAMPO DEPOIS, AGORA TEM O GRUPO_TURMA!!!
        ]);
        GrupoUsuario::create([
            'id_grupo' => $grupo->id,
            'id_user' => auth()->user()->id,
            'is_admin' => 1
        ]);
        return $grupo->id;
    }

    public function grupoTurma($grupo, $turma, $modulo) {
        GrupoTurma::create([
            'id_grupo' => $grupo,
            'id_turma' => $turma,
            'modulo' => $modulo
        ]);
    }

    public function grupoTurmas($grupo, $turma, $modulo) {
        GrupoTurma::create([
            'id_grupo' => $grupo,
            'id_turma' => $turma,
            'modulo' => $modulo
        ]);
        GrupoTurma::create([
            'id_grupo' => $grupo,
            'id_turma' => $turma,
            'modulo' => $modulo + 1
        ]);
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
