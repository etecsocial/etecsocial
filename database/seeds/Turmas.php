<?php

use Illuminate\Database\Seeder;

class Turmas extends Seeder
{
    /**
     * Todos as turmas devem ser colocados aqui
     */
    public $turmas = [

        [
            'nome'      => '1 Ensino Médio Integrado a Informática para Internet',
            'sigla'     => '1 EMIA',
            'id_escola' => 1,
        ],

        [
            'nome'      => '2 Ensino Médio Integrado a Informática para Internet',
            'sigla'     => '2 EMIA',
            'id_escola' => 1,
        ],

        [
            'nome'      => '3 Ensino Médio Integrado a Informática para Internet',
            'sigla'     => '3 EMIA',
            'id_escola' => 1,
        ],

        [
            'nome'      => '1 Ensino Médio Integrado a Administração',
            'sigla'     => '1 EMAD',
            'id_escola' => 1,
        ],

        [
            'nome'      => '2 Ensino Médio Integrado a Administração',
            'sigla'     => '2 EMAD',
            'id_escola' => 1,
        ],

        [
            'nome'      => '3 Ensino Médio Integrado a Administração',
            'sigla'     => '3 EMAD',
            'id_escola' => 1,
        ],

        [
            'nome'      => '2 Ensino Médio A',
            'sigla'     => '2 EMA',
            'id_escola' => 1,
        ],

        [
            'nome'      => '3 Ensino Médio A',
            'sigla'     => '3 EMA',
            'id_escola' => 1,
        ],

        [
            'nome'      => '2 Ensino Médio B',
            'sigla'     => '2 EMB',
            'id_escola' => 1,
        ],

        [
            'nome'      => '3 Ensino Médio B',
            'sigla'     => '3 EMB',
            'id_escola' => 1,
        ],

        [
            'nome'      => '1 Ensino Médio Integrado ao Meio Ambiente',
            'sigla'     => '1 EMMEIO',
            'id_escola' => 1,
        ],

        [
            'nome'      => '2 Ensino Médio Integrado ao Meio Ambiente',
            'sigla'     => '2 EMMEIO',
            'id_escola' => 1,
        ],

        [
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
            if (DB::table('turmas')->where('id', $turma['id'])->get() == null) {
                DB::table('turmas')->insert($turma);
                echo '[ INFO ] Turma : ' . e($turma['nome']) . " adicionada. \n";
            }
        }
    }
}
