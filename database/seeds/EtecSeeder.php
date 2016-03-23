<?php

use Illuminate\Database\Seeder;

class EtecSeeder extends Seeder
{
    /** 
     * Todos as etecs devem ser colocados aqui
     */
    public $etecs = [
        
        [
            'id_etec' => '1',
            'nome' => 'ETEC Pedro Ferreira Alves',
            'cod_prof' => '2830',
        ],

        [
            'id_etec' => '2',
            'nome' => 'ETEC Euro Albino de Souza',
            'cod_prof' => '1276',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->etecs as $etec){
            if(DB::table('lista_etecs')->where('nome', $etec['nome'])->get() == null){
                DB::table('lista_etecs')->insert($etec);
                echo '[ INFO ] ETEC : ' . $etec['nome'] . " adicionada. \n";
            }
        }
    }
}
