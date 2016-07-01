<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEventos extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('eventos')) {
            Schema::create('eventos', function(Blueprint $table) {
                $table->increments('id');
                $table->string('title')->nullable();
                $table->text('description', 255)->nullable();
                $table->boolean('is_publico')->nullable()->default(false);
                $table->date('start')->nullable();
                $table->date('end')->nullable();
                $table->timestamps();
            });

            //Para o caso de um coordenador adicionar evento para sua escola
            Schema::create('escola_evento', function(Blueprint $table) {
                $table->integer('escola_id')->unsigned()->index();
                $table->foreign('escola_id')->references('id')->on('escolas')->onDelete('cascade');
                $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('cascade');
                $table->integer('evento_id')->unsigned()->index();

                $table->timestamps();
            });

            //Para eventos de turma, criados pelo professor ou por alunos
            Schema::create('turma_evento', function(Blueprint $table) {
                $table->integer('turma_id')->unsigned()->index();
                $table->foreign('turma_id')->references('id')->on('turmas')->onDelete('cascade');
                $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('cascade');
                $table->integer('evento_id')->unsigned()->index();

                $table->timestamps();
            });

            //Não sei se será necessário sempre preencher esta tabela, ou se quando for evento
            //de turma ou da escola já erá suficiente preencher as outras tabelas para amarrar o usuário ao evento
            Schema::create('user_evento', function(Blueprint $table) {
                $table->integer('user_id')->unsigned()->index();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('cascade');
                $table->integer('evento_id')->unsigned()->index();

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('eventos');
        Schema::dropIfExists('turma_evento');
        Schema::dropIfExists('escola_evento');
        Schema::dropIfExists('user_evento');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

}
