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
    }
}
