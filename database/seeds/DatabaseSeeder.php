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
        $this->call(EtecSeeder::class);
        $this->call(ModulosSeeder::class);
        $this->call(TurmasSeeder::class);
    }
}
