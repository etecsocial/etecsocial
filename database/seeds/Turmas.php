<?php

use Illuminate\Database\Seeder;

class Turmas extends Seeder
{
    /** 
     * Todos as turmas devem ser colocados aqui
     */
    public $turmas = [
        
        [
            'id' => 1,
            'nome' => '1 Ensino Médio Integrado a Informática para Internet',
            'sigla' => '1 EMIA',
            'id_escola' => 1,
        ],

        [
            'id' => 2,
            'nome' => '2 Ensino Médio Integrado a Informática para Internet',
            'sigla' => '2 EMIA',
            'id_escola' => 1,
        ],

        [
            'id' => 3,
            'nome' => '3 Ensino Médio Integrado a Informática para Internet',
            'sigla' => '3 EMIA',
            'id_escola' => 1,
        ],

        [
            'id' => 4,
            'nome' => '1 Ensino Médio Integrado a Administração',
            'sigla' => '1 EMAD',
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
                echo '[ INFO ] Turma : ' . e($turma['nome']) . " adicionada. \n";
            }
        }
    }
}
