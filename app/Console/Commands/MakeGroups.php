<?php

namespace App\Console\Commands;

use App\GrupoUsuario;
use App\Turma;
use Illuminate\Console\Command;

class MakeGroups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'group:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria todos os grupos padroes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (Turma::all() as $turma) {
            $grupo                    = new \App\Grupo;
            $grupo->nome              = $turma->sigla;
            $grupo->assunto           = "Grupo da turma " . $turma->nome;
            $grupo->url               = $grupo->makeUrl($turma->sigla);
            $grupo->id_criador        = 1;
            $grupo->num_participantes = 1;
            $grupo->id_turma          = $turma->id;
            $grupo->criacao           = \Carbon\Carbon::today();
            $grupo->save();

            $grupoUsuario           = new \App\GrupoUsuario;
            $grupoUsuario->id_grupo = $grupo->id;
            $grupoUsuario->id_user  = 1;
            $grupoUsuario->is_admin = 1;
        }
    }

}
