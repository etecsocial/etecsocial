<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Desafio::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(3),
        'description' => $faker->paragraph(4),
        'subject' => function(){
            $subjects = ['Português', 'Matemática', 'Biologia', 'Geografia', 'Inglês', 'História', 'Espanhol'];
            $random_index = rand(0, count($subjects) - 1);
            return $subjects[$random_index];
        },
        'finish' => $faker->dateTimeThisMonth,
        'reward_points' => rand(80, 1000),
        'responsible_id' => function(){
            $professor = App\User::select('id')->where('type', 2)->orderByRaw('RAND()')->first();
            if($professor){
              return $professor->id;
            } else {
              return 1;
            }
        },
    ];
});

$factory->define(App\DesafioTurma::class, function (Faker\Generator $faker) {
    return [
        'desafio_id' => App\Desafio::select('id')->orderByRaw('RAND()')->first()->id,
        'turma_id' => App\Turma::select('id')->orderByRaw('RAND()')->first()->id,
    ];
});
