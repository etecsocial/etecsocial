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
            $grupos = $this->setGrupo($turma->sigla);
            ($turma->modulos == 3) ? $this->grupoTurma($grupos, $turma->id) : $this->grupoTurmas($grupos, $turma->id);
        });



        Grupo::created(function ($data) {
            GrupoUsuario::create([
                'grupo_id' => $data->id,
                'user_id' => auth()->user()->id,
                'is_admin' => 1
            ]);
        });



        GrupoUsuario::created(function ($data) {
            Grupo::where('id', $data->grupo_id)->increment('num_participantes');
        });
        GrupoUsuario::deleted(function ($data) {
            Grupo::where('id', $data->grupo_id)->decrement('num_participantes');
        });
        GrupoUsuario::updated(function ($data) {
            isset($data->is_banido) ? Grupo::where('id', $data->grupo_id)->decrement('num_participantes') : false;
        });
        \App\GrupoDiscussao::deleted(function ($data) {
            //como fazer para pegar o id do grupo cuja discussão já foi excluida? Parece que neste caso ele no passa
            //os dados antigos da tabela excluida...
            Grupo::where('id', $data->grupo_id)->decrement('num_discussoes');
        });
        \App\GrupoDiscussao::created(function ($data) {
            Grupo::where('id', $data->grupo_id)->increment('num_discussoes');
        });
        \App\GrupoPergunta::deleted(function ($data) {
            Grupo::where('id', $data->grupo_id)->decrement('num_perguntas');
        });
        \App\GrupoPergunta::created(function ($data) {
            Grupo::where('id', $data->grupo_id)->increment('num_perguntas');
        });
    }

    public function setGrupo($sigla) {
        //Neste caso, ele cria 3 grupos, pois, caso seja curso técnico de 3 semestres, consideramos
        //os semestres como "anos", e quando for 6 semestres, é como se o 1º e 2º semestre 
        //equivalesse ao 1º semestre de curso técnico, nao sei se deu pra entender...
        for ($i = 3; $i > 0; $i--) {
            $grupos[] = Grupo::create([
                        'nome' => $sigla . ' ' . date('Y'),
                        'assunto' => "Grupo da turma " . $i . "º " . $sigla,
                        'url' => Grupo::makeUrl($sigla, $i),
                        'id_criador' => auth()->user()->id
            ]);
        }return $grupos;
    }

    public function grupoTurma($grupos, $turma, $modulo = 1) {
        foreach ($grupos as $grupo) {
            GrupoTurma::create([
                'grupo_id' => $grupo->id,
                'turma_id' => $turma,
                'modulo' => $modulo
            ]);
            $modulo++;
        }
    }

    public function grupoTurmas($grupos, $turma, $modulo = 1) {
        foreach ($grupos as $grupo) {
            GrupoTurma::create([
                'grupo_id' => $grupo->id,
                'turma_id' => $turma,
                'modulo' => $modulo
            ]);
            GrupoTurma::create([
                'grupo_id' => $grupo->id,
                'turma_id' => $turma,
                'modulo' => $modulo+1
            ]);
            $modulo = $modulo+2;
        }return true;
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
