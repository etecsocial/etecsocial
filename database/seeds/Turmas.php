<?php

use Illuminate\Database\Seeder;
use App\Turma;

class Turmas extends Seeder
{
    /**
     * Todos as turmas devem ser colocados aqui
     */
    public $turmas = [

        [
            'id'        => 1,
            'nome'      => '1 Ensino Médio Integrado a Informática para Internet',
            'sigla'     => '1 EMIA',
            'id_escola' => 1,
        ],

        [
            'id'        => 2,
            'nome'      => '2 Ensino Médio Integrado a Informática para Internet',
            'sigla'     => '2 EMIA',
            'id_escola' => 1,
        ],

        [
            'id'        => 3,
            'nome'      => '3 Ensino Médio Integrado a Informática para Internet',
            'sigla'     => '3 EMIA',
            'id_escola' => 1,
        ],

        [
            'id'        => 4,
            'nome'      => '1 Ensino Médio Integrado a Administração',
            'sigla'     => '1 EMAD',
            'id_escola' => 1,
        ],

        [
            'id'        => 5,
            'nome'      => '2 Ensino Médio Integrado a Administração',
            'sigla'     => '2 EMAD',
            'id_escola' => 1,
        ],

        [
            'id'        => 6,
            'nome'      => '3 Ensino Médio Integrado a Administração',
            'sigla'     => '3 EMAD',
            'id_escola' => 1,
        ],

        [
            'id'        => 7,
            'nome'      => '2 Ensino Médio A',
            'sigla'     => '2 EMA',
            'id_escola' => 1,
        ],

        [
            'id'        => 8,
            'nome'      => '3 Ensino Médio A',
            'sigla'     => '3 EMA',
            'id_escola' => 1,
        ],

        [
            'id'        => 9,
            'nome'      => '2 Ensino Médio B',
            'sigla'     => '2 EMB',
            'id_escola' => 1,
        ],

        [
            'id'        => 10,
            'nome'      => '3 Ensino Médio B',
            'sigla'     => '3 EMB',
            'id_escola' => 1,
        ],

        [
            'id'        => 11,
            'nome'      => '1 Ensino Médio Integrado ao Meio Ambiente',
            'sigla'     => '1 EMMEIO',
            'id_escola' => 1,
        ],

        [
            'id'        => 12,
            'nome'      => '2 Ensino Médio Integrado ao Meio Ambiente',
            'sigla'     => '2 EMMEIO',
            'id_escola' => 1,
        ],

        [
            'id'        => 13,
            'nome'      => '3 Ensino Médio Integrado ao Meio Ambiente',
            'sigla'     => '3 EMMEIO',
            'id_escola' => 1,
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->turmas as $turma) {
            if(!Turma::where('id', $turma['id'])->first()){
              $db_turma = new Turma;
              $db_turma->nome = $turma['nome'];
              $db_turma->sigla = $turma['sigla'];
              $db_turma->id_escola = $turma['id_escola'];
              if($db_turma->save()){
                $this->command->info('Turma: ' . e($turma['nome']) . 'adicionada. ');
              }

            }
        }
    }
}
