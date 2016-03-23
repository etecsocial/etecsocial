<?php

use Illuminate\Database\Seeder;

class ModulosSeeder extends Seeder
{
    /** 
     * Todos os modulos devem ser colocados aqui
     */
    public $modulos = [
        
        [
            'id' => '1',
            'modulo' => '1',
        ],


        [
            'id' => '2',
            'modulo' => '2',
        ],


        [
            'id' => '3',
            'modulo' => '3',
        ],

    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->modulos as $modulo){
            if(DB::table('modulos')->where('modulo', $modulo['modulo'])->get() == null){
                DB::table('modulos')->insert($modulo);
                echo '[ INFO ] Modulo : ' . $modulo['modulo'] . " adicionado. \n";
            }
        }
    }
}
