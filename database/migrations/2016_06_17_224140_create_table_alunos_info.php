<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAlunosInfo extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('alunos_info')) {
            Schema::create('alunos_info', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                //$table->foreign('user_id')->references('id')->on('users');

                $table->integer('id_turma')->unsigned();
                //$table->foreign('id_turma')->references('id')->on('turmas');

                $table->integer('id_escola')->unsigned();
                //$table->foreign('id_escola')->references('id')->on('escolas');

                $table->integer('modulo')->unsigned();

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
        Schema::dropIfExists('alunos_info');
    }

}
