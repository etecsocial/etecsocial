<?php

use Illuminate\Database\Seeder;

class TurmasSeeder extends Seeder
{
    /** 
     * Todos as turmas devem ser colocados aqui
     */
    public $turmas = [
        
        [
            'id' => 1,
            'nome' => 'Ensino Médio Integrado a Informática para Internet',
            'sigla' => 'EMIA',
            'id_escola' => 1,
        ],

        [
            'id' => 1,
            'nome' => 'Ensino Médio Integrado a Meio Ambiente',
            'sigla' => 'EMMEIO',
            'id_escola' => 1,
        ],

        [
            'id' => 2,
            'nome' => 'Ensino Médio Integrado a Mecânica',
            'sigla' => 'EMMEC',
            'id_escola' => 1,
        ],

        [
            'id' => 3,
            'nome' => 'Ensino Médio Integrado a Administração',
            'sigla' => 'EMAD',
            'id_escola' => 1,
        ],

        [
            'id' => 4,
            'nome' => 'Ensino Médio Turma A',
            'sigla' => 'EMA',
            'id_escola' => 1,
        ],

        [
            'id' => 5,
            'nome' => 'Ensino Médio Turma B',
            'sigla' => 'EMB',
            'id_escola' => 1,
        ],

        [
            'id' => 6,
            'nome' => 'Ensino Médio Integrado a Informática para Internet RA',
            'sigla' => 'EMIRA',
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
        foreach($this->turmas as $turma){
            if(DB::table('turmas')->where('id', $turma['id'])->get() == null){
                DB::table('turmas')->insert($turma);
                echo '[ INFO ] Turma : ' . $turma['nome'] . " adicionada. \n";
            }
        }
    }
}
