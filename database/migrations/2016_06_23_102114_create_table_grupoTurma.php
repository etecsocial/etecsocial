<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGrupoTurma extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('grupo_turma', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_grupo')->unsigned();
            $table->integer('id_turma')->unsigned();
            $table->tinyInteger('modulo');
            $table->timestamps();

            $table->foreign('id_grupo')
                    ->references('id')
                    ->on('grupo')
                    ->onDelete('cascade');
            
            $table->foreign('id_turma')
                    ->references('id')
                    ->on('turmas')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('grupo_turma');
    }

}
