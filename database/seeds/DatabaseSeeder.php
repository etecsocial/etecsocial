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

        // factories tests, executa apenas em ambiente de test (local)
        if(env('APP_ENV') == 'local_nao'){
          factory(App\User::class, 'coordenador', 10)->create();
          $this->command->info('Inserindo 10 coordenadores aleatorios');

          factory(App\User::class, 'professor', 10)->create();
          $this->command->info('Inserindo 10 professores aleatorios');

          factory(App\Turma::class, 10)->create();
          $this->command->info('Inserindo 10 turmas aleatorias');

          factory(App\User::class, 'aluno', 10)->create()
            ->each(function($user) {
              \App\AlunosTurma::create(['user_id' => $user->id, 'turma_id' => \App\Turma::orderByRaw('RAND()')->first()->id, 'modulo' => rand(1, 3)]);
            });
          $this->command->info('Inserindo 10 alunos aleatorios');

          factory(App\Tarefa::class, 90)->create();
          $this->command->info('Inserindo tarefas aletorias');

          factory(App\Post::class, 90)->create();
          $this->command->info('Inserindo posts aleatorios');

          factory(App\Comentario::class, 90)->create();
          $this->command->info('Inserindo comentarios aleatorios');

          factory(App\Amizade::class, 50)->create();
          $this->command->info('Criando 50 amizades aleatorias');

          factory(App\Desafio::class, 50)->create()
          ->each(function($desafio) {
              factory(App\DesafioTurma::class, 50)->create(['desafio_id' => $desafio->id]);
          });
          $this->command->info('Criando 50 desafios aleatorios');

        }
    }
}
