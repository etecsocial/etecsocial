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
        $this->command->info('Escolas oficiais inseridas no banco de dados');

        // factory desafios
        factory(App\Desafio::class, 10)->create()
        ->each(function($desafio) {
            factory(App\DesafioTurma::class, 20)->create(['desafio_id' => $desafio->id]);
        });
        $this->command->info('Criando 10 desafios aleatorios');

    }
}
