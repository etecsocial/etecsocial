<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAlunosTurma extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('alunos_turma')) {
            Schema::create('alunos_turma', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();

                $table->integer('id_turma')->unsigned();

                $table->integer('modulo')->unsigned();

                $table->timestamps();
                
                //@todo cascade no delete e update
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('alunos_turma');
    }

}
