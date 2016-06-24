<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Escolas::class);
        //$this->call(Turma::class);

        //factory(App\Desafio::class, 10)->create();
        //factory(App\DesafioTurma::class, 10)->create();
        
        //acertar isso, chave estrangeira não está deixando editar!
    }
}
