<?php

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'username' => $faker->username,
        'email_instuticional' => $faker->safeEmail,
        'confirmed' => 1,
        'password' => bcrypt(12345),
        'remember_token' => str_random(10),
        'status' => $faker->sentence(3),
        'birthday' => $faker->date,
    ];
});

$factory->defineAs(App\User::class, 'coordenador', function ($faker) use ($factory) {
    $user = $factory->raw(App\User::class);

    return array_merge($user, ['type' => 3]);
});

$factory->defineAs(App\User::class, 'professor', function ($faker) use ($factory) {
    $user = $factory->raw(App\User::class);

    return array_merge($user, ['type' => 2]);
});

$factory->defineAs(App\User::class, 'aluno', function ($faker) use ($factory) {
    $user = $factory->raw(App\User::class);

    return array_merge($user, ['type' => 1]);
});

$factory->define(App\Turma::class, function (Faker\Generator $faker) {
    return [
        'nome' => function(){
            $courses = ['Ensino Médio Regular', 'Ensino Médio Integrado a Informática',
                        'Ensino Médio Integrado a Mecânica', 'Ensino Médio Integrado ao Meio Ambiente',
                        'Ensino Médio Integrado a Administração'];
            $random_index = rand(0, count($courses) - 1);
            return $courses[$random_index];
        },
        'sigla' => function(){
            $siglas = ['EMB', 'EMIA', 'EMAD', 'EMMEIO', 'EMMEC', 'EMMECA'];
            $random_index = rand(0, count($siglas) - 1);
            return $siglas[$random_index];
        },
        'modulos' => 3,
        'escola_id' => App\Escola::select('id')->orderByRaw('RAND()')->first()->id,
    ];
});

$factory->define(App\Tarefa::class, function (Faker\Generator $faker) {
    return [
        'user_id' => App\User::select('id')->orderByRaw('RAND()')->first()->id,
        'desc' => $faker->sentence(4),
        'data' => strtotime($faker->dateTimeBetween('now', '+1 month')->format('Y-m-d')),
        'checked' => rand(0, 1),
    ];
});

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
        'user_id' => App\User::select('id')->orderByRaw('RAND()')->first()->id,
        'titulo' => $faker->sentence(5),
        'publicacao' => $faker->paragraph(10),
        'num_favoritos' => rand(1, 50),
        'is_question' => rand(0, 1),
        'is_publico' => rand(0, 1),
    ];
});

$factory->define(App\Comentario::class, function (Faker\Generator $faker) {
    return [
        'user_id' => App\User::select('id')->orderByRaw('RAND()')->first()->id,
        'post_id' => App\Post::select('id')->orderByRaw('RAND()')->first()->id,
        'comentario' => $faker->sentence(10),
    ];
});

$factory->define(App\Amizade::class, function (Faker\Generator $faker) {
    return [
        'user_id1' => App\User::select('id')->orderByRaw('RAND()')->first()->id,
        'user_id2' => App\User::select('id')->orderByRaw('RAND()')->first()->id,
        'aceitou' => rand(0, 1),
    ];
});


$factory->define(App\Desafio::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(3),
        'description' => $faker->paragraph(10),
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
        'turma_id' => App\Turma::select('id')->orderByRaw('RAND()')->first()->id,
    ];
});
